<?php

use yii\db\Schema;
use yii\db\Migration;
use common\models\FilmComment;
class m170703_050613_alter_table_user_token_drop_column_device_type_name extends Migration
{

    public $tableName = 'user_token';
    public function up()
    {
        $this->dropColumn($this->tableName,'device');
        $this->dropColumn($this->tableName,'name');
        $this->dropColumn($this->tableName,'type');

        \Yii::$app->db->getSchema()->refreshTableSchema($this->tableName);

    }

    public function down()
    {

    }

}
