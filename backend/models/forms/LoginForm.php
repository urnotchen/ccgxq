<?php
namespace backend\models\forms;

use Yii;
use yii\base\Model;

use backend\models\User;

/**
 * Login form
 */
class LoginForm extends Model
{
    public $username;
    public $password;
    public $rememberMe = true;

    private $_user = false;


    /**
     * @inheritdoc
     */
    public function rules()
    {/*{{{*/
        return [
            // username and password are both required
            [['username', 'password'], 'required'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
        ];
    }/*}}}*/

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {/*{{{*/
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Incorrect username or password.');
            }
        }
    }/*}}}*/

    /**
     * Logs in a user using the provided username and password.
     *
     * @return boolean whether the user is logged in successfully
     */
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
