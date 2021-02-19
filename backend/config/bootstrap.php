<?php
# 惯例
/*{{{*/
Yii::$container->set('kartik\daterange\DateRangePicker', [
    'convertFormat'=>true,
    'pluginOptions'=>[
        'timePicker' => true,
        'locale' => [
            'format'     => 'Y-m-d H:i',
            'separator'  => ' ~ ',
        ],
        'timePickerIncrement' => 5,
    ],
    'options' => ['style' => 'width:100% !important;'],
]);
/*}}}*/