<?php

namespace backend\modules\setting\controllers;

use backend\modules\rights\models\Assignment;
use backend\modules\rights\models\TaskUser;

use backend\modules\setting\models\Partment;
use Yii;
use yii\db\Query;
use yii\helpers\ArrayHelper;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\filters\VerbFilter;
use yii\base\Exception;
use yii\filters\AccessControl;
use backend\modules\setting\models\User;
use backend\modules\setting\models\searches\UserSearch;
/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
{

    public function behaviors()
    {/*{{{*/
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index', 'view', 'create', 'update', 'delete', 'password','create-pt'],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            return Yii::$app->getUser()->can(\backend\modules\rights\components\Rights::PERMISSION_USER_MANAGE);
                        },
                    ],
                    [
                        'actions' => ['profile'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }/*}}}*/

    public function actionIndex()
    {/*{{{*/
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $status_kv = User::enum('status');
        $user_kv = User::kv('id', 'real_name');

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'status_kv' => $status_kv,
            'user_kv' => $user_kv,
        ]);
    }/*}}}*/

    public function actionView($id)
    {/*{{{*/
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }/*}}}*/

    public function actionProfile()
    {/*{{{*/
        return $this->render('profile', [
            'model' => $this->findModel(Yii::$app->getUser()->identity->id),
        ]);
    }/*}}}*/

    public function actionCreate()
    {/*{{{*/
        $model = new User();
        $model->scenario = 'create';

        $department_kv = Partment::kv('id','partname');

        if ($model->load(Yii::$app->request->post()) && $model->save())
            return $this->redirect(['view', 'id' => $model->id]);

        return $this->render('create', [
            'model' => $model,
            'department_kv' => $department_kv,
        ]);
    }/*}}}*/

    public function actionCreatePt($username,$pwd,$realname,$email,$type,$id)
    {/*{{{*///$username,$pwd,$realname,$email$username,$pwd,$realname,$email,$type
        if(!($username && $pwd && $realname && $email && $type && $id))
            throw new BadRequestHttpException("缺少参数");
//        $auth =Yii::$app->authManagerTask;
        $roles = $this->getFilterRoles();
        $assignment = new Assignment();



        $model = new User();
        $model->scenario = 'create';
        $task_user = new TaskUser();
        if(Yii::$app->request->isPost) {$task_user->load(Yii::$app->request->post());
//            var_dump($task_user);//return;
            $transaction = Yii::$app->db->beginTransaction();

            try {
                    if ($model->load(Yii::$app->request->post()) && $model->save()) {
//                           var_dump($model->id);
                    }else{
//                        var_dump($model->getErrors());
//                        return;
//                        echo $model->getErrors();

                    }

                $transaction_task = Yii::$app->db_task->beginTransaction();
                try {
//                    $id = 666;

                    if ($task_user->load(Yii::$app->request->post()) && $task_user->saveTaskUser($model->id) ){
//                        if($task_user->saveTaskUser($model->id))
//                        echo "task ok";
                    }
//                        return $this->redirect(['view', 'id' => $model->id]);
                    else {
//                        echo"task";var_dump($task_user->getErrors());
//                        User::findOne($model->id)->delete();
                    }
//                    var_dump($model->id);
                    if ($assignment->load(Yii::$app->request->post()) && $assignment->savePt('', $model->id)) {
//                        echo "assign ok";
//                        return $this->redirect(['view', 'id' => $model->id]);
                    }else {

//                        var_dump($assignment->getErrors());
//                        User::findOne($model->id)->delete();

                    }

                    $transaction->commit();
                }catch (Exception $e) {
                    $transaction_task->rollback();
                    $transaction->rollback();
//                    throw $e;
                }

                $transaction_task->commit();
                //ajax提交给兼职系统 可以发邮件了

                $command = Yii::$app->db_pt->createCommand("update send_email_list set status = 0 where user_id={$id} and status = 4");
                $res = $command->execute();


                $this->redirect('index');



            } catch (Exception $e) {
//                User::findOne($model->id)->delete();
                $transaction_task->rollback();
                $transaction->rollback();
//                return flase;
//                throw $e;
            }
//            var_dump($model);
        }
        $arr = [];
        switch($type){
            case 1 : $arr[0] = 1;
                     $arr[1] = 0;
                    break;
            case 2 : $arr[0] = 0;
                     $arr[1] = 1;
                    break;
            case 3 : $arr[0] = 1;
                     $arr[1] = 1;
                    break;
            default :
                    throw new BadRequestHttpException("参数链接不正确");
        }
        $account_list = Yii::$app->db_task->createCommand("select open_id,name from stat_account where belong = 0")->queryAll();
        $account_list = ArrayHelper::map($account_list,'open_id','name');
//        else
//            var_dump($model->getErrors());
        return $this->render('create_pt', [
            'model' => $model,
            'username' => $username,
            'pwd'      => $pwd,
            'realname' => $realname,
            'assignment' => $assignment,
            'email'     => $email,
            'roles'    => $roles,
            'task_user' => $task_user,
            'arr'       => $arr,
            'account_list' => $account_list,
        ]);
    }/*}}}*/


    public function getFilterRoles()
    {
        $roles = Yii::$app->authManagerTask->getRoles();
        if (!empty($exclude)) {
            foreach ($exclude as $i) {
                unset($roles[$i]);
            }
        }
        $roles =  ArrayHelper::map($roles, 'name', 'description');
        $filterRoles = [];
        foreach ($roles as $name => $description) {
            if(is_numeric($name)){
                continue;
            }
            $filterRoles[$name] = $description;
        }
        return $filterRoles;
    }

    public function actionUpdate($id)
    {/*{{{*/
        $model = $this->findModel($id);
        $model->scenario = 'default';
        $department_kv = Partment::kv('id','partname');

        if ($model->load(Yii::$app->request->post()) && $model->save())
            return $this->redirect(['view', 'id' => $model->id]);

        return $this->render('update', [
            'model' => $model,
            'department_kv' => $department_kv,
        ]);
        }/*}}}*/

    public function actionDelete($id)
    {/*{{{*/

        throw new ForbiddenHttpException('删除权限暂不开放');

        #$this->findModel($id)->delete();

        #return $this->redirect(['index']);
    }/*}}}*/

    public function actionPassword($id)
    {/*{{{*/
        $model = $this->findModel($id);
        $model->scenario = User::SCENARIO_PASSWORD;

        if ( Yii::$app->getRequest()->isPost) {
            if ($model->load(Yii::$app->getRequest()->post()) && $model->validate()) {
                if ($model->save(false)) {
                    Yii::$app->getSession()->setFlash('success', '修改用户密码成功');
                    return $this->redirect(['index']);
                } else {
                    Yii::$app->getSession()->setFlash('error', '修改用户密码失败');
                }
            } else {
                Yii::$app->getSession()->setFlash('error', '验证用户信息失败');
            }
        }

        $model->password = null;

        return $this->render('password', [
            'model' => $model,
        ]);
    }/*}}}*/

    protected function findModel($id)
    {/*{{{*/
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }/*}}}*/

}
