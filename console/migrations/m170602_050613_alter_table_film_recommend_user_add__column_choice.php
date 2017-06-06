<?php

use yii\db\Schema;
use yii\db\Migration;

class m170602_050613_alter_table_film_recommend_user_add__column_choice extends Migration
{

    public $tableName = 'film_recommend_user';
    public function up()
    {
        $this->addColumn($this->tableName,'choice',$this->smallInteger());
//        $this->dropColumn($this->tableName,'synopsis');

        \Yii::$app->db->getSchema()->refreshTableSchema($this->tableName);

    }

    public function down()
    {

    }

}
