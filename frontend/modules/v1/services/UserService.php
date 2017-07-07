<?php

namespace frontend\modules\v1\services;

use common\components\ValidateErrorCode;
use Yii;
use yii\helpers\ArrayHelper;
use yii\db\Exception as DbException;
use yii\base\Exception as YiiException;



use frontend\modules\v1\models\User;
use frontend\modules\v1\models\UserDetails;
use frontend\modules\v1\models\UserToken;

use frontend\modules\v1\models\forms\LoginForm;
use frontend\modules\v1\models\forms\RegisterForm;
use frontend\modules\v1\models\forms\UmUserAdapter;
use yii\httpclient\Exception;


class UserService extends \common\services\BizService
{
    use \frontend\traits\JsonTrait;

    CONST SEPARATOR = ',';

    /**
     * @param $rawParams
     * @return array
     * @throws DbException
     * @throws \yii\web\HttpException
     */
    public function loginViaSocial($rawParams)
    {
        $response = [];
        $adapter = (new UmUserAdapter)->parse($rawParams);

        $userExist = UserToken::getInstance([
            'platform'      => $adapter->getUserAttr('platform'),
            'open_id'       => $adapter->getUserAttr('open_id'),
        ]);

        $userToken = UserToken::getInstance([
            'platform'      => $adapter->getUserAttr('platform'),
            'open_id'       => $adapter->getUserAttr('open_id'),
        ]);

        if ($userExist->isNewRecord) {

            $user = new User;
            $userDetails = new UserDetails;
        } else {
            $userToken->user_id = $userExist->user_id;

            $user = User::findOneOrException(['id' => $userToken->user_id]);
            $userDetails = UserDetails::findOneOrException(['user_id' => $userToken->user_id]);
        }

        $transaction = Yii::$app->db->beginTransaction();

        try {
            $userToken->scenario = UserToken::SCENARIO_LOGIN_THIRD_PARTY;

            if ($userToken->isNewRecord) {
                $user->scenario = User::SCENARIO_THIRD_PARTY;
                $user->save();
            }

            $userDetails->setAttributes(ArrayHelper::merge(
                ['user_id' => $user->id],
                $adapter->getUserAllAttr()
            ));
            $userDetails->save();

            $userToken->setAttributes(ArrayHelper::merge(
                ['user_id' => $user->id],
                $adapter->getUserAllAttr()
            ));
            $userToken->save();

//            //添加用户默认项目
            if ($userExist->isNewRecord) {
                Yii::$app->user->login($user);

            }

            $transaction->commit();

//            Yii::$app->deviceCache->operateLogin($userToken);

        } catch (DbException $e) {
            $transaction->rollBack();

            throw $e;
        } catch (\yii\web\HttpException $e) {

            throw $e;
        }

        $response['userToken'] = $userToken;
        return $response;
    }

    /**
     * @param $rawParams
     * @return array
     * @throws DbException
     * @throws \yii\web\HttpException
     */
    public function registerViaBasic($rawParams)
    {
        $response = [];
        $registerForm = new RegisterForm;
        list($userAttrs, $userDetailAttrs) = $registerForm->prepare($rawParams);

        $transaction = Yii::$app->db->beginTransaction();

        try {
            $user = new User;
            $user->setAttributes($userAttrs);
            $user->save();

            $userToken = $user->generateToken(
                $registerForm->device,
                $registerForm->name,
                $registerForm->type,
                $registerForm->registrationID
            );
1;
            $userDetails = new UserDetails(['user_id' => $user->id]);
            $userDetails->setAttributes($userDetailAttrs);
            $userDetails->save();

            //添加用户默认项目
            Yii::$app->user->login($user);

            $transaction->commit();

//            Yii::$app->deviceCache->operateLogin($userToken);

            $response['userToken'] = $userToken;
            $response['userDetails'] = $userDetails;
        } catch (DbException $e) {
            $transaction->rollBack();

            throw $e;
        } catch (\yii\web\HttpException $e) {

            throw $e;
        }

        return $response;
    }

    /**
     * @param $rawParams
     * @return mixed
     * @throws YiiException
     */
    public function loginViaBasic($rawParams)
    {
        $response = [];
        $form = new LoginForm;
        $form->load($rawParams, '');

        $user = $form->save();

        $transaction = Yii::$app->db->beginTransaction();
        $userToken = null;
        try {

            # 更新用户最后登陆时间
            User::updateLastUseTime($user->id);

            $userToken = $user->updateToken($form->registrationID);

            $transaction->commit();

//            Yii::$app->deviceCache->operateLogin($userToken);

        } catch (DbException $e) {
            $transaction->rollBack();

            throw $e;
        } catch (\yii\web\HttpException $e) {

            throw $e;
        }

        $response['userToken'] = $userToken;
        return $response;
    }

    public function logout($token){


        $res = UserToken::tokenExpired($token);
        if($res){
            return True;
        }
        throw new \yii\web\HttpException(
            401,
            '更新失败',
            \common\components\ResponseCode::UNKNOWN_ERROR
        );
    }
    /**
     * @param $rawParams
     * @return array
     * @throws \Exception
     */
    public function sendRePwdCapt($rawParams)
    {
        $form = new \frontend\modules\v1\models\forms\SendRePwdCaptForm();
        $user = $form->prepare($rawParams);

        $transaction = Yii::$app->db->beginTransaction();

        try {

            $captcha = Yii::$app->captchaCache->setCaptcha($user);

            $template = "<p style='font-size: 16px'>已收到你的密码重置要求，请输入验证码：%s"
                . "<br/><br/>"
                . "该验证码10分钟内有效<br/><br/>"
                . "感谢你的支持，谢谢。<br/><br/>"
                . "（这是一封系统邮件，请勿回复）</p>";

//            Yii::$app->blueliveMailer->sendEmail(
            Yii::$app->ksmovieMailer->sendEmail(
                '找回密码验证码',
                sprintf($template, $captcha),
                [$user->email]
            );

            $transaction->commit();

            $code = hash('sha256', $captcha);

            return ['captcha' => $code];

        } catch (\Exception $e) {
            $transaction->rollBack();

            throw $e;
        }
    }

    /**
     * @param $rawParams
     * @return bool
     * @throws \Exception
     */
    public function resetPassword($rawParams)
    {
        $form = new \frontend\modules\v1\models\forms\ResetPasswordForm;
        $user = $form->prepare($rawParams);

        Yii::$app->captchaCache->checkChance($user, $form->code);

        $transaction = Yii::$app->db->beginTransaction();

        try {

            $user->changePassword($form->password);
            Yii::$app->captchaCache->delCaptcha($user);

            $transaction->commit();
            return true;
        } catch (\Exception $e) {
            $transaction->rollBack();

            throw $e;
        }
    }

    /**
     * @param $rawParams
     * @return object
     * @throws YiiException
     */
    public function saveDetails($rawParams)
    {
        $transaction = Yii::$app->db->beginTransaction();

        try {

            $userDetails = UserDetails::getInstance([
                'user_id' => $this->getUser()->id,
            ]);
            $userDetails->user_id = $this->getUser()->id;
            $userDetails->prepare($rawParams);

            $userDetails->save();
            $transaction->commit();

        } catch (YiiException $e) {
            $transaction->rollBack();

            throw $e;
        }

        return $userDetails;
    }



    /**
     * @param UserToken $userToken
     */
    protected function forceLogout(UserToken &$userToken)
    {
        //清除缓存
        Yii::$app->deviceCache->operateLogout($userToken);

        //强制用户退出
        $userToken->forceTokenExpired();
    }

}
