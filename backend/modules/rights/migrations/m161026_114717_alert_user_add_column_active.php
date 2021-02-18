<?php

use yii\db\Schema;
use yii\db\Migration;

class m161026_114717_alert_user_add_column_active extends Migration
{

    public $tableName = 'user';

    public function up()
    {
        $this->addColumn($this->tableName,'pt_active',$this->smallInteger()->defaultValue(0));
    }

    public function down()
    {
        $this->dropColumn($this->tableName,'pt_active',$this->smallInteger()->defaultValue(0));

        return false;
    }

}
