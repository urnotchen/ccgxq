<?php

namespace frontend\modules\v1\models\forms;
use common\models\queries\MovieQuery;
use frontend\modules\v1\models\FilmProperty;
use frontend\modules\v1\models\Movie;
use frontend\modules\v1\models\MovieIndex;
use yii\db\Expression;
use yii\db\Query;

/**
 * FavoriteCardTimeline class file.
 * @Author haoliang
 * @Date 11/12/2015 11:48:17
 */
class MovieListTimeline extends \frontend\components\rest\TimelineMultiModel
{
    protected $_modelClass = 'frontend\modules\v1\models\Movie';
    protected $_orderBy    = 'idTemp asc';
    protected $_line       = 'idTemp';
    protected $_primaryKey = 'id';
    public static function timeline($rawParams, $query)
    {/*{{{*/
         $timeline = new static;

        if (! empty($rawParams)) {
            $timeline->load($rawParams, '');

            $timeline->validate();
        }

        //外面再嵌套一层 为了对idTemp做筛选操作
        $timeline->query->select(new Expression(" t2.*"))->from(new Expression("({$query} )as t2"));

        return $timeline->preparePullQuery()->findAll();
    }/*}}}*/

}
