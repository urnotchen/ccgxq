<?php

namespace common\components;

/**
 * ResponseCode class file.
 * @Author haoliang
 * @Date 16.12.2015 19:43
 */
class ResponseCode
{

    const EVERYTHING_OK                              = 0;

    # 验证请求参数数据失败
    const REQUEST_PARAMS_VALIDATE_FAILED             = 40000;


    # 无效 access_token
    const INVALID_ACCESS_TOKEN                       = 40005;

    # 无效资源id
    const INVALID_RESOURCE_ID                        = 40006;

    # 资源不存在
    const NOT_FOUND                                  = 40007;

    # access_token 已过期
    const ACCESS_TOKEN_EXPIRED                       = 40008;

    # 给定数据无效, 未通过验证
    const INVALID_DATA_FORMAT                        = 40009;

    # user login failed
    const USER_LOGIN_FAILED                          = 40012;

    # 对象未找到
    const ENTITY_NOT_FOUND                           = 40015;

    # 邮箱尚未注册
    const USER_EMAIL_NOT_EXISTS                      = 40016;

    # 用户captcha 尚未过期
    const USER_CAPTCHA_NOT_EXPIRED                   = 40018;
    # 验证码错误
    const USER_CAPTCHA_NOT_MATCH                     = 40019;
    # 验证码尝试次数耗尽
    const USER_CAPTCHA_TRIED_OUT                     = 40020;
    # 验证码过期
    const USER_CAPTCHA_IS_EXPIRED                    = 40021;
    # 验证码未生成
    const USER_CAPTCHA_NOT_GENERATED                 = 40022;
    # 未指定验证码用户
    const USER_CAPTCHA_USER_NOT_GIVEN                = 40023;

    # 数据持久化错误
    const PERSIST_DATA_ERROR                         = 40027;

    # 未知错误
    const UNKNOWN_ERROR                              = 40028;

    # 请求数据不属于用户
    const SYNC_RESOURCE_NOT_BELONGS_TO_USER          = 40029;

    # 同步冲突
    const SYNC_CONFLICT                              = 40031;

    # 不支持的反馈类型
    const FEEDBACK_UNSUPPORTED_TYPE                  = 40032;

    # 用户需要登录
    const USER_NEED_LOGIN                            = 40033;

    # 不支持的操作
    const UNION_PACKAGE_UNSUPPORTED_ACTION           = 40035;

    # 不支持的第三方登录
    const SOCIAL_LOGIN_UNSUPPORTED_THIRD_PARTY       = 40038;

    # 重置密码不能与原密码相同
    const USER_PASSWORD_NOT_CHANGE                   = 40040;

    # 项目数超过上线
    const PROJECT_OVER_MAX                           = 40041;
    # 场数超过上线
    const SCENE_OVER_MAX                             = 40042;
    # 镜数超过上线
    const CUT_OVER_MAX                               = 40043;

    # 过期VIP只允许编辑前两个项目
    const EXPIRED_VIP_EDIT_TWO                       = 40045;

    # 收据与订单不符
    const RECEIPT_NOT_MATCH_PURCHASE                 = 40046;

    # 产品不存在
    const PRODUCT_NOT_EXIST                          = 40047;

    # 无效设备码
    const INVALID_DEVICE                             = 40049;

    # 手机超过上限
    const PHONE_OVER_MAX                             = 40051;
    # 平板超过上限
    const PAD_OVER_MAX                               = 40052;

    # 项目已创建
    const PROJECT_CREATED                            = 40055;
    # 场已创建
    const SCENE_CREATED                              = 40056;
    # 镜已创建
    const CUT_CREATED                                = 40057;
    # 镜图片已创建
    const IMAGE_CREATED                              = 40058;

    # 标准用户才能购买升级包
    const ONLY_VIP_UPGRADE_SVIP                      = 40061;
    # 高级用户不能购买标准用户
    const SVIP_NOT_BUG_VIP                           = 40062;
    # 标准用户不能购买高级用户
    const VIP_NOT_BUG_SVIP                           = 40063;

    # 下载次数超过限制
    const DOWNLOAD_TIMES_OVER_MAX                    = 40067;
}
