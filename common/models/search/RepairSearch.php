<?php

namespace common\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Repair;

/**
 * RepairSearch represents the model behind the search form about `common\models\Repair`.
 */
class RepairSearch extends Repair
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'department_id', 'replied_by', 'status', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['repaired_by', 'repaired_content', 'repaired_reply'], 'safe'],
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
        $query = Repair::find();

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
            'department_id' => $this->department_id,
            'replied_by' => $this->replied_by,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'repaired_by', $this->repaired_by])
            ->andFilterWhere(['like', 'repaired_content', $this->repaired_content])
            ->andFilterWhere(['like', 'repaired_reply', $this->repaired_reply]);

        return $dataProvider;
    }
}
