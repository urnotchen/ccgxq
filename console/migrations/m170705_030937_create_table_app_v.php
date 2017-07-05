<?php

use yii\db\Migration;

class m170705_030937_create_table_app_v extends Migration
{
    private $tableName = 'app_v';
    private $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';

    public function up()
    {
        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
            'os' => $this->smallInteger()->notNull()->defaultValue(1),
            'version' => $this->string()->notNull(),
            'is_imp' => $this->smallInteger()->notNull(),
            'title' => $this->string(),
            'content' => $this->string(),
            'update_url' => $this->string(),
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
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170401_030937_create_table_app_v cannot be reverted.\n";

        return false;
    }
    */
}
