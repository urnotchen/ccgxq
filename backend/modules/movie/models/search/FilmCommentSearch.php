<?php

namespace backend\modules\movie\models\search;

use backend\modules\movie\models\FilmChoiceUser;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\movie\models\FilmComment;

/**
 * FilmCommentSearch represents the model behind the search form about `app\models\FilmComment`.
 */
class FilmCommentSearch extends FilmComment
{

    public $exist_content;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'movie_id', 'pic_id', 'star','type', 'good_num','source','created_at', 'updated_at'], 'integer'],
            [['user_id', 'username', 'comment','exist_content'], 'safe'],
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
        $query = $this->find();

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
            'star' => $this->star,
//            'type' => $this->type,
            'source' => $this->source,
            'good_num' => $this->good_num,
            'updated_at' => $this->updated_at,
        ]);

        if($this->type){
            if($this->type == self::TYPE_USER) {
                $query->joinWith('filmChoiceUserForCommentSearch', true, 'join')
                    ->where([FilmChoiceUser::tableName().'.type' => FilmChoiceUser::TYPE_SAW]);

            }else{
                $query->andWhere(['type' => $this->type]);
            }
        }

//        $query->andFilterWhere(['like', 'comment.user_id', $this->user_id])
        $query->andWhere([self::tableName().'.user_id' => (string)$this->user_id]);
        $query->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'comment', $this->comment]);

        //需要内容
        if($this->exist_content){
            $query->andWhere(['not',['comment' => null]]);
        }

        return $dataProvider;
    }
}
