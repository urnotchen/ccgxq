<?php

use yii\db\Migration;

class m170505_020202_add_column_release_timestamp extends Migration
{


    public function up()
    {
        $res = \backend\modules\movie\models\Movie::find()->where(['release_timestamp' => null])->limit(10000)->all();
//        $res = '2013-9(日本)1023';


        foreach($res as $movie){
            if(!empty($movie->release_date)) {
                $matches = [];
                preg_match('/([1,2]\d{3}-\d{1,2}-\d{1,2}|[1,2]\d{3}-\d{1,2}|[1,2]\d{3})/', $movie->release_date, $matches);
                try {
                    if($matches) {
                        if (strlen($matches[0]) == 6 || strlen($matches[0]) == 7) {
                            $timeStamp = strtotime($matches[0].'-1');
                        }else{
                            if(strlen($matches[0]) == 4) {
                                $timeStamp = strtotime($matches[0] . '-1-1');
                            }else{
                                $timeStamp = strtotime($matches[0]);
                            }
                        }
                        $movie->release_timestamp = $timeStamp;
                        $movie->save();
                    }
                }
                catch(ErrorException $e){
                    var_dump($e);
                    break;
                }
                catch(\yii\db\Exception $e){
                    var_dump($e);
                    break;
                }
//                echo($matches[0]);
//                print('<br/>');
            }else{
                $movie->release_timestamp = strtotime($movie->release_year.'-1-1');
                $movie->save();

            }
        }
    }

    public function down()
    {
        $this->dropTable($this->tableName);
    }


}
