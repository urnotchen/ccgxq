<?php

namespace backend\modules\user\models\searches;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\user\models\User;

/**
 * UserSearch represents the model behind the search form about `backend\modules\user\models\User`.
 */
class UserSearch extends User
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'status', 'last_use_time', 'allowance', 'allowance_updated_at', 'created_at', 'updated_at'], 'integer'],
            [['email', 'password'], 'safe'],
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
        $query = User::find();

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
            'status' => $this->status,
            'last_use_time' => $this->last_use_time,
            'allowance' => $this->allowance,
            'allowance_updated_at' => $this->allowance_updated_at,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'password', $this->password]);

        return $dataProvider;
    }
}
