<?php

use yii\db\Schema;
use yii\db\Migration;

class m170807_995048_permission_add_rights_manage extends Migration
{
    public function up()
    {
        $auth = Yii::$app->authManager;

        $permission = $auth->createPermission(\backend\modules\rights\components\Rights::PERMISSION_RIGHTS_MANAGE);
        $permission->description = '权限管理';
        $auth->add($permission);
    }

    public function down()
    {

        return false;
    }
}
