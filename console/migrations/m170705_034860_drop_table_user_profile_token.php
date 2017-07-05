<?php

use yii\db\Migration;

class m170705_034860_drop_table_user_profile_token extends Migration
{
    protected $tableUserName = 'user';
    protected $tableProfileName = 'profile';
    protected $tableTokenName = 'token';
    protected $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';

    public function up()
    {
        $this->dropTable($this->tableTokenName);
        $this->dropTable($this->tableProfileName);
        $this->dropTable($this->tableUserName);

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
        echo "m170328_034859_create_table_misc cannot be reverted.\n";

        return false;
    }
    */
}
