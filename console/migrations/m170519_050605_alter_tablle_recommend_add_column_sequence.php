<?php

use yii\db\Schema;
use yii\db\Migration;

class m170519_050605_alter_tablle_recommend_add_column_sequence extends Migration
{

    public $tableName = 'film_recommend_offical';
    public function up()
    {

        $this->addColumn($this->tableName,'sequence',$this->integer());
        $this->renameTable('film_recommend_offical','film_recommend_official');

    }

    public function down()
    {
        echo "m151020_114717_rights_permission_first cannot be reverted.\n";

        return false;
    }

}
