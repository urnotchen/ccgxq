<?php

namespace common\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Consultation;

/**
 * ConsultationSearch represents the model behind the search form about `common\models\Consultation`.
 */
class ConsultationSearch extends Consultation
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'age', 'sex', 'need_consultation', 'consultation_at', 'status', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['patient_name', 'disease_name', 'illness', 'consultation_people'], 'safe'],
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
        $query = Consultation::find();

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
            'age' => $this->age,
            'sex' => $this->sex,
            'need_consultation' => $this->need_consultation,
            'consultation_at' => $this->consultation_at,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'patient_name', $this->patient_name])
            ->andFilterWhere(['like', 'disease_name', $this->disease_name])
            ->andFilterWhere(['like', 'illness', $this->illness])
            ->andFilterWhere(['like', 'consultation_people', $this->consultation_people]);

        return $dataProvider;
    }
}
