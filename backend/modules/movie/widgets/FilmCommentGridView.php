<?php

namespace backend\modules\movie\widgets;


use Yii;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\base\InvalidConfigException;


class FilmCommentGridView extends GridView
{

    public $stringColumns,$dataProvider;


    public function init()
    {/*{{{*/



        $this->columns = $this->getColumns();


        parent::init();

    }/*}}}*/

    public function getColumns()
    {/*{{{*/

        $columnArr = explode(',', $this->stringColumns);
        $columnArr = array_map(function ($item) {
            return trim($item, ' ');
        }, $columnArr);

        $result = [];

        foreach ($columnArr as $i) {
            $value = $this->getColumnValue($i);
            if ($value)
                $result[] = $value;
        }

        $result[] = $this->getActionColumn();


        return $result;

    }/*}}}*/

    public function getColumnValue($column = null)
    {/*{{{*/


        $columns = [
            'pic_id' => [
                'attribute' => 'pic_id',
                'format' => 'raw',
                'value' => function($model) {

                    $img = Html::a(
                        Html::img(Yii::$app->params['qiniuDomain'] . str_replace('pictures', '', $model->image->path), ['class' => 'user-avatar img-circle']),
                        $model->userhome_url,
                        ['target' => '_blank']
                    );

                    return <<<HTML
                    <div class="text-center">$img</div>
                    <div class="text-center force_new_line">$model->username</div>
HTML;
                },
                'contentOptions' => ['width' => '8%'],

            ],

            'comment_date' => [
                'attribute' => 'comment_date',
                'format' => 'raw',
                'value' => function($model){
                    return date("Y-m-d",$model->comment_date);
                }
            ],
            'score' => 'score',
            'good_num' => 'good_num',
            'comment' => [
                'attribute' => 'comment',
                'format' => 'raw',
                'value' => function($model){
                    return <<<HTML
                        <div class="force_new_line">$model->comment</div>
HTML;
                },
                'contentOptions' => ['width' => '50%'],
            ],
        ];

        if ($this->stringColumns === null)
            return $columns;

        return ArrayHelper::getValue($columns, $column, false);

    }/*}}}*/

    public function getActionColumn()
    {/*{{{*/
        return [
            'class' => 'yii\grid\ActionColumn',
        ];

    }/*}}}*/

}
