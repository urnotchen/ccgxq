<?php

namespace backend\modules\order\models\form;
use yii\base\Model;

class OrderForm extends Model{

    public $position_id,'name','img','content','map','times','interval', $work_time;

    public function rules()
    {
        return [
            [['position_id', 'name', 'img', 'content', 'map', 'times','interval',], 'required'],
            [['position_id', 'times', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['content'], 'string'],
            [['name', 'img', 'map'], 'string', 'max' => 255],
        ];
    }

    public function validateWorkTime(){}
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'position_id' => '办事窗口位置',
            'name' => '名称',
            'img' => '图片',
            'content' => '内容',
            'map' => '地址',
            'times' => '预约次数',

            'status' => '状态',
            'created_at' => '创建时间',
            'created_by' => '创建人',
            'updated_at' => '修改时间',
            'updated_by' => '修改人',
        ];
    }

}