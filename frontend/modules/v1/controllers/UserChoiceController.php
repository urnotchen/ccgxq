<?php
/**
 * Created by PhpStorm.
 * User: chenxi
 * Date: 2017/5/23
 * Time: 11:53
 */

namespace frontend\modules\v1\controllers;

use frontend\components\rest\Controller;
use frontend\modules\v1\models\FilmChoiceUser;
use frontend\modules\v1\models\forms\UserActionForm;
use frontend\modules\v1\models\forms\UserChoiceListForm;

class UserChoiceController extends Controller{


    public function behaviors()
    {
        $inherit = parent::behaviors();

        $inherit['authenticator']['only'] = [
            'user-action','user-movie-statistics',
        ];
        $inherit['authenticator']['authMethods'] = [
            \frontend\modules\v1\components\AccessTokenAuth::className(),
        ];



        return $inherit;
    }
    public function verbs()
    {
        return [
            'user-action'    => ['post'],
            'user-movie-statistics'    => ['get'],

        ];
    }

    /*
     * 用户想看/订阅操作(添加/取消)
     * */
    public function actionUserAction(){

        $rawParams = \Yii::$app->getRequest()->post();

        $form = new UserActionForm();
        $form->prepare($rawParams);

        return FilmChoiceUser::userAction($this->getUser()->id,$form->movie_id,$form->type,$form->action);

    }

    public function actionUserMovieStatistics(){

        $rawParams = \Yii::$app->getRequest()->get();

//        $form = new UserChoiceListForm();
//        $form->prepare($rawParams);

        $user_id = $this->getUser()->id;
        $typeArr =  FilmChoiceUser::getTypeNum($user_id,FilmChoiceUser::TYPE_SAW);
        $movCount = array_sum(array_column($typeArr,'type_num'));
        $arr =[];
        foreach($typeArr as $type){
            $temp['type_name'] = $type['name'];
            $temp['scale'] = round($type['type_num']/$movCount,3)*100;
            $arr['type'][] = $temp;
        }

        $starArr = FilmChoiceUser::getStarNum($user_id,FilmChoiceUser::TYPE_SAW);
        $arr['star'] = $starArr;
        $arr['saw_num'] = (int)FilmChoiceUser::getUserTypeNum($user_id,FilmChoiceUser::TYPE_SAW);
        $arr['want_num'] = (int)FilmChoiceUser::getUserTypeNum($user_id,FilmChoiceUser::TYPE_WANT);
        $arr['subscribe_num'] = (int)FilmChoiceUser::getUserTypeNum($user_id,FilmChoiceUser::TYPE_SUBSCRIBE);
        return $arr;

    }
}