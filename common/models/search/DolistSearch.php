<?php

namespace common\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Dolist;

/**
 * DolistSearch represents the model behind the search form about `common\models\Dolist`.
 */
class DolistSearch extends Dolist
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'sequence', 'end_at', 'status', 'complete_at', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['content', 'complete_remarks'], 'safe'],
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
        $query = Dolist::find();

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
            'sequence' => $this->sequence,
            'end_at' => $this->end_at,
            'status' => $this->status,
            'complete_at' => $this->complete_at,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'content', $this->content])
            ->andFilterWhere(['like', 'complete_remarks', $this->complete_remarks]);

        return $dataProvider;
    }
}
