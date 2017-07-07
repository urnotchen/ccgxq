<?php

use yii\db\Migration;
class m170706_050614_alter_table_scrapy_update_process_construct_unique extends Migration
{

    public $tableName = 'scrapy_update_process';
    public function up()
    {

        \common\models\ScrapyUpdateProcess::deleteAll();

        $this->execute('alter table scrapy_update_process add unique key(movie_id,scrape_date)');

        \Yii::$app->db->getSchema()->refreshTableSchema($this->tableName);

    }

    public function down()
    {

    }

}
