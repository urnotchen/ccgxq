<?php

namespace backend\modules\movie\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\movie\models\Filmmaker;

/**
 * FilmmakerSearch represents the model behind the search form about `app\models\Filmmaker`.
 */
class FilmmakerSearch extends Filmmaker
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'pic_id', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['filmmaker_url', 'name', 'sex', 'constellation', 'birthday', 'birthplace', 'occupation', 'more_foreign_name', 'more_chinese_name', 'family_member', 'imdb', 'imdb_title', 'synopsis'], 'safe'],
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
        $query = Filmmaker::find();

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
            'pic_id' => $this->pic_id,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'filmmaker_url', $this->filmmaker_url])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'sex', $this->sex])
            ->andFilterWhere(['like', 'constellation', $this->constellation])
            ->andFilterWhere(['like', 'birthday', $this->birthday])
            ->andFilterWhere(['like', 'birthplace', $this->birthplace])
            ->andFilterWhere(['like', 'occupation', $this->occupation])
            ->andFilterWhere(['like', 'more_foreign_name', $this->more_foreign_name])
            ->andFilterWhere(['like', 'more_chinese_name', $this->more_chinese_name])
            ->andFilterWhere(['like', 'family_member', $this->family_member])
            ->andFilterWhere(['like', 'imdb', $this->imdb])
            ->andFilterWhere(['like', 'imdb_title', $this->imdb_title])
            ->andFilterWhere(['like', 'synopsis', $this->synopsis]);

        return $dataProvider;
    }
}
