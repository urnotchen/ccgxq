<?php

use yii\db\Migration;
class m170710_050614_alter_table_misc_add_columns_name_explain extends Migration
{

    public $tableName = 'misc';
    public function up()
    {

        $this->addColumn($this->tableName,'name',$this->string());
        $this->addColumn($this->tableName,'explain',$this->string());

        \Yii::$app->db->getSchema()->refreshTableSchema($this->tableName);

    }

    public function down()
    {

    }

}
