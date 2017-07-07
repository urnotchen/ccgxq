<?php

use yii\db\Migration;
class m170706_050613_alter_table_scrapy_update_process_add_column_scrape_times extends Migration
{

    public $tableName = 'scrapy_update_process';
    public function up()
    {
        $this->addColumn($this->tableName,'error_times',$this->smallInteger()->unsigned());

        \Yii::$app->db->getSchema()->refreshTableSchema($this->tableName);

    }

    public function down()
    {

    }

}
