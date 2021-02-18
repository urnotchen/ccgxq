<?php

use yii\db\Schema;
use yii\db\Migration;

class m210120_050605_create_tablle_notice extends Migration
{

    public $tableName = 'notice';

    public $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';

    public function safeUp()
    {

        $this->createTable($this->tableName, [

            'id'                => $this->primaryKey(),
            'title'           => $this->string()->notNull(). " COMMENT '标题'",
            'content'           => $this->text()->notNull(). " COMMENT '内容'",
            'status'            => $this->smallInteger()->notNull()." COMMENT '状态'",
            'from'              =>     $this->string(). " COMMENT '来源'",
            'cate_id'              =>     $this->smallInteger()->notNull(). " COMMENT '来源'",
            'created_at'        => $this->integer()->unsigned(),
            'created_by'        => $this->integer()->unsigned(),
            'updated_at'        => $this->integer()->unsigned(),
            'updated_by'        => $this->integer()->unsigned(),
        ], $this->tableOptions. " COMMENT '通知表'");


    }

    public function safeDown()
    {
        $this->dropTable($this->tableName);


    }

}
