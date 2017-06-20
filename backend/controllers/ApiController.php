<?php

namespace backend\controllers;

use backend\models\MovieOnlineResource;
use backend\modules\movie\services\MovieListService;
use Yii;

/*}}}*/

/**
 * ApiController class file.
 * @Author haoliang
 * @Date 20.05.2016 16:02
 */
class ApiController extends \yii\rest\Controller
{

    public $_service;

    public function behaviors()
    {/*{{{*/
        $inherit = parent::behaviors();

        $inherit['contentNegotiator']['formats']['application/xml'] = \yii\web\Response::FORMAT_JSON;
        $inherit['contentNegotiator']['formats']['application/json'] = \yii\web\Response::FORMAT_JSON;

        $inherit['access'] = ['class' => \yii\filters\AccessControl::className(),
            'rules' => [
                [
                    'actions' => [
                        'update-zhan','movie-resource'
                    ],
                    'allow' => true,
                    'roles' => ['?'],
                ],
            ],
        ];

        return $inherit;
    }/*}}}*/

    public function actionUpdateZhan(){

        $this->service->updateZhan();
    }

    protected function getService()
    {
        if ($this->_service === null) {
            $this->_service = new MovieListService();
        }

        return $this->_service;
    }

    public function actionMovieResource(){

        $params = \Yii::$app->getRequest()->post();
        foreach($params as $eachArray) {
            MovieOnlineResource::record($eachArray);
        }

        return true;
    }

}
