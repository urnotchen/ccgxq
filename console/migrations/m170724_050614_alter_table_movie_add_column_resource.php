<?php

use yii\db\Migration;
class m170724_050614_alter_table_movie_add_column_resource extends Migration
{

    public $tableName = 'movie';
    public function up()
    {

        $this->addColumn($this->tableName,'resource',$this->smallInteger()->notNull()->defaultValue(0));

        \Yii::$app->db->getSchema()->refreshTableSchema($this->tableName);

        \Yii::$app->db->createCommand('update movie join movie_online_resource on movie_online_resource.movie_id = movie.id set movie.resource = 1')->execute();
    }

    public function down()
    {

    }

}
