<?php

use yii\db\Migration;

class m170711_082820_create_table_stat_movie extends Migration
{
    private $tableName = 'stat_movie';
    private $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';

    public function up()
    {
        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
            'day' => $this->integer()->notNull(),
            'movie_id' => $this->integer()->notNull(),
            'num' => $this->integer()->notNull(),
            'type' => $this->smallInteger()->notNull(),
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
