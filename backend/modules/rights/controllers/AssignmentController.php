<?php

namespace backend\modules\rights\controllers;

use Yii;

use yii\web\HttpException;
use yii\helpers\ArrayHelper;

use backend\modules\rights\models\Assignment;
use backend\modules\rights\models\Item;
use backend\modules\rights\models\User;

class AssignmentController extends \yii\web\Controller
{

    public function actionIndex()
    {/*{{{*/
        $assignments = Assignment::getAllAssignments();

        $dataProvider = new \yii\data\ArrayDataProvider([
            'allModels' => $assignments
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }/*}}}*/

    /**
     * @brief 分配用户角色
     *
     * @return 
     */
    public function actionBind($user_id = null)
    {/*{{{*/

        $model = new Assignment;

        if ($user_id !== null) {
            $user_id = intval($user_id);
            $model->user_id = $user_id;
            $model->isNewRecord = false;
        }

        if (Yii::$app->getRequest()->isPost && $model->load(Yii::$app->getRequest()->post()) ) {
            if ($model->save()) {
                Yii::$app->getSession()->setFlash('success', '绑定用户角色成功！');
                #return $this->redirect(['index']);
            } else {
                Yii::$app->getSession()->setFlash('error', '绑定用户角色失败！');
            }
        } else {
            $model->roles = array_keys(Assignment::getRolesByUser($user_id));
        }

        $users = User::kv('id', 'username', [
            'where' => ['status' => User::STATUS_ACTIVE]
        ]);

        $roles = Item::getAllRoles();

        return $this->render('bind', [
            'model' => $model,
            'users' => $users,
            'roles' => $roles,
        ]);
    }/*}}}*/

    public function actionRevokeAll($user_id)
    {/*{{{*/
        if ( Assignment::revokeAllRoles($user_id)) {
            Yii::$app->getSession()->setFlash('success', '解绑成功!');
            return $this->redirect(['index']);
        }
        throw new HttpException(500, '解绑失败');
    }/*}}}*/

}
