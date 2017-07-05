<?php

use backend\modules\setting\models\UserDetails;

/* @var $model \backend\modules\feedback\models\Feedback */

$userDetails = UserDetails::findOneOrException(['user_id' => $model->created_by]);

$name = $userDetails->nickname;

$src = $userDetails->getAvatar();

?>

<div style="color: #979797; margin-left: 6px; margin-right: 6px; margin-top: 15px; text-align: center;">
    <div class="user-avatar" style="position: absolute;z-index: 10;width: 77px;">
        <img class="user-avatar" src="http://weixin.sogou.com/pcindex/images/main/bg_mark.png">
    </div>
    <div class="user-avatar" style="position: absolute;z-index: 1;width: 77px;">
        <img class="user-avatar" src="<?= $src?>">
    </div><br style="Line-height: 57px">
    <div style="word-wrap: break-word;word-break: break-all;white-space: pre-wrap;"><?= $name?></div>
</div>
