<?php

namespace frontend\modules\v1\models\forms;

/**
 * FavoriteCardTimeline class file.
 * @Author haoliang
 * @Date 11/12/2015 11:48:17
 */
class SearchTimeline extends \frontend\components\rest\TimelineModel
{
    protected $_modelClass = 'frontend\modules\v1\models\Movie';
    protected $_orderBy    = 'score desc';
    protected $_line       = 'score';
    protected $_primaryKey = 'id';

    public static function timeline($rawParams, array $where = [])
    {/*{{{*/
        $timeline = new static;

        if (! empty($rawParams)) {
            $timeline->load($rawParams, '');
            $timeline->validate();
        }

        if (! empty($where)) {
            foreach($where as $eachWhere){
                $timeline->query->orFilterWhere(['like',$eachWhere,$rawParams['keyword']]);
            }
        }

        return $timeline->preparePullQuery()->findAll();
    }/*}}}*/

}
