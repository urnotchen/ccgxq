<?php

use yii\db\Schema;
use yii\db\Migration;

class m170524_050611_refresh_table_schema extends Migration
{

    public $tableName = 'movie';
    public function up()
    {
        

        \Yii::$app->db->getSchema()->refreshTableSchema($this->tableName);

    }

    public function down()
    {

    }

}
