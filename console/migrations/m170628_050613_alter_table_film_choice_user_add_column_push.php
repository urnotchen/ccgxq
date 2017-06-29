<?php

use yii\db\Schema;
use yii\db\Migration;

class m170628_050613_alter_table_film_choice_user_add_column_push extends Migration
{

    public $tableName = 'film_choice_user';
    public function up()
    {
        $this->addColumn($this->tableName,'push',$this->smallInteger()->defaultValue(1));
        $this->addColumn($this->tableName,'source',$this->smallInteger()->defaultValue(2));

        \Yii::$app->db->getSchema()->refreshTableSchema($this->tableName);

    }

    public function down()
    {

    }

}
