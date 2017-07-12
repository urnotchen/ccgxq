<?php

namespace backend\modules\stat\models\searches;

use common\helpers\DateHelper;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\stat\models\StatMovie;

/**
 * StatMovieSearch represents the model behind the search form about `backend\modules\stat\models\StatMovie`.
 */
class StatMovieSearch extends StatMovie
{

    const SEPARATOR = '~';

    public $statistics_time, $statistics_time_range = [];

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'day', 'movie_id', 'num', 'type'], 'integer'],
            [['statistics_time'],'string'],
            [['statistics_time'], 'validateRange'],
        ];
    }

    public function validateRange($attr, $params)
    {
        if ($this->hasErrors()) return false;

        $statistics_time = explode(self::SEPARATOR, $this->statistics_time);
        if (!is_array($statistics_time) || count($statistics_time) != 2) {
            $this->addError($attr, '发布时间格式错误.');
            return false;
        }
        foreach ($statistics_time as $v) {
            $time = strtotime($v);
            if ($time === false) {
                $this->addError($attr, '发布时间格式错误.');
                break;
            }
            $this->statistics_time_range[] = $time;
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
        $query = StatMovie::find();

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
            'day' => $this->day,
            'movie_id' => $this->movie_id,
            'num' => $this->num,
            'type' => $this->type,
        ]);
        if(!$this->day){
            $query->andWhere(['day' => DateHelper::getYesterdayTimestamp(time())]);
        }
        if(!$this->type){
            //默认订阅
            $query->andWhere(['type' => self::TYPE_SUBSCRIBE]);
        }

        if (!empty($this->statistics_time_range)) {
            $range_time = $this->statistics_time_range;
            $query->andFilterWhere([
                'between', 'day', reset($range_time), end($range_time)
            ]);
        }

        return $dataProvider;
    }
}
