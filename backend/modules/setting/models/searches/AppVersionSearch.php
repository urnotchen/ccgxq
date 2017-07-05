<?php

namespace backend\modules\setting\models\searches;

use yii\base\Model;
use yii\data\ActiveDataProvider;

use backend\modules\setting\models\AppVersion;

/**
 * AppVersionSearch represents the model behind the search form about `app\models\AppVersion`.
 */
class AppVersionSearch extends AppVersion
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['is_imp', 'created_at'], 'integer'],
            [['version', 'title', 'content'], 'safe'],
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
        $query = AppVersion::find();

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
            'is_imp' => $this->is_imp,
            'created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['like', 'version', $this->version])
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'content', $this->content]);

        return $dataProvider;
    }
}
