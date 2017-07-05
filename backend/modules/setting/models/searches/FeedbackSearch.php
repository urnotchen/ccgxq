<?php

namespace backend\modules\setting\models\searches;

use yii\data\ActiveDataProvider;

use backend\modules\setting\models\Reply;
use backend\modules\setting\models\Feedback;

/**
 * Class MetadataSearch
 * @package backend\modules\stuff\models\searches
 *
 * @property \yii\db\ActiveQuery $_query
 */
class FeedbackSearch extends Feedback
{
    const SEPARATOR = '~';

    private $_query;

    public $ranges = [];

    public function rules()
    {
        return [
            ['created_by', 'integer'],
            ['created_at', 'validateRange']
        ];
    }

    public function validateRange($attr, $params)
    {
        if ($this->hasErrors()) {

            return false;
        }

        $datetime = explode(self::SEPARATOR, $this->$attr);
        if (!is_array($datetime) || count($datetime) != 2) {
            $this->addError($attr, '时间格式错误.');
            return false;
        }

        foreach ($datetime as $v) {
            $time = strtotime($v);

            if ($time === false) {
                $this->addError($attr, '时间格式错误.');

                break;
            }

            $this->ranges[] = $time;
        }
    }

    public function init()
    {
        parent::init();

        $this->_query = Feedback::find();
    }

    public function search($params)
    {
        $this->_query->with('userFeedback');

        $dataProvider = new ActiveDataProvider([
            'query' => $this->_query,
            'sort' => [
                'defaultOrder' => [
                    'created_at' => SORT_DESC
                ]
            ],
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {

            return $dataProvider;
        }

        $this->_query->andFilterWhere([
            Feedback::tableName() . '.created_by' => $this->created_by
        ]);
        if (! empty($this->ranges)) {

            $this->_query->andFilterWhere([
                'between',
                Reply::tableName() . '.created_at',
                reset($this->ranges),
                end($this->ranges)
            ]);
        }


        return $dataProvider;
    }
}

?>