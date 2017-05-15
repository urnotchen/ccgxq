<?php

namespace backend\modules\movie\models\search;

use backend\modules\movie\models\FilmTypeConn;
use common\models\FilmProperty;
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

    public function rules()
    {
        return [
            [['id', 'pic_id', 'release_year', 'comment_num', 'episodes', 'single_running_time','release_timestamp','film_type','film_property'], 'integer'],
            [['movie_url', 'title', 'director', 'screen_writer', 'actor', 'type', 'producer_country', 'language', 'release_date', 'alias', 'imdb', 'imdb_title', 'official_website', 'premiere', 'running_time', 'synopsis'], 'safe'],
            [['score', 'one_star', 'two_star', 'three_star', 'four_star', 'five_star'], 'number'],
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
        $query->andFilterWhere(['<=','release_year',date('Y')]);
        // add conditions that should always apply here

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
            ->andFilterWhere(['like', 'running_time', $this->running_time])
            ->andFilterWhere(['like', 'synopsis', $this->synopsis]);
        if($this->film_type){
            //join the type_conn for searching
            $query->join('join',FilmTypeConn::tableName(),Movie::tableName().'.id = '.FilmTypeConn::tableName().'.movie_id' )->andFilterWhere([FilmTypeConn::tableName().'.type_id' => $this->film_type]);

        }
        if($this->film_property){
            //join the film_property for searching
            $query->join('join',FilmProperty::tableName(),Movie::tableName().'.id='. FilmProperty::tableName().'.movie_id' )->andFilterWhere([FilmProperty::tableName().'.property' => $this->film_property])->andWhere(['not',[FilmProperty::tableName().'.status' => FilmProperty::STATUS_TRASH]]);
            //order
            switch($this->film_property){
                case FilmProperty::PROPERTY_SELECTED:
                    $query->orderBy(['release_timestamp' => SORT_DESC]);break;
                case FilmProperty::PROPERTY_HOT:
                    //todo what's the meaning of updated time ??
                    $query->orderBy(['sequence' => SORT_DESC,FilmProperty::tableName().'.created_at' => SORT_DESC]);break;
                case FilmProperty::PROPERTY_NEWEST:
                    //todo  which table should I put resource time
                    $query->orderBy(['sequence' => SORT_DESC,FilmProperty::tableName().'.created_at' => SORT_DESC]);break;
            }
        }
        return $dataProvider;
    }
}
