<?php

namespace backend\modules\movie\models\search;

use backend\modules\movie\models\FilmChoiceUser;
use backend\modules\movie\models\Filmmaker;
use backend\modules\movie\models\FilmmakerRoleConn;
use backend\modules\movie\models\FilmProperty;
use backend\modules\movie\models\FilmRecommend;
use backend\modules\movie\models\FilmRecommendUser;
use backend\modules\movie\models\FilmTypeConn;
use backend\modules\movie\models\MovieOnlineResource;
use backend\modules\movie\services\MovieListService;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\movie\models\Movie;


/**
 * MovieSearch represents the model behind the search form about `app\modules\movie\models\Movie`.
 */
class MovieSearch extends Movie
{
    /**
     * @inheritdoc
     */

    //search field from external table
    public $film_type,$film_property;

//    public $isFilmmakerWork;
    public $filmmaker_id;

    //用于用户可能喜欢的推荐
    public $user_id;
    public function rules()
    {
        return [
            [['id', 'pic_id', 'release_year', 'comment_num', 'episodes', 'single_running_time','release_timestamp','film_type','film_property','user_id'], 'integer'],
            [['movie_url', 'title', 'director', 'screen_writer', 'actor', 'type', 'producer_country', 'language', 'release_date', 'alias', 'imdb', 'imdb_title', 'official_website', 'premiere', 'running_time'], 'string'],
            [['score', 'one_star', 'two_star', 'three_star', 'four_star', 'five_star'], 'number'],
            ['filmmaker_id','exist','targetClass' => Filmmaker::className(),'targetAttribute' => 'id'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Movie::find();
        //有很多还未上映的片子,好几年后的影片信息都不全,就不显示了
        if(!$this->filmmaker_id) {
            $query->andFilterWhere(['<=', 'release_year', date('Y')]);
            // add conditions that should always apply here
        }
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['release_timestamp' => SORT_DESC]]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'pic_id' => $this->pic_id,
            'release_year' => $this->release_year,
            'comment_num' => $this->comment_num,
            'score' => $this->score,
            'one_star' => $this->one_star,
            'two_star' => $this->two_star,
            'three_star' => $this->three_star,
            'four_star' => $this->four_star,
            'five_star' => $this->five_star,
            'episodes' => $this->episodes,
            'single_running_time' => $this->single_running_time,
        ]);
//
        $query->andFilterWhere(['like', 'movie_url', $this->movie_url])
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'director', $this->director])
            ->andFilterWhere(['like', 'screen_writer', $this->screen_writer])
            ->andFilterWhere(['like', 'actor', $this->actor])
            ->andFilterWhere(['like', 'type', $this->type])
            ->andFilterWhere(['like', 'producer_country', $this->producer_country])
            ->andFilterWhere(['like', 'language', $this->language])
            ->andFilterWhere(['like', 'release_date', $this->release_date])
            ->andFilterWhere(['like', 'alias', $this->alias])
            ->andFilterWhere(['like', 'imdb', $this->imdb])
            ->andFilterWhere(['like', 'imdb_title', $this->imdb_title])
            ->andFilterWhere(['like', 'official_website', $this->official_website])
            ->andFilterWhere(['like', 'premiere', $this->premiere])
            ->andFilterWhere(['like', 'running_time', $this->running_time]);
        if($this->film_type){
            //join the type_conn for searching
            $query->join('join',FilmTypeConn::tableName(),Movie::tableName().'.id = '.FilmTypeConn::tableName().'.movie_id' )->andFilterWhere([FilmTypeConn::tableName().'.type_id' => $this->film_type]);

        }

        if($this->filmmaker_id){
            $query->andWhere(['id' => FilmmakerRoleConn::getFilmmakerWorkNum($this->filmmaker_id)]);

        }
        //todo  这里以后要整合成一个query类 要和前台接口的数据保持一致 现在是分开写的 前台接口的列表是timeline格式所有和后台的query不太一样 需要思考一下
        if($this->film_property){
            switch ($this->film_property) {
                case FilmProperty::PROPERTY_NEWEST:
                    $query = $query->join('join', MovieOnlineResource::tableName(), Movie::tableName() . '.id=' . MovieOnlineResource::tableName() . '.movie_id')
                        ->join('left join', FilmProperty::tableName(), Movie::tableName() . '.id=' . FilmProperty::tableName() . '.movie_id')
                        ->andWhere(['or', ['property' => $this->film_property], ['property' => null]])
                        ->groupBy('movie.id')
                        ->propertyNewestSequence();
                    break;
                case FilmProperty::PROPERTY_SELECTED:
                    $query = $query
//                        ->join('join', MovieOnlineResource::tableName(), Movie::tableName() . '.id=' . MovieOnlineResource::tableName() . '.movie_id')
                        ->join('left join', FilmProperty::tableName(), Movie::tableName() . '.id=' . FilmProperty::tableName() . '.movie_id')
                        ->andWhere(['or', ['property' => $this->film_property], ['property' => null]])
                        ->releaseTimestampSequence();
                    break;
                case FilmProperty::PROPERTY_HOT:
                    $query->join('left join', FilmProperty::tableName(), Movie::tableName() . '.id=' . FilmProperty::tableName() . '.movie_id')
                        ->andWhere(['resource' => self::RESOURCE_NO])
                        ->andWhere(['or', ['property' => $this->film_property], ['property' => null]])
                        ->propertyHotSequence();
                    break;
                case FilmProperty::PROPERTY_RECOMMEND_OFFICIAL:
                    $query = $query->join('join', FilmProperty::tableName(), Movie::tableName() . '.id=' . FilmProperty::tableName() . '.movie_id')
                        ->where(['or', ['property' => $this->film_property], ['property' => null]]);
//                        ->orderBy('rand()');
//                    ->propertyHotSequence();
                    break;
                default :
                    throw new \yii\web\HttpException(
                        400, "movie list doesn't have this property",
                        \common\components\ResponseCode::INVALID_MOVIE_LIST_PROPERTY
                    );
            }
        }

        if($this->user_id){
            //todo 这里要整合一下流程 现在比较乱
            $gt3MovieIds = FilmRecommendUser::getGT3MovieIds($this->user_id);
            $recommendMovieIds = [];
            foreach($gt3MovieIds as $eachMovieId) {
                $recommendMovieIds = array_merge($recommendMovieIds,FilmRecommend::find()->select('recommend_movie_id')
                    ->where(['movie_id' => $eachMovieId])
                    //加入已看的电影 不再展现
                    ->andWhere(['not', ['recommend_movie_id' => FilmChoiceUser::getMovieIds(FilmChoiceUser::TYPE_WANT, $this->user_id)]])
                    ->groupBy('recommend_movie_id')
                    ->column());
            }
            $waitSeeMovieIds = FilmRecommendUser::find()->select('movie_id')->where(['user_id' => $this->user_id,'choice' => FilmRecommendUser::CHOICE_DEFAULT])->column();

            $query
                ->where([Movie::tableName().'.id' => array_merge($recommendMovieIds,$waitSeeMovieIds)])
//                    [FilmRecommendUser::tableName().'.user_id' => $this->user_id,FilmRecommendUser::tableName().'.choice' => [FilmRecommendUser::CHOICE_DEFAULT]],

//                ->andWhere(['not',[Movie::tableName().'.id' => FilmChoiceUser::getMovieIds(FilmChoiceUser::TYPE_WANT,$this->user_id)]])
//                ->orWhere([Movie::tableName().'.id' => $recommendMovieIds])
                ->groupBy('movie.id')
            ;
        }
        return $dataProvider;
    }

    protected function getService()
    {
        if ($this->_service === null) {
            $this->_service = new MovieListService();
        }

        return $this->_service;
    }
}
