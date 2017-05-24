<?php

use yii\db\Schema;
use yii\db\Migration;

class m170522_050605_alter_tablle_film_recommend_user_add_column_status extends Migration
{

    public $tableName = 'film_recommend_user';
    public function up()
    {
        $this->addColumn($this->tableName,'status',$this->smallInteger());
        $this->dropColumn($this->tableName,'created_by');
        $this->dropColumn($this->tableName,'updated_by');
        \Yii::$app->db->getSchema()->refreshTableSchema($this->tableName);

    }

    public function down()
    {

    }

}
