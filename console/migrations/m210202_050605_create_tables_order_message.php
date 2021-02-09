<?php

use yii\db\Schema;
use yii\db\Migration;

class m210202_050605_create_tables_order_message extends Migration
{


    public $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';

    public function safeUp()
    {

        $this->createTable('order', [

            'id'                => $this->primaryKey(),
            'position_id'           => $this->smallInteger()->notNull(). " COMMENT '大厅位置id'",
            'name'           => $this->string()->notNull(). " COMMENT '名称'",
            'img'           => $this->string()->notNull(). " COMMENT '图片'",
            'content'           => $this->text()->notNull(). " COMMENT '内容'",
            'map'            => $this->string()->notNull()." COMMENT '地址'",
            'times'            => $this->integer()->notNull()." COMMENT '状态'",

            'created_at'        => $this->integer()->unsigned(),
            'created_by'        => $this->integer()->unsigned(),
            'updated_at'        => $this->integer()->unsigned(),
            'updated_by'        => $this->integer()->unsigned(),
        ], $this->tableOptions. " COMMENT '预约项目表'");

        $this->createTable('message', [

            'id'                => $this->primaryKey(),
            'name'           => $this->string()->notNull(). " COMMENT '姓名'",
            'title'           => $this->string()->notNull(). " COMMENT '标题'",
            'content'           => $this->text()->notNull(). " COMMENT '内容'",
            'tips'           => $this->string(1000)->notNull(). " COMMENT '预约须知'",
            'reply'           => $this->string()->notNull(). " COMMENT '回复'",
            'telephone'           => $this->string()->notNull(). " COMMENT '电话'",
            'status'            => $this->smallInteger()->notNull()." COMMENT '状态'",

            'created_at'        => $this->integer()->unsigned(),
            'created_by'        => $this->integer()->unsigned(),
            'updated_at'        => $this->integer()->unsigned(),
            'updated_by'        => $this->integer()->unsigned(),
        ], $this->tableOptions. " COMMENT '留言咨询'");


    }

    public function safeDown()
    {
        $this->dropTable($this->tableName);


    }

}
