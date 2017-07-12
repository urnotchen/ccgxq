<?php

namespace backend\modules\movie\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\movie\models\MovieOnlineResource;

/**
 * MovieOnlineResourceSearch represents the model behind the search form about `backend\modules\movie\models\MovieOnlineResource`.
 */
class MovieOnlineResourceSearch extends MovieOnlineResource
{

    public $movie_title;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'movie_id', 'definition', 'created_at', 'updated_at'], 'integer'],
            [['movie_title'],'string']
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
        $query = MovieOnlineResource::find()
            //如果有资源的电影在电影表中没有数据 就不显示这部电影的资源
                    ->joinWith('movie',true,'join');

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
            'definition' => $this->definition,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);
        if($this->movie_title) {
            $query->andFilterWhere(['like', 'movie.title', $this->movie_title]);
        }
        return $dataProvider;
    }
}
