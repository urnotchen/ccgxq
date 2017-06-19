<?php

namespace backend\modules\movie\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\movie\models\FilmSynopsis;

/**
 * FilmSynopsisSearch represents the model behind the search form about `app\models\FilmSynopsis`.
 */
class FilmSynopsisSearch extends FilmSynopsis
{

    public $search_text;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'movie_id', 'source', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['content','search_text'], 'string'],
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
        $query = FilmSynopsis::find();

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
            'source' => $this->source,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'content', $this->content]);

        $query->joinWith('movie');

        if($this->search_text) {
            $query->andFilterWhere(['or', ['like', 'movie.title', $this->search_text], ['like', 'content', $this->search_text]]);
        }
        return $dataProvider;
    }
}
