<?php

namespace backend\modules\statistics\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\statistics\models\StatDaily;

/**
 * StatDailySearch represents the model behind the search form about `app\modules\statistics\models\StatDaily`.
 */
class StatDailySearch extends StatDaily
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'day', 'count', 'type'], 'integer'],
            [['daily'], 'safe'],
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
        $query = StatDaily::find();

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
            'day' => $this->day,
            'count' => $this->count,
            'type' => $this->type,
        ]);

        $query->andFilterWhere(['like', 'daily', $this->daily]);

        return $dataProvider;
    }
}
