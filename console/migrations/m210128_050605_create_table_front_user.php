<?php

use yii\db\Schema;
use yii\db\Migration;

class m210128_050605_create_table_front_user extends Migration
{



    public $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';

    public function safeUp()
    {
        /*
         *
         * 前台用户表
         * */
        $this->createTable('front_user', [

            'id' => $this->primaryKey(),
            'username' => $this->string()->notNull() . " COMMENT '登录账号'",
            'certificates_type' => $this->smallInteger()->unsigned()->notNull() . " COMMENT '证件类型'",
            'certificates_num' => $this->string()->notNull() . " COMMENT '证件号码'",
            'password' => $this->string()->notNull() . " COMMENT '密码'",
            'auth_key' => $this->string()->notNull() . " COMMENT '密码'",
            'password_reset_token' => $this->string() . " COMMENT '密码'",
            'real_name' => $this->string()->notNull() . " COMMENT '真实姓名'",
            'telephone' => $this->string()->notNull() . " COMMENT '手机号'",
            'status' => $this->smallInteger()->unsigned()->notNull() . " COMMENT '状态'",

            'created_at' => $this->integer()->unsigned(),
            'created_by' => $this->integer()->unsigned(),
            'updated_at' => $this->integer()->unsigned(),
            'updated_by' => $this->integer()->unsigned(),
        ], $this->tableOptions . " COMMENT '前台用户表'");


    }
}
