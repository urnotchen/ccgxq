<?php

use yii\db\Migration;

class m170705_082819_create_table_stat_daily extends Migration
{
    private $tableName = 'stat_daily';
    private $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';

    public function up()
    {
        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
            'day' => $this->integer()->notNull(),
            'count' => $this->integer()->notNull(),
            'daily' => 'mediumtext',
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
