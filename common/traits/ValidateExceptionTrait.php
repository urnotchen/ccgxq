<?php

namespace common\traits;

/**
 * ValidateExceptionTrait class file.
 * 适用对象必须为 Model
 * @Author haoliang
 * @Date 07.07.2015 14:43
 */
trait ValidateExceptionTrait
{

    /**
     * @brief 父类同名方法返回false时此处将直接抛出HttpException
     *
     * @param null $attributeNames
     * @param bool $clearErrors
     * @return bool
     * @throws \yii\web\HttpException
     */
    public function validate($attributeNames = null, $clearErrors = true)
    {
        if ( ! parent::validate($attributeNames, $clearErrors)) {
            throw new \yii\web\HttpException(
                400,
                $this->getErrorsJson(),
                \common\components\ResponseCode::REQUEST_PARAMS_VALIDATE_FAILED
            );
        }

        return true;
    }

}
