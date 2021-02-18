<?php

namespace common\models\queries;

use common\models\User;

/**
 * This is the ActiveQuery class for [[\common\models\User]].
 *
 * @see \common\models\User
 */
class UserQuery extends \yii\db\ActiveQuery
{

    public function active()
    {/*{{{*/
        $this->andWhere(['status' => User::STATUS_ACTIVE]);
        return $this;
    }/*}}}*/

    public function inactive()
    {/*{{{*/
        $this->andWhere(['status' => User::STATUS_INACTIVE]);
        return $this;
    }/*}}}*/

}
