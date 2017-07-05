<?php

use yii\db\Migration;

class m170705_082841_create_table_stat_weekly extends Migration
{
    private $tableName = 'stat_weekly';
    private $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';

    public function up()
    {
        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
            'week' => $this->integer()->notNull(),
            'count' => $this->integer()->notNull()
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
