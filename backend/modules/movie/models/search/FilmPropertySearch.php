<?php

namespace backend\modules\movie\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\movie\models\FilmProperty;

/**
 * searchFilmPropertySearch represents the model behind the search form about `app\models\FilmProperty`.
 */
class FilmPropertySearch extends FilmProperty
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'movie_id', 'property', 'sequence', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
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
    public static function find(){

    }
    public function search($params)
    {
        $query = FilmProperty::find()->where(['status' => self::STATUS_NORMAL]);

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
            'movie_id' => $this->movie_id,
            'property' => $this->property,
            'sequence' => $this->sequence,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
        ]);

        return $dataProvider;
    }
}
