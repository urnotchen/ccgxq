<?php

namespace backend\modules\order\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\DayBook;

/**
 * BookSearchDay represents the model behind the search form about `common\models\DayBook`.
 */
class BookSearchDay extends DayBook
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'day_time', 'book_time_arr', 'pre_half_hour_people', 'status', 'booK_status_arr', 'created_at', 'updated_at'], 'integer'],
            [['order_id', 'book_num_arr'], 'safe'],
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
        $query = DayBook::find();

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
            'day_time' => $this->day_time,
            'book_time_arr' => $this->book_time_arr,
            'pre_half_hour_people' => $this->pre_half_hour_people,
            'status' => $this->status,
            'booK_status_arr' => $this->booK_status_arr,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'order_id', $this->order_id])
            ->andFilterWhere(['like', 'book_num_arr', $this->book_num_arr]);

        return $dataProvider;
    }
}
