<?php

use yii\db\Schema;
use yii\db\Migration;

class m170627_050613_alter_table_user_token_add_column_registration_id extends Migration
{

    public $tableName = 'user_token';
    public function up()
    {
        $this->addColumn($this->tableName,'registration_id',$this->string());

        \Yii::$app->db->getSchema()->refreshTableSchema($this->tableName);

    }

    public function down()
    {

    }

}
