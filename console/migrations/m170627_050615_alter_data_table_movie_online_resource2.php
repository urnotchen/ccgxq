<?php

use yii\db\Schema;
use yii\db\Migration;
use common\models\MovieIndex;
use common\models\MovieDisk;
use common\models\MovieLink;
class m170627_050615_alter_data_table_movie_online_resource2 extends Migration
{

    public function up()
    {

        for($i = 0 ; $i < 100; $i ++) {

            $begin = $i * 400 ;
            $end = $begin + 400;
            $res = \Yii::$app->db->createCommand("select movie_index.*,movie_link.* from movie_index join movie_link on movie_link.movie_id=movie_index.id where movie_index.id BETWEEN {$begin} and {$end}")->queryAll();

            foreach ($res as $one) {
                $record = new \common\models\MovieOnlineResource();
                if ($one['douban']) {
                    $record->movie_id = $one['douban'];
                } else {
                    $douban = \common\models\Movie::findOne(['imdb' => $one['imdb']]);
                    if ($douban) {
                        $record->movie_id = $douban->id;
                    } else {
                        continue;
                    }
                }
                $record->definition = $one['definition'];
                $record->save();
            }
        }
    }

    public function down()
    {

    }

}
