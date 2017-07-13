<?php

use yii\db\Migration;

class m170713_082820_alter_table_film_comment_add_index extends Migration
{


    public function up()
    {
        $this->createIndex('index_type','film_comment','type',false);
    }

    public function down()
    {

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
