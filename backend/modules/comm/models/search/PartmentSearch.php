<?php

namespace backend\modules\comm\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\comm\models\Partment;

/**
 * PartmentSearch represents the model behind the search form about `common\models\Partment`.
 */
class PartmentSearch extends Partment
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'partname','info', 'status', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],

            [['grade', ], 'safe'],
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
        $query = Partment::find();

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
            'partname' => $this->partname,
        ]);



        return $dataProvider;
    }
}
