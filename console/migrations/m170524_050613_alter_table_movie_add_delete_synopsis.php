<?php

use yii\db\Schema;
use yii\db\Migration;

class m170524_050613_alter_table_movie_add_delete_synopsis extends Migration
{

    public $tableName = 'movie';
    public function up()
    {
        $this->addColumn($this->tableName,'synopsis',$this->smallInteger());
        $this->dropColumn($this->tableName,'synopsis');

        \Yii::$app->db->getSchema()->refreshTableSchema($this->tableName);

    }

    public function down()
    {

    }

}
