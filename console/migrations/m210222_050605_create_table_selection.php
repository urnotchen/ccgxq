<?php

use yii\db\Schema;
use yii\db\Migration;

class m210222_050605_create_table_selection extends Migration
{


    public $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';

    public function safeUp()
    {

        $this->createTable('selection', [

            'id'                => $this->primaryKey(),
            'department_id'           => $this->integer()->notNull(). " COMMENT '部门id'",
            'grade'           => $this->integer()->notNull(). " COMMENT '分数'",
            'advise'           => $this->string(1000)->notNull(). " COMMENT '建议'",

            'created_at'        => $this->integer()->unsigned(),
            'created_by'        => $this->integer()->unsigned(),
            'updated_at'        => $this->integer()->unsigned(),
            'updated_by'        => $this->integer()->unsigned(),
        ], $this->tableOptions. " COMMENT '评价表'");




    }

    public function safeDown()
    {
        $this->dropTable($this->tableName);


    }

}
