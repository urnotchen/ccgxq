<?php

use yii\db\Schema;
use yii\db\Migration;

class m170619_050607_create_tablle_movie_online_resource extends Migration
{

    public $tableName = 'movie_online_resource';

    public $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';

    public function safeUp()
    {

        $this->createTable($this->tableName, [

            'id'                => $this->primaryKey(),
            'movie_id'          => $this->integer()->unsigned()->notNull(). " COMMENT '电影id'",
            'definition'        => $this->integer()->unsigned()->notNull(). " COMMENT '分辨率'",

            'created_at'        => $this->integer()->unsigned(),
            'updated_at'        => $this->integer()->unsigned(),
        ], $this->tableOptions. " COMMENT '电影网络资源表'");


    }

    public function safeDown()
    {
        $this->dropTable($this->tableName);
    }

}
