<?php

use yii\db\Migration;

class m170407_030914_create_table_resource extends Migration
{
    private $tableName = 'movie_resource';
    private $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';

    public function up()
    {
        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
            'movie_id' => $this->integer()->notNull(),
            'bilibili' => $this->string(),
            'vqq' => $this->string(),
            'iqiyi' => $this->string(),
            'youku' => $this->string(),
            'souhu' => $this->string(),
            'acfun' => $this->string(),
            'created_at' => $this->integer(),
            'created_by' => $this->integer(),
            'updated_at' => $this->integer(),
            'updated_by' => $this->integer()
        ], $this->tableOptions);
    }

    public function down()
    {
        $this->dropTable($this->tableName);
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
