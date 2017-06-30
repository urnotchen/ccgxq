<?php

use yii\db\Schema;
use yii\db\Migration;
use common\models\FilmComment;
class m170630_050613_alter_table_film_comment_add_column_source extends Migration
{

    public $tableName = 'film_comment';
    public function up()
    {
        $this->addColumn($this->tableName,'source',$this->smallInteger());

        \Yii::$app->db->getSchema()->refreshTableSchema($this->tableName);

    }

    public function down()
    {

    }

}
