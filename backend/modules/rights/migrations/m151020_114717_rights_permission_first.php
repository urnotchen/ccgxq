<?php

use yii\db\Schema;
use yii\db\Migration;

class m151020_114717_rights_permission_first extends Migration
{
    public function up()
    {

        $auth = Yii::$app->authManager;

        $fansManage = $auth->createPermission(\backend\modules\rights\components\Rights::PERMISSION_RIGHTS_MANAGE);
        $fansManage->description = '权限管理';
        $auth->add($fansManage);
    }

    public function down()
    {
        echo "m151020_114717_rights_permission_first cannot be reverted.\n";

        return false;
    }

}
