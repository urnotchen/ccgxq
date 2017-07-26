<?php

use yii\db\Migration;

class m170726_082820_data_table_film_property_delete_wrong_data extends Migration
{


    public function up()
    {
        \common\models\FilmProperty::deleteAll(['created_at' => 1501051919,'created_by' => 0]);
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
