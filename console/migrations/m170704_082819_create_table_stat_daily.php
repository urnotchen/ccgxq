<?php

use yii\db\Migration;

class m170704_082819_create_table_stat_daily extends Migration
{
    private $tableName = 'stat_daily';
    private $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';

    public function up()
    {
        $this->createTable($this->tableName, [

            'id' => $this->primaryKey(),
            'year' => $this->integer()->notNull(),
            'month' => $this->integer()->notNull(),
            'week' => $this->integer()->notNull(),
            'day' => $this->integer()->notNull(),
            'count' => $this->integer()->notNull(),
            'daily' => 'mediumtext',
            'type' => $this->smallInteger()->notNull(),

            'begin_at' => $this->integer()->notNull(),
            'end_at' => $this->integer()->notNull(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
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
