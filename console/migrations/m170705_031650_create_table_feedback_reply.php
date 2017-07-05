<?php

use yii\db\Migration;

class m170705_031650_create_table_feedback_reply extends Migration
{
    private $tableName = 'feedback_reply';
    private $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';

    public function up()
    {
        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
            'fb_id' => $this->string()->notNull(),
            'content' => 'VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci',
            'user_id' => $this->integer()->notNull(),
            'is_sender' => $this->smallInteger()->notNull(),
            'status' => $this->smallInteger()->notNull(),
            'created_at' => $this->integer()->notNull(),
            'created_by' => $this->integer()->notNull(),
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
