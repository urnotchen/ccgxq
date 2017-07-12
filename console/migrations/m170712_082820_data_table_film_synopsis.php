<?php

use yii\db\Migration;

class m170712_082820_data_table_film_synopsis extends Migration
{


    public function up()
    {
        $i = 40000;
        while($i < 100000){

            $res = \common\models\FilmSynopsis::find()->where(['between','id',$i,$i + 5000])->all();

            foreach($res as $eachSynopsis){
                $eachSynopsis->content =strip_tags($eachSynopsis->content);
                $eachSynopsis->content = trim(preg_replace("/\n+/", "\n", str_replace(array('                                　　','                                    ','                        '), '', strip_tags( $eachSynopsis->content ))));
                $eachSynopsis->save();
            }

            $i += 5000;
        }
    }

    public function down()
    {

    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
