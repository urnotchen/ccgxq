<?php

namespace backend\modules\setting\controllers;

use backend\modules\setting\models\forms\QiniuForm;
use backend\modules\setting\models\searches\MiscSearch;
use Yii;

use backend\modules\setting\models\Misc;

/**
 * Class MiscController
 * @package backend\modules\setting\controllers
 */
class MiscController extends \yii\web\Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['policy', 'upload', 'create', 'update','index','qiniu-create'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ]
            ],
            'footprint' => [
                'class' => \bluelive\components\FootprintBehavior::className(),
                'enableAction' => [
                    'policy', 'create', 'update'
                ],
            ],
        ];
    }

    public function actions() {
        return [
            'upload' => [
                'class' => \common\helpers\UeditorUpload::className(),
                'uploadBasePath' => '@webroot', //file system path ps:当前运行应用的 Web 入口目录
                'uploadBaseUrl' => '@web', //web path @web ps:当前运行应用的根 URL
                'csrf' => true, //csrf校验

                'configPatch' => [
                    'imageMaxSize' =>  2 * 1024 * 1024, //图片
                    'scrawlMaxSize' => 500 * 1024, //涂鸦
                    'catcherMaxSize' => 500 * 1024, //远程
                    'videoMaxSize' => 1024 * 1024, //视频
                    'fileMaxSize' => 1024 * 1024, //文件
                    'imageManagerListPath' => '/', //图片列表
                    'fileManagerListPath' => '/', //文件列表
                ],

                'pathFormat' => [
                    'imagePathFormat' => '/uploads/images/{yyyy}{mm}{dd}/{time}{rand:6}',
                    'scrawlPathFormat' => '/uploads/images/{yyyy}{mm}{dd}/{time}{rand:6}',
                    'snapscreenPathFormat' => '/uploads/images/{yyyy}{mm}{dd}/{time}{rand:6}',
                    'catcherPathFormat' => '/uploads/images/{yyyy}{mm}{dd}/{time}{rand:6}',
                    'videoPathFormat' => '/files/videos/{yyyy}{mm}{dd}/{time}{rand:6}',
                    'filePathFormat' => '/files/files/{yyyy}{mm}{dd}/{time}{rand:6}',
                ],
                'configPatch' => [
                    'imageManagerListPath' => 'uploads/images', //图片列表
                    'fileManagerListPath' => 'uploads/files', //文件列表
                ],

                'beforeUpload' => function($action) {

                },
                'afterUpload' => function($action) {

                },
            ],
        ];
    }
    public function actionIndex()
    {
        $searchModel = new MiscSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionQiniuCreate(){

        $qiniuForm = new QiniuForm();

        $model = Misc::getInstance(['name' => Misc::NAME_QINIU_INFO],True);

        if(Yii::$app->request->isPost) {
            $postParams = Yii::$app->getRequest()->post();

            if($qiniuForm->load($postParams)) {
                $model->policy = json_encode($postParams['QiniuForm']);
                $model->save();
            }
        }

        return $this->render('qiniu', [
            'model' => $qiniuForm
        ]);
    }
    public function actionPolicy()
    {
        $model = Misc::getInstance(['name' => Misc::NAME_USER_AGREEMENT]);

        if ($model->isNewRecord) {
            return $this->redirect('create');
        }

        return $this->render('policy', [
            'model' => $model
        ]);
    }

    public function actionCreate()
    {
        $model = new Misc();

        $model->name = Misc::NAME_USER_AGREEMENT;
        if(Yii::$app->request->isPost) {
            $postParams = Yii::$app->getRequest()->post();

            if($model->load($postParams) && $model->save()) {
                return $this->redirect(['policy']);
            }
        }

        return $this->render('edit', [
            'model' => $model
        ]);
    }

    public function actionUpdate($id)
    {
        $model = Misc::findOneOrException(['id' => $id]);

        if(Yii::$app->request->isPost) {
            $postParams = Yii::$app->getRequest()->post();

            if($model->load($postParams) && $model->save()) {
                return $this->redirect(['policy']);
            }
        }

        return $this->render('edit', [
            'model' => $model
        ]);
    }
}

?>