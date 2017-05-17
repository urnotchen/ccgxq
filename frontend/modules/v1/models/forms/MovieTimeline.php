<?php
/**
 * Created by PhpStorm.
 * User: chenxi
 * Date: 2017/5/16
 * Time: 11:12
 */

namespace frontend\modules\v1\models\forms;

use frontend\components\rest\TimelineModel;
use frontend\modules\v1\models\FilmProperty;
use frontend\modules\v1\models\Movie;

class MovieTimeline extends TimelineModel{

    protected $_modelClass = 'frontend\modules\v1\models\Movie';

    protected  $_orderBy = 'sequence DESC,release_timestamp DESC';

    protected $_line = 'release_timestamp';

    protected $_primaryKey = 'id';

    public $type;

    public function init(){

        parent::init();

//        $this->initValidExpand($this->_modelClass);

    }

    public static function timeline($rawParams,$closure = false){

        $timeline = new static;

        if(!empty($rawParams)){

            $timeline->load($rawParams,'');

            $timeline->validate();

        }
        if ($closure instanceof \Closure) {
            $closure($timeline->query);
        }

        return $timeline->preparePullQuery()->findAll();
    }

    public function initValidExpand($modelClass)
    {/*{{{*/
        $model = new $modelClass;

        $this->_validExpand = array_diff(
            $model->extraFields(),
            $model->unrelationFields()
        );
    }/*}}}*/
}

