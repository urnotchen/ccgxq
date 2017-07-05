<?php
namespace backend\models\forms;

use Yii;
use yii\base\Model;

use backend\models\User;

/**
 * Sso form
 */
class SsoForm extends Model
{

    public $client_key;
    public $username;
    public $password;

    private $_user;

    const SCENARIO_CLIENT_KEY = 'client_key';

    public function rules()
    {/*{{{*/
        return [

            [
                ['username', 'password', 'client_key'],
                'required', 'on' => [self::SCENARIO_DEFAULT],
            ],

            [
                ['client_key'],
                'required', 'on' => [self::SCENARIO_CLIENT_KEY],
            ],

            [
                ['username', 'password', 'client_key'],
                'string', 'max' => '255',
            ],
            ['password', 'validatePassword'],

            [
                'client_key',
                'in',
                'range' => array_keys(Yii::$app->getUser()->ssoClients)
            ],

        ];
    }/*}}}*/

    public function scenarios()
    {/*{{{*/
        $inherit = parent::scenarios();
        $inherit[self::SCENARIO_CLIENT_KEY] = [
            'client_key'
        ];

        return $inherit;
    }/*}}}*/

    public function validatePassword($attribute, $params)
    {/*{{{*/
        if ($this->hasErrors()) return;

        $user = $this->getUser();

        if (!$user) {
            $this->addError($attribute, 'Incorrect username.');
            return;
        }

        if (!$user->validatePassword($this->password)) {
            $this->addError($attribute, 'Incorrect password.');
            return;
        }
    }/*}}}*/

    public function prepare($rawParams, $runValidation = true)
    {/*{{{*/
        if (! $this->load( $rawParams))
            return false;

        if ($runValidation && ! $this->validate() )
            return false;

        return true;
    }/*}}}*/

    public function getUser()
    {/*{{{*/
        if ($this->_user === null) {
            $this->_user = User::findByUsername($this->username);
        }

        return $this->_user;
    }/*}}}*/

}
