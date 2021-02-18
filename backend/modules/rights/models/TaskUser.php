<?php

namespace backend\modules\rights\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
//use app\models\BaseUser;
use yii\db\Exception;
class TaskUser extends \yii\db\ActiveRecord
{

    use \common\traits\EnumTrait;
    use \common\traits\KVTrait;

    const  NOTICE_NOT = 0, NOTICED_FINISH = 1;

    const BELONG_EXTERNAL = 0, BELONG_INTERNAL = 1;

    const BOOLEAN_NO = 0, BOOLEAN_YES = 1;

    const STATUS_INACTIVE = 0, STATUS_ACTIVE = 1;

    public function behaviors()
    {/*{{{*/
        return [

            'timestamp' => TimestampBehavior::className(),
            'blameable' => BlameableBehavior::className(),
        ];
    }/*}}}*/

    public static function tableName()
    {/*{{{*/
        return 'user';
    }/*}}}*/

    public function rules()
    {/*{{{*/
        return [
            [['id', 'belong','weibo_account', 'is_weibo_author', 'is_weixin_author', 'status'], 'required'],
            [['id', 'belong', 'is_weibo_author', 'is_weixin_author', 'status', 'notice_status'], 'integer'],
            [['email_to','flag'], 'string'],
            [['salary'], 'number'],
        ];
    }/*}}}*/

    public function attributeLabels()
    {/*{{{*/
        return [
            'id'               => 'ID',
            'belong'           => '所属',
            'is_weibo_author'  => '微博作者',
            'is_weixin_author' => '微信作者',
            'salary'           => '兼职酬劳',
            'status'           => '状态',
            'created_at'       => 'Created At',
            'created_by'       => 'Created By',
            'updated_at'       => 'Updated At',
            'updated_by'       => 'Updated By',
            'flag'             => '标志位',
            #文章提交审核通知审核人
            'email_to'         => '审核提醒',
            #工作日任务提醒
            'notice_status'    => '提醒状态',
        ];
    }/*}}}*/
    /*
     * 获取User系统的real_name
     * */
    public function getName()
    {
        return User::findOne($this->id)->real_name;
    }
    /*
     * 获取User系统的avatar
     * */
    public function getAvatar()
    {
        return User::findOne($this->id)->avatar;
    }

    public static function getEnumData()
    {/*{{{*/
        return [
            'notice_status' => [
                self::NOTICE_NOT    => '未提醒',
                self::NOTICED_FINISH => '已提醒',
            ],
            'belong' => [
                self::BELONG_INTERNAL => '内部',
                self::BELONG_EXTERNAL => '外部',
            ],
            'boolean' => [
                self::BOOLEAN_YES => '是',
                self::BOOLEAN_NO  => '否',
            ],
            'status' => [
                self::STATUS_ACTIVE   => '启用',
                self::STATUS_INACTIVE => '禁用',
            ],
        ];
    }/*}}}*/

    /**
     * @brief getUsersWithFullInfo 
     *
     * @param $ids []
     * @param $fields 'id,username'
     *
     * @return boolean | list
     */
    public static function getUsersWithFullInfo($ids = [], $fields = '')
    {/*{{{*/
        if (! empty($fields) && ! preg_match('/^[0-9a-zA-Z,_-]*$/', $fields)) {
            return false;
        }

        if (empty($ids)) {
            $ids = static::find()->select('id')->column();
        }

        if (is_string($ids)) {
            $ids = (array)$ids;
        }

        $bluelive = Yii::$app->authClientCollection->getClient('bluelive');

        return $bluelive->users(implode(',', $ids), $fields);
    }/*}}}*/

    public static  function getDb() {
        return Yii::$app->db_task;
    }

    public  function saveTaskUser($user_id){
//        var_dump($this->weibo_account);
//        throw new Exception('save user failed.');return false;
        if(!$user_id)
            throw new Exception('save user failed.');
//        $task_user = new TaskUser();
        $this->id = $user_id;
        $this->status = TaskUser::STATUS_ACTIVE;
        $this->belong = TaskUser::BELONG_EXTERNAL;
        $this->weibo_account = serialize($this->weibo_account);

//        if(!$user_id){
//            return false;
//        }
//        $transaction = Yii::$app->db_task->beginTransaction();
//
//        try {

//            $this->status = TaskUser::STATUS_ACTIVE;
//            $this->belong = TaskUser::BELONG_EXTERNAL;// return $this;
            if (!$this->save()) {
//                return false;
                throw new Exception('save user failed.');
            }else{
//                var_dump($this->getErrors());
//                return $this->getErrors();
            }
            /* right */
//            if($isNew){
//                $item = new Item;
//                $item->type = BaseItem::TYPE_ROLE;
//                $item->name = strval($this->id);
//                $item->description = strval($this->id);
//                if (! $item->save($enableValidation))
//                    throw new Exception('save item failed.');
//
//                $right = new Assignment;
//
//                $right->user_id = intval($this->id);
//                $right->roles = [strval($this->id)];#默认新用户无任何权限
//
//                if (! $right->save($enableValidation))
//                    throw new Exception('save right failed.');
//            }
            /* 结束事务 */

//            $transaction->commit();
//            return var_dump($this);

//        } catch (Exception $e) {
//            $transaction->rollBack();
//            throw $e;
//        }
    }/*}}}*/
}
