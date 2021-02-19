<?php

namespace backend\modules\order\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Book;

/**
 * BookSearch represents the model behind the search form about `common\models\Book`.
 */
class BookSearch extends Book
{

    const SEPARATOR = '~';
    public $push_time, $push_time_range = [];
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'order_id', 'book_begin_time', 'book_end_time', 'status', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            ['push_time', 'string'],
            ['push_time', 'validateRange'],
        ];

    }
    public function validateRange($attr, $params)
    {
        if ($this->hasErrors()) return false;

        $push_time = explode(self::SEPARATOR, $this->push_time);
        if (!is_array($push_time) || count($push_time) != 2) {
            $this->addError($attr, '发布时间格式错误.');
            return false;
        }
        foreach ($push_time as $v) {
            $time = strtotime($v);
            if ($time === false) {
                $this->addError($attr, '发布时间格式错误.');
                break;
            }
            $this->push_time_range[] = $time;
        }
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
        $query = Book::find();

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
            'order_id' => $this->order_id,
            'status' => $this->status,
        ]);
        if (!empty($this->push_time_range)) {
            $range_time = $this->push_time_range;
           $query->andFilterWhere([
                'between', 'day_time', reset($range_time), end($range_time)
            ]);
        }

        return $dataProvider;
    }
}
