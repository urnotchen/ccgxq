<?php

use yii\db\Schema;
use yii\db\Migration;

class m170524_050607_create_tablle_comment_zan extends Migration
{

    public $tableName = 'comment_zan';

    public $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';

    public function safeUp()
    {

        $this->createTable($this->tableName, [

            'id'                => $this->primaryKey(),
            'comment_id'         => $this->integer()->unsigned()->notNull(). " COMMENT '评论'",
            'user_id'           => $this->integer()->unsigned()->notNull(). " COMMENT '用户'",
            'status'            => $this->smallInteger()->notNull()." COMMENT '状态'",

            'created_at'        => $this->integer()->unsigned(),
            'updated_at'        => $this->integer()->unsigned(),
        ], $this->tableOptions. " COMMENT '点赞评论表'");


    }

    public function safeDown()
    {
        $this->dropTable($this->tableName);


    }

}
