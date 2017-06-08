<?php

use yii\db\Schema;
use yii\db\Migration;

class m170607_050613_alter_table_user_rename_table_frontend_user extends Migration
{

    public $tableName = 'user';
    public function up()
    {
        $this->renameTable($this->tableName,'frontend_user');
//        $this->dropColumn($this->tableName,'synopsis');

        \Yii::$app->db->getSchema()->refreshTableSchema($this->tableName);

    }

    public function down()
    {

    }

}
