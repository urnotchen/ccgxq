<?php

use yii\db\Schema;
use yii\db\Migration;

class m210225_050613_alter_table_partment_add_grade_num extends Migration
{

    public $tableName = 'partment';
    public function up()
    {
        $this->addColumn($this->tableName,'grade',$this->decimal(2)->defaultValue(0));
        $this->addColumn($this->tableName,'num',$this->integer()->defaultValue(0));


    }

    public function down()
    {

    }

}
