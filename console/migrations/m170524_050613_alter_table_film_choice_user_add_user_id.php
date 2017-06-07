<?php

use yii\db\Schema;
use yii\db\Migration;

class m170524_050613_alter_table_film_choice_user_add_user_id extends Migration
{

    public $tableName = 'film_choice_user';
    public function up()
    {
        $this->addColumn($this->tableName,'user_id',$this->integer()->unsigned());
//        $this->dropColumn($this->tableName,'synopsis');

        \Yii::$app->db->getSchema()->refreshTableSchema($this->tableName);

    }

    public function down()
    {

    }

}
