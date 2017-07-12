<?php

use yii\db\Migration;

class m170711_082819_create_table_stat_user_action extends Migration
{
    private $tableName = 'stat_user_action';
    private $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';

    public function up()
    {
        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
            'day' => $this->integer()->notNull(),
            'count' => $this->integer()->notNull(),
            'type' => $this->smallInteger()->notNull(),
            'sub_type' => $this->smallInteger(),
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
