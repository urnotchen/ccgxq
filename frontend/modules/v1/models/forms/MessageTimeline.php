<?php

namespace frontend\modules\v1\models\forms;

/**
 * FavoriteCardTimeline class file.
 * @Author haoliang
 * @Date 11/12/2015 11:48:17
 */
class MessageTimeline extends \frontend\components\rest\TimelineModel
{
    protected $_modelClass = 'frontend\modules\v1\models\Message';
    protected $_orderBy    = 'updated_at desc';
    protected $_line       = 'updated_at';
    protected $_primaryKey = 'id';

    public static function timeline($rawParams, array $where = [])
    {/*{{{*/
        $timeline = new static;

        if (! empty($rawParams)) {
            $timeline->load($rawParams, '');
            $timeline->validate();
        }

        if (! empty($where)) {

           $timeline->query->andWhere($where);

        }

        return $timeline->preparePullQuery()->findAll();
    }/*}}}*/

}
