<?php

use yii\db\Schema;
use yii\db\Migration;

class m210208_050605_create_table_deal extends Migration
{


    public $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';

    public function safeUp()
    {

        $this->createTable('deal', [

            'id'                => $this->primaryKey(),
            'approval_id'           => $this->integer()->notNull(). " COMMENT '审批id'",
            'file_arr'           => $this->string(1000)->notNull(). " COMMENT '标题'",
            'label_arr'           => $this->string(1000)->notNull(). " COMMENT '标题'",
            'reply'           => $this->string(1000). " COMMENT ''",

            'status'            => $this->smallInteger()->notNull()." COMMENT '状态'",

            'created_at'        => $this->integer()->unsigned(),
            'created_by'        => $this->integer()->unsigned(),
            'updated_at'        => $this->integer()->unsigned(),
            'updated_by'        => $this->integer()->unsigned(),
        ], $this->tableOptions. " COMMENT '用户办理业务表'");




    }

    public function safeDown()
    {
        $this->dropTable($this->tableName);


    }

}
