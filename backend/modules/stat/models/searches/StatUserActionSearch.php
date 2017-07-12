<?php

namespace backend\modules\stat\models\searches;

use common\helpers\DateHelper;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\stat\models\StatUserAction;

/**
 * StatUserActionSearch represents the model behind the search form about `backend\modules\stat\models\StatUserAction`.
 */
class StatUserActionSearch extends StatUserAction
{
    const SEPARATOR = '~';

    public $statistics_time, $statistics_time_range = [];

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'count', 'day','type', 'sub_type'], 'integer'],
            [['statistics_time'],'string'],
            [['statistics_time'], 'validateRange'],
            [['daily'], 'safe'],
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
        $query = StatUserAction::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['day' => SORT_DESC]
            ]
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
            'count' => $this->count,
            'type' => $this->type,
            'sub_type' => $this->sub_type,
        ]);
        if(!$this->day){
            $query->andWhere(['day' => DateHelper::getYesterdayTimestamp(time())]);
        }
        if(!$this->sub_type){
            //默认订阅
            $query->andWhere(['sub_type' => self::SUB_TYPE_ZHAN_SUBSCRIBE]);
        }

        if (!empty($this->statistics_time_range)) {
            $range_time = $this->statistics_time_range;
            $query->andFilterWhere([
                'between', 'day', reset($range_time), end($range_time)
            ]);
        }
        $query->andFilterWhere(['like', 'daily', $this->daily]);

        return $dataProvider;
    }
}
