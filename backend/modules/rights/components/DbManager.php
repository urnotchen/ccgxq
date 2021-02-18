<?php

namespace backend\modules\rights\components;

/**
 * DbManager class file.
 * @Author haoliang
 * @Date 08.09.2015 16:39
 */
class DbManager extends \yii\rbac\DbManager
{

    private $_stat_assignments;

    /**
     * @brief getAssignments
     *
     * 将 assignments 加入实例范围缓存
     *
     * @param $userId
     *
     * @return []
     */
    public function getAssignments($userId)
    {/*{{{*/
        if ($this->_stat_assignments === null) {
            $this->_stat_assignments = parent::getAssignments($userId);
        }

        return $this->_stat_assignments;
    }/*}}}*/

}
