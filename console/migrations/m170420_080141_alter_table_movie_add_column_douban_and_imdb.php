<?php

use yii\db\Migration;

class m170420_080141_alter_table_movie_add_column_douban_and_imdb extends Migration
{
    private $tableName = 'movie';

    public function up()
    {
        $this->addColumn($this->tableName, 'douban', $this->integer());
        $this->addColumn($this->tableName, 'imdb', $this->string());
    }

    public function down()
    {
        echo "m170420_080141_alter_table_movie_add_column_douban_and_imdb cannot be reverted.\n";

        return false;
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
