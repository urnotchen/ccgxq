<?php

use yii\db\Schema;
use yii\db\Migration;

class m170705_995048_permission_add_user_item extends Migration
{
    public function up()
    {
        $auth = Yii::$app->authManager;

        $permission = $auth->createPermission(\backend\modules\rights\components\Rights::PERMISSION_USER_MANAGE);
        $permission->description = '用户管理';
        $auth->add($permission);
    }

    public function down()
    {
        echo "m151126_105048_permission_add_user_item cannot be reverted.\n";

        return false;
    }
}
