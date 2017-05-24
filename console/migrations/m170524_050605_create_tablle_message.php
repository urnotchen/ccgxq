<?php

use yii\db\Schema;
use yii\db\Migration;

class m170524_050605_create_tablle_message extends Migration
{

    public $tableName = 'message';

    public $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';

    public function safeUp()
    {

        $this->createTable($this->tableName, [

            'id'                => $this->primaryKey(),
            'movie_id'           => $this->integer()->unsigned()->notNull(). " COMMENT '电影id'",
            'user_id'           => $this->integer()->unsigned()->notNull(). " COMMENT '用户'",
            'status'            => $this->smallInteger()->notNull()." COMMENT '状态",
            'content'            => $this->string(255)." COMMENT '内容",

            'created_at'        => $this->integer()->unsigned(),
            'created_by'        => $this->integer()->unsigned(),
            'updated_at'        => $this->integer()->unsigned(),
            'updated_by'        => $this->integer()->unsigned(),
        ], $this->tableOptions. " COMMENT '消息表'");


    }

    public function safeDown()
    {
        $this->dropTable($this->tableName);


    }

}
