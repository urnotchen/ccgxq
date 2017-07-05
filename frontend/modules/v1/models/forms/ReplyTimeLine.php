<?php

namespace frontend\modules\v1\models\forms;

class ReplyTimeLine extends \frontend\components\rest\TimelineModel
{
    //设置model类
    protected $_modelClass = 'frontend\modules\v1\models\Reply';
    //排序方式
    protected $_orderBy    = 'id DESC';
    //排序的字段名
    protected $_line       = 'id';
    //主键
    protected $_primaryKey = 'id';

    public $count = 5;


    /**
     * $rawParams array  通常是GET或POST参数
     * $closure 匿名函数（闭包），默认为false
     */
    public static function timeline($rawParams, $closure = false)
    {
        //实例化当前类
        $timeline = new static;
        //如果get参数不为空，则读取并验证参数的规范
        if (! empty($rawParams)) {
            /*
             * boolean load( $data, $formName = null )
             *
             * $data  array  通常是GET或POST参数
             * $formName  string  用于加载数据到模型中的表单名称。如果没有设置,将使用formName()。
             */
            $timeline->load($rawParams, '');
            $timeline->validate();
        }


        # 判断参数2是否是匿名函数，若是则调用该函数。
        # instanceof 判断是否是类的实例
        if ($closure instanceof \Closure) {

            $closure($timeline->query);
        }

        try {

            # 调用preparePullQuery()，根据不同的参数返回不同的数据
            return $timeline->preparePullQuery()->findAll();
        } catch (\yii\web\HttpException $e) {
            if ($e->statusCode == 404) {
                return [];
            }
            throw $e;
        }
    }

}

?>