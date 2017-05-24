<?php

use yii\db\Schema;
use yii\db\Migration;

class m170524_050610_alter_table_film_recommend_user_add_column_user_id extends Migration
{

    public $tableName = 'film_recommend_user';
    public function up()
    {
        $this->addColumn($this->tableName,'user_id',$this->smallInteger());

        \Yii::$app->db->getSchema()->refreshTableSchema($this->tableName);

    }

    public function down()
    {

    }

}
