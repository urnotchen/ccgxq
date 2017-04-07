<?php

use yii\db\Migration;

class m170407_022432_create_table_movie extends Migration
{
    private $tableName = 'movie';
    private $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';

    public function up()
    {
        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
            'name_cn' => $this->string()->notNull(),
            'name_en' => $this->string()->notNull(),
            'poster' => $this->string()->notNull(),
            'director' => $this->string()->notNull(),
            'actor' => $this->text()->notNull(),
            'grade_db' => $this->string(),
            'show_time' => $this->integer(),
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
