<?php

namespace backend\modules\setting\models\searches;

use backend\modules\setting\models\Misc;
use yii\base\Model;
use yii\data\ActiveDataProvider;


class MiscSearch extends Misc
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'policy','explain'], 'string'],
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
        $query = Misc::find();

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

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'policy', $this->policy])
            ->andFilterWhere(['like', 'explain', $this->explain]);

        return $dataProvider;
    }
}
