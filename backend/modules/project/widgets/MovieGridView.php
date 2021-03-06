<?php

namespace backend\modules\movie\widgets;


use backend\helper\MovieHelper;
use backend\modules\movie\models\FilmComment;
use backend\modules\movie\models\FilmProperty;
use backend\modules\movie\models\Movie;
use Yii;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\base\InvalidConfigException;


class MovieGridView extends GridView
{

    public $stringColumns,$dataProvider,$property;


    public function init()
    {/*{{{*/



        $this->columns = $this->getColumns();


        parent::init();

    }/*}}}*/

    public function getColumns()
    {/*{{{*/

        $columnArr = $this->stringColumns;
        $columnArr = array_map(function ($item) {
            return trim($item, ' ');
        }, $columnArr);

        $result = [];

        foreach ($columnArr as $i) {
            $value = $this->getColumnValue($i);
            if ($value)
                $result[] = $value;
        }

        $result[] = $this->getActionColumn($this->stringColumns);


        return $result;

    }/*}}}*/

    public function getColumnValue($column = null)
    {/*{{{*/


        $columns = [
            'pic_id' => [
                'label'=>'海报',
                'format'=>'raw',
                'value' => function(Movie $model){
                    return
                        Html::a(
                            \yii\helpers\Html::img(Yii::$app->params['qiniuDomain'].str_replace('pictures','',$model->image->path), ['class' => 'movie_poster']),
                            $model->movie_url,
                            ['target' => '_blank','width' => '10px','height' => '220px']);
                },
//                'options' =>  ],
            ],
            'title' => [
                'label'=>'名称',
                'format'=>'raw',
                'value' => function(Movie $model){
                    $titleList = explode(' ',$model->title,2);
                    $alias = count($titleList) == 2 ? "({$titleList[1]})" : '';

                    return "<div class = force_new_line>".$titleList[0].$alias."</div>";

                },
//            'contentOptions' => ['style' => ['width' => '15%']],
                'options' => ['width' => '10%'],
            ],
            'director' => [
                'label'=>'导演',
                'format'=>'raw',
                'value' => function(Movie $model){
                    return "<div class = force_new_line>{$model->director}</div>";
                },

            ],
            'actor' => [
                'label'=>'演员',
                'format'=>'raw',
                'value' => function(Movie $model){
                    return "<div class = force_new_line>{$model->actor}</div>";
                },
                'contentOptions' => ['class' => 'force_new_line']
            ],

            'comment_num' => 'comment_num',
            'score' => [
                'attribute' => 'score',
                'format' => 'raw',
                'value' => function($model){
                    return "<span class='text-red lead'>{$model->score}</span>";
                }
            ],
            'resource' => [
                'label' => '资源',
                'format' => 'raw',
                'value' => function($model){
                    $movieOnlineResource = $model->movieOnlineResource;
                    $str = '';
                    foreach($movieOnlineResource as $eachResource){
                        $str .= Html::a($eachResource->enum('definition')[$eachResource->definition],"http://snake.bluelive.me/crawl/movie-resource/index?MovieResourceSearch[definition]={$eachResource->definition}&MovieResourceSearch[douban]={$eachResource->movie_id}",
                            ['target' => '_blank','style' => ['display' => 'block']]);
                    }
                    return $str;
                },
            ],
            'order' => [
                'label' => '位置',
                'format' => 'raw',
                'value' => function($model){
//                    if($sequence = $model->property->sequence) {
//                        return FilmProperty::find()->where(['property' => $this->property])->max('sequence') - $sequence + 1;
//                    }
//                    return $this->property;

                    if($sequence = FilmProperty::getProperty($this->property,$model->id)) {
                        if(!$sequence->sequence){
                            return '无';
                        }
                        return FilmProperty::getSequenceMax($this->property) - $sequence->sequence + 1;
                    }
                }
            ],
            'type' => 'type',
            'release_date' => 'release_date',
            'movieArea' => [
                'label' => '电影',
                'format' => 'raw',
                'value' => function($model){
                    $title = MovieHelper::getChineseName($model->title);
                    if($localName = MovieHelper::getLocalName($model->title)){
                        $title = MovieHelper::getChineseName($model->title).'('.$localName.')';
                    }
                    return $this->render('/movie/movie_area',[
                        'title' => $title,
                        'imageSrc' => $model->image?Yii::$app->params['qiniuDomain'].str_replace('pictures','',$model->image->path):'',
                        'movieUrl' => $model->movie_url,
                        'type' => $model->type,
                        'releaseDate' => $model->release_date,
                        'director' => $model->director,
                    ]);
                },
            ],
            'sequence' => [
                'label' => '顺序',
                'format' => 'raw',
                'value' => function($model){
                    $property = FilmProperty::getProperty($this->property,$model->id);
                    if(!$property){
                        return '';
                    }
                    $property_id = $property->id;
                    $motionPossible = FilmProperty::getMotionPossible($property_id);
                    $button = '';
                    if($motionPossible['up']){
                        $button .= <<<HTML
                            <a href="####"  class = "motion" property_id = {$property_id} motion ="up">上移</a>
HTML;
                    }
                    if($motionPossible['down']){
                        $button .= <<<HTML
                            <a href="####" class = "motion" property_id = {$property_id} motion = "down">下移</a>
HTML;
                    }
                    return $button;
//                    return ($model->getProperty($this->property)->one()->sequence);
                }
            ]
        ];

        if ($this->stringColumns === null)
            return $columns;

        return ArrayHelper::getValue($columns, $column, false);

    }/*}}}*/

    public function getActionColumn($stringColumns)
    {/*{{{*/
        return [
            'label'=>'操作',
            'format'=>'raw',
            'value' => function($model) use ($stringColumns){

                $comment = Url::to(['film-comment/index', 'FilmCommentSearch[movie_id]' => $model->id]);
                $view = Url::to(['movie/view', 'id' => $model->id]);
                $update = Url::to(['movie/update', 'id' => $model->id]);
                $trash = Url::to(['movie/trash', 'id' => $model->id]);

                $commonOptions = array_merge([
                    'data-pjax' => '0',
                    'value' => $model->id,
                ]);

                $trashOption = array_merge([
                    'data-confirm' => Yii::t('yii', '确定要将这条记录扔进垃圾桶?'),
                    'data-method' => 'post',
                ], $commonOptions);


                $commentButton = Html::a("查看评论", $comment,['target' => '_blank','data-pjax' => '0']);
                $updateButton = Html::a('修改电影', $update);
                $viewButton = Html::a('查看电影', $view);
                $trashButton = Html::a('扔进垃圾桶', $trash, $trashOption);

                $propertyOption = array_merge(['class' => 'setProperty'],$commonOptions);
//                $deletePropertyOption = array_merge(['class' => 'deleteProperty'],$common_options);


                $propertyAlreadyList = FilmProperty::getMovieProperties($model->id);

                $propertyButton = '';
                foreach(FilmProperty::$propertyList as $property){
                    if(in_array($property,$propertyAlreadyList)){
                        $button = Html::a('取消'.FilmProperty::enum('property',$property), '#', array_merge($propertyOption,['property_id' => $property,'motion' => 'delete']));
                    }else{
                        $button = Html::a('加入'.FilmProperty::enum('property',$property), '#', array_merge($propertyOption,['property_id' => $property,'motion' => 'add']));
                    }
                    $propertyButton = "<li>".$button."</li>".$propertyButton;
                }

                $property = FilmProperty::getProperty($this->property,$model->id);
                $sequenceButtonStr ='';
                if(in_array('order',$stringColumns)) {
                    $sequenceButton = Html::a('调整顺序', '#', ['class' => 'quick_change_sequence', 'property_id' => $property->id]);
                    $sequenceButtonStr = "<li>{$sequenceButton}</li>";
                }
                $menu_bar = "<li>{$viewButton}</li>
                             <li>{$updateButton}</li>
                             <li>{$trashButton}</li>
                             <li role='separator' class='divider'></li>
                             <li>{$commentButton}</li>
                             $sequenceButtonStr
                             <li>{$propertyButton}</li>";




                $operations = "<div class='btn-group'>
                                <button type='button' class='btn btn-default dropdown-toggle btn-sm' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                                     &nbsp; 操 &nbsp; 作 &nbsp; <span class='caret'></span>
                                </button>
                                <ul class='dropdown-menu'>
                                    {$menu_bar}
                                </ul>
                            </div>
                            <br >";

                return $operations;

            }
        ];

    }/*}}}*/

}
