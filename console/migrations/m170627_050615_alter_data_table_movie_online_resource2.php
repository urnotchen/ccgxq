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

            $res = \Yii::$app->db->createCommand(MovieIndex::find()->select(['movie_index.*','movie_link.*'])->join('join',MovieLink::tableName(),MovieLink::tableName().'.movie_id='. MovieIndex::tableName().'.id')->where(['between','movie_index.id',$i * 400 , ($i + 1) * 400])->createCommand()->getRawSql())->queryAll();

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
