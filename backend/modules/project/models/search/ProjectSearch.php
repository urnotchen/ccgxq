<?php

namespace backend\modules\project\models\search;


use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\project\models\Project;

/**
 * ProjectSearch represents the model behind the search form about `common\models\Project`.
 */
class ProjectSearch extends Project
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'project_category_id', 'status', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['name', 'sxlx', 'kbbm', 'sszt', 'xscj', 'sdyj', 'qlly'], 'safe'],
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
        $query = Project::find();

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
            'project_category_id' => $this->project_category_id,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'sxlx', $this->sxlx])
            ->andFilterWhere(['like', 'kbbm', $this->kbbm])
            ->andFilterWhere(['like', 'sszt', $this->sszt])
            ->andFilterWhere(['like', 'xscj', $this->xscj])
            ->andFilterWhere(['like', 'sdyj', $this->sdyj])
            ->andFilterWhere(['like', 'qlly', $this->qlly]);

        return $dataProvider;
    }
}
