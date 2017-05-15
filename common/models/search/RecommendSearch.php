<?php

namespace common\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Recommend;

/**
 * RecommendSearch represents the model behind the search form about `app\modules\movie\models\Recommend`.
 */
class RecommendSearch extends Recommend
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'movie_id', 'recommend_movie_id'], 'integer'],
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
        $query = Recommend::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
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
            'recommend_movie_id' => $this->recommend_movie_id,
        ]);

        return $dataProvider;
    }
}
