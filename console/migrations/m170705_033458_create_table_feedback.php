<?php

use yii\db\Migration;

class m170109_033458_create_table_feedback extends Migration
{
    private $tableName = 'feedback';
    private $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';

    public function up()
    {
        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
            'content' => $this->string()->notNull(),
            'type' => $this->smallInteger()->notNull(),
            'status' => $this->smallInteger(),
            'app_version' => $this->string()->notNull(),
            'phone_model' => $this->smallInteger()->notNull(),
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
