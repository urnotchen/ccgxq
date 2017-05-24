<?php
/**
 * Created by PhpStorm.
 * User: chenxi
 * Date: 2017/5/19
 * Time: 18:44
 */
namespace frontend\modules\v1\services;
use frontend\modules\v1\models\FilmChoiceUser;
use frontend\modules\v1\models\Movie;
use frontend\modules\v1\models\FilmProperty;
use frontend\modules\v1\models\MovieIndex;
use yii\data\ActiveDataProvider;
use frontend\modules\v1\models\FilmRecommendUser;
use frontend\modules\v1\models\FilmRecommend;
use yii\db\Query;

class MovieListService extends  \common\services\MovieListService{

    public function movieList($property)
    {
        switch ($property) {
            case FilmProperty::PROPERTY_NEWEST:
                $query = Movie::find()->join('join', MovieIndex::tableName(), Movie::tableName() . '.id=' . MovieIndex::tableName() . '.douban')
                    ->join('left join', FilmProperty::tableName(), Movie::tableName() . '.id=' . FilmProperty::tableName() . '.movie_id')
                    ->andWhere(['or', ['property' => $property], ['property' => null]])
                    ->propertyNewestSequence();
                break;
            case FilmProperty::PROPERTY_SELECTED:
                $query = Movie::find()->join('join', MovieIndex::tableName(), Movie::tableName() . '.id=' . MovieIndex::tableName() . '.douban')
                    ->join('left join', FilmProperty::tableName(), Movie::tableName() . '.id=' . FilmProperty::tableName() . '.movie_id')
                    ->andWhere(['or', ['property' => $property], ['property' => null]])
                    ->releaseTimestampSequence();
                break;
            case FilmProperty::PROPERTY_HOT:
                $query =Movie::find()->join('left join', FilmProperty::tableName(), Movie::tableName() . '.id=' . FilmProperty::tableName() . '.movie_id')
                    ->where(['or', ['property' => $property], ['property' => null]])
                    ->propertyHotSequence();
                break;
            case FilmProperty::PROPERTY_RECOMMEND_OFFICIAL:
                $query = Movie::find()->join('join', FilmProperty::tableName(), Movie::tableName() . '.id=' . FilmProperty::tableName() . '.movie_id')
                    ->where(['or', ['property' => $property], ['property' => null]])
                    ->propertyHotSequence();
                break;
            default :
                throw new \yii\web\HttpException(
                    400, "movie list doesn't have this property",
                    \common\components\ResponseCode::INVALID_MOVIE_LIST_PROPERTY
                );
        }
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'defaultPageSize' => 10,
            ]
        ]);
        return $dataProvider;
    }

    /*
     * 电影斩用户个人推荐
     * */
    public function userRecommend($user_id){

        $query = Movie::find();
        $subQuery = (new Query())->select('recommend_movie_id')->from(FilmRecommendUser::tableName())
            ->join('join',FilmRecommend::tableName(),FilmRecommend::tableName().'.movie_id='.FilmRecommendUser::tableName().'.movie_id')
            ->where([FilmRecommendUser::tableName().'.user_id' => $user_id])
            ->andWhere([FilmRecommendUser::tableName().'.status' => FilmRecommendUser::STATUS_WAIT_RECOMMEND])
            ->createCommand()->getRawSql();

        $query->join('join',"({$subQuery}) as k",'movie.id = '.'k.recommend_movie_id')->limit(13);
//        return $query->createCommand()->getRawSql();
//        $query = 'select movie.* from film_recommend_user join film_recommend on film_recommend_user.movie_id = film_recommend.movie_id join movie on movie.id=film_recommend.recommend_movie_id where user_id = 2 and status = 1;';
        return new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'defaultPageSize' => 20,
            ]
        ]);
    }

    /*
     * 用户个人电影数据列表
     * */
    public function userChoiceList($user_id,$type){

        $query = Movie::find()
            ->join('join',FilmChoiceUser::tableName(),FilmChoiceUser::tableName().'.movie_id='.Movie::tableName().'.id')
            ->where([FilmChoiceUser::tableName().'.type' => $type,FilmChoiceUser::tableName().'.user_id' => $user_id])
            ->andWhere(['not',[FilmChoiceUser::tableName().'status' => FilmChoiceUser::STATUS_TRASH]])
            ->orderBy([FilmChoiceUser::tableName().'.updated_at' => SORT_DESC]);

        return new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'defaultPageSize' => 10,
            ],
        ]);
    }


}