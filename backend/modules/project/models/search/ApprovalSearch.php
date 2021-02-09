<?php

namespace backend\modules\project\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\project\models\Approval;

/**
 * ApprovalSearch represents the model behind the search form about `common\models\Approval`.
 */
class ApprovalSearch extends Approval
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'project_id', 'sequence', 'basic_is_charge', 'is_online', 'status', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['name', 'agency', 'basic_sxlx', 'basic_bjlx', 'basic_sszt', 'basic_xscj', 'basic_cnbjsx', 'basic_fdbjsx', 'basic_dbsxccs', 'basic_zxfs', 'basic_jdtsfs', 'basic_blsj', 'basic_bldd', 'process', 'blclml', 'sltj', 'sfbz', 'sdyj', 'question'], 'safe'],
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
        $query = Approval::find();

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
            'project_id' => $this->project_id,
            'sequence' => $this->sequence,
            'basic_is_charge' => $this->basic_is_charge,
            'is_online' => $this->is_online,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'agency', $this->agency])
            ->andFilterWhere(['like', 'basic_sxlx', $this->basic_sxlx])
            ->andFilterWhere(['like', 'basic_bjlx', $this->basic_bjlx])
            ->andFilterWhere(['like', 'basic_sszt', $this->basic_sszt])
            ->andFilterWhere(['like', 'basic_xscj', $this->basic_xscj])
            ->andFilterWhere(['like', 'basic_cnbjsx', $this->basic_cnbjsx])
            ->andFilterWhere(['like', 'basic_fdbjsx', $this->basic_fdbjsx])
            ->andFilterWhere(['like', 'basic_dbsxccs', $this->basic_dbsxccs])
            ->andFilterWhere(['like', 'basic_zxfs', $this->basic_zxfs])
            ->andFilterWhere(['like', 'basic_jdtsfs', $this->basic_jdtsfs])
            ->andFilterWhere(['like', 'basic_blsj', $this->basic_blsj])
            ->andFilterWhere(['like', 'basic_bldd', $this->basic_bldd])
            ->andFilterWhere(['like', 'process', $this->process])
            ->andFilterWhere(['like', 'blclml', $this->blclml])
            ->andFilterWhere(['like', 'sltj', $this->sltj])
            ->andFilterWhere(['like', 'sfbz', $this->sfbz])
            ->andFilterWhere(['like', 'sdyj', $this->sdyj])
            ->andFilterWhere(['like', 'question', $this->question]);

        return $dataProvider;
    }
}
