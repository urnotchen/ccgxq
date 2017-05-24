<?php

namespace backend\modules\movie\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\movie\models\FilmComment;

/**
 * FilmCommentSearch represents the model behind the search form about `app\models\FilmComment`.
 */
class FilmCommentSearch extends FilmComment
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'movie_id', 'pic_id', 'comment_date', 'star', 'good_num', 'updated_at'], 'integer'],
            [['user_id', 'username', 'userhome_url', 'comment'], 'safe'],
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
        $query = FilmComment::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['good_num' => SORT_DESC]]
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
            'pic_id' => $this->pic_id,
            'comment_date' => $this->comment_date,
            'star' => $this->star,
            'good_num' => $this->good_num,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'user_id', $this->user_id])
            ->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'comment', $this->comment]);

        return $dataProvider;
    }
}