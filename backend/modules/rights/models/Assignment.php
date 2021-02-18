<?php

namespace backend\modules\rights\models;

use Yii;
use yii\base\UserException;
use yii\base\Exception;
use yii\helpers\ArrayHelper;

use backend\modules\rights\models\User;

class Assignment extends \yii\base\Model
{

    public $user_id, $roles;

    public $isNewRecord = true;

    public function rules()
    {/*{{{*/
        return [
            [['roles', 'user_id'], 'required'],

            ['user_id', 'integer'],
            ['roles', 'each', 'rule' => ['string', 'max' => 64]],

            [
                'user_id', 'exist',
                'targetClass' => User::className(), 'targetAttribute' => 'id',
            ],
        ];
    }/*}}}*/

    public function attributeLabels()
    {/*{{{*/
        return [
            'user_id' => '用户',
            'roles' => '角色',
        ];
    }/*}}}*/

    public function save($runValidation = true)
    {/*{{{*/
        if ($runValidation && ! $this->validate()) return false;

        $transaction = Yii::$app->db->beginTransaction();

        try {

            $auth = Yii::$app->authManager;


            # 旧的不去，新的不来
            if ( static::hasBeenAssignmented($this->user_id) && ! $auth->revokeAll($this->user_id)) {
                throw new UserException('failed to revoking roles from staff');
            }

            foreach ($this->roles as $i) {
                $auth->assign(
                    $auth->getRole($i),
                    $this->user_id
                );
            }

            $transaction->commit();

            return true;

        } catch (Exception $e) {
            $transaction->rollback();
            throw $e;
        }
    }/*}}}*/
    public function savePt($runValidation = true,$user_id)
    {/*{{{*/
//        return $this->roles;
        if ($runValidation && ! $this->validate()) return false;

        $transaction = Yii::$app->db_task->beginTransaction();
        try {

            $auth = Yii::$app->authManagerTask;


            # 旧的不去，新的不来
            if ( static::hasBeenAssignmented($user_id) && ! $auth->revokeAll($user_id)) {
                throw new UserException('failed to revoking roles from staff');
            }

            foreach ($this->roles as $i) {
                $auth->assign(
                    $auth->getRole($i),
                    $user_id
                );
            }

            $transaction->commit();

            return true;

        } catch (Exception $e) {
            $transaction->rollback();
            throw $e;
        }
    }/*}}}*/

    public static function getRolesByUser($user_id)
    {/*{{{*/
        $auth = Yii::$app->authManager;

        return ArrayHelper::map(
            $auth->getRolesByUser($user_id),
            'name', 'description'
        );
    }/*}}}*/

    public static function getAllAssignments()
    {/*{{{*/
        $assignments = Yii::$app->db
            ->createCommand('select user_id, item_name from ' . Yii::$app->authManager->assignmentTable)
            ->queryAll();

        /*
         * [1 => [role, role, role],]
         */
        $result = [];
        foreach ($assignments as $i) {
            $result[$i['user_id']][] = $i['item_name'];
        }

        if (empty($result))
            return [];

        $userNames = User::kv('id', 'username');

        /*
         * [ [user_id => 43, roles => [1,3,4,5,6] ], ]
         */
        $result_2 = [];
        foreach ($result as $k => $v) {
            $result_2[$k] = [
                'user_id' => $k,
                'username' => $userNames[$k],
                'roles' => $v
            ];
        }

        return $result_2;
    }/*}}}*/

    public static function revokeAllRoles($user_id)
    {/*{{{*/
        return Yii::$app->authManager->revokeAll($user_id);
    }/*}}}*/

    public static function hasBeenAssignmented($user_id)
    {/*{{{*/
        $count = Yii::$app->db
            ->createCommand('select count(*) from auth_assignment where user_id=:user_id', [':user_id' => $user_id])
            ->queryScalar();

        return intval($count) > 0;
    }/*}}}*/

}
