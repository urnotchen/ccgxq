<?php
namespace frontend\models\forms;

use frontend\models\FrontUser;
use Yii;
use yii\base\Model;


/**
 * Login form
 */
class RegisterForm extends FrontUser
{
//    public $sure_password;

    private $_user = false;


    /**
     * @inheritdoc
     */
    public function rules()
    {/*{{{*/
        return [
            [['certificates_num'], 'unique'],
            [['username',], 'unique'],

            [['username', 'password','certificates_type','certificates_num','real_name','telephone'], 'required'],

            [['status'], 'integer'],
            [['username', 'password','real_name'], 'string', 'max' => 255],
            [['certificates_type','certificates_type','certificates_num','telephone'], 'string', 'max' => 255],


            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['password', 'hashPassword'],
//            ['sure_password', 'hashPassword'],
//            ['sure_password', 'compare', 'compareAttribute' => 'password', 'operator' => '==='],

        ];
    }/*}}}*/

    public function hashPassword($attr, $options)
    {/*{{{*/
        $this->password = Yii::$app->getSecurity()->generatePasswordHash($this->$attr);
    }/*}}}*/
    public function login()
    {/*{{{*/
        if ($this->validate()) {

            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
        } else {
            return false;
        }
    }/*}}}*/

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    public function getUser()
    {/*{{{*/
        if(strstr($this->username,'u_')) {
            Yii::$app->getUser()->setReturnUrl(Yii::$app->getRequest()->get('return_url', ['/site/wanshan']));
            $user = User::findByUsername($this->username);
            if(!$user){
                return false;
            }
            if($user->created_at +  30 * 24 * 60 *60 < time() && $user->pt_active == 0)
                return false;
        }
        if ($this->_user === false) {
            $this->_user = User::findByUsername($this->username);
        }

        return $this->_user;
    }/*}}}*/

}
