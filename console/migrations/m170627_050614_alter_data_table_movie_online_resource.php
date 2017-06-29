<?php

use yii\db\Schema;
use yii\db\Migration;
use common\models\MovieIndex;
use common\models\MovieDisk;
use common\models\MovieLink;
class m170627_050614_alter_data_table_movie_online_resource extends Migration
{

    public function up()
    {
        $res = \Yii::$app->db->createCommand(MovieDisk::find()->select(['movie_index.*','movie_disk.*'])->join('join',MovieIndex::tableName(),MovieDisk::tableName().'.movie_id='. MovieIndex::tableName().'.id')->createCommand()->getRawSql())->queryAll();

        foreach($res as $one){
            $record = new \common\models\MovieOnlineResource();
            if($one['douban']) {
                $record->movie_id = $one['douban'];
            }else{
                $douban = \common\models\Movie::findOne(['imdb' => $one['imdb']]);
                if($douban){
                    $record->movie_id = $douban->id;
                }else{
                    continue;
                }
            }
            $record->definition = $one['definition'];
            $record->save();
        }


    }

    public function down()
    {

    }

}
