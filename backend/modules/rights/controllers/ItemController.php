<?php

namespace backend\modules\rights\controllers;

use Yii;
use yii\rbac\Item as BaseItem;
use yii\rbac\Role as BaseRole;

use yii\web\HttpException;

use backend\modules\rights\models\Item;

/**
 * @brief 只能管理permission之上的概念实体: role
 */
class ItemController extends \yii\web\Controller
{

    public $defaultAction = 'roles';

    public function actionRoleCreate()
    {/*{{{*/
        $model = new Item;
        $model->type = BaseItem::TYPE_ROLE;
        $model->isNewRecord = true;

        if (Yii::$app->getRequest()->isPost && $model->load(Yii::$app->getRequest()->post())) {
            if ($model->save()) {
                Yii::$app->getSession()->setFlash('success', '保存角色成功！');
            } else {
                Yii::$app->getSession()->setFlash('error', '保存角色失败！');
            }
        }

        return $this->render('role-create', [
            'model' => $model,
        ]);
    }/*}}}*/

    public function actionRoleUpdate($name)
    {/*{{{*/
        $role = $this->findRole($name);

        $model = new Item;
        $model->loadFromRole($role);

        if (Yii::$app->getRequest()->isPost && $model->load(Yii::$app->getRequest()->post())) {
            if ($model->save()) {
                Yii::$app->getSession()->setFlash('success', '保存角色成功！');
            } else {
                Yii::$app->getSession()->setFlash('error', '保存角色失败！');
            }
        }

        return $this->render('role-update', [
            'model' => $model,
        ]);
    }/*}}}*/

    public function actionRoles()
    {/*{{{*/
        $roles = Yii::$app->authManager->getRoles();

        $dataProvider = new \yii\data\ArrayDataProvider([
            'allModels' => $roles
        ]);

        return $this->render('roles', [
            'dataProvider' => $dataProvider,
        ]);
    }/*}}}*/

    public function actionRoleDelete($name)
    {/*{{{*/
        if (Item::delete($this->findRole($name))) {
            Yii::$app->getSession()->setFlash('success', "已删除角色{$name}");
            return $this->redirect(['roles']);
        } else {
            throw new HttpException(500, '删除角色失败');
        }
    }/*}}}*/

    public function actionRole($name)
    {/*{{{*/
        $role = $this->findRole($name);

        return $this->render('role', [
            'role' => $role,
        ]);
    }/*}}}*/

    public function findRole($name)
    {/*{{{*/
        if ( ($role = Item::getRole($name)) === null) {
            throw new HttpException(404, 'role not found.');
        }

        return $role;
    }/*}}}*/

}
