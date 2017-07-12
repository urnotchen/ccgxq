<?php

namespace backend\modules\movie\models\search;

use backend\modules\movie\models\Movie;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\FilmVideoConn;

/**
 * FilmVideoConnSearch represents the model behind the search form about `app\models\FilmVideoConn`.
 */
class FilmVideoConnSearch extends FilmVideoConn
{

    public $movie_title;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'movie_id', 'website_id', 'type'], 'integer'],
            [['price'], 'number'],
            [['url', 'origin_url','movie_title'], 'safe'],
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
        $query = FilmVideoConn::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' =>[
                'defaultOrder' => ['created_at' => SORT_DESC]
            ],
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
            'movie_id' => $this->movie_id,
            'website_id' => $this->website_id,
            'price' => $this->price,
            'type' => $this->type,
        ]);

        $query->andFilterWhere(['like', 'url', $this->url])
            ->andFilterWhere(['like', 'origin_url', $this->origin_url]);

        if($this->movie_title) {
            //连表搜索
            $query->joinWith('movie')->andFilterWhere(['like', 'movie.title', $this->movie_title]);
        }
        return $dataProvider;
    }
}
