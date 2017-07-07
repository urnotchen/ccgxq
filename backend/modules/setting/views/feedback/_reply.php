<?php

/* @var $this \yii\web\View */
/* @var $model \backend\modules\feedback\models\Feedback */
/* @var $userDetails \backend\modules\feedback\models\UserDetails */

?>
<div class="box box-success direct-chat direct-chat-success"style="height: 100%;margin: 0;">
    <div class="box-header with-border" id="feedback-box_header" fb_id="<?= $model->id?>">
        <div class="web-style">
            <img id="user-avatar" class="online feedback-img" alt="user image" src="<?= $userDetails->avatar?>">
            <h3 class="box-title">
                <span class="user-name"></span> <?= $userDetails->nickname?>的反馈
                <small class="user-status"></small>
            </h3>
        </div>
    </div>

    <div class="box-body" id="feedback-box_body">
        <div id="dialog-box">
            <?php

            foreach ($model->replies as $reply) {
                $staff = $reply->is_sender ? null :
                    \backend\modules\setting\models\Staff::getBaseInfo($reply->created_by);

                $class = $reply->is_sender ? "direct-chat-msg" : "direct-chat-msg right";
                $name = $reply->is_sender ? $userDetails->nickname : $staff->real_name;
                $avatar = $reply->is_sender ? $userDetails->avatar : $staff->avatar;

                $time = Yii::$app->dateFormat->humanChatDateTime($reply->created_at);

                $nameFloat = $reply->is_sender ? 'pull-left' : 'pull-right';
                $timeFloat = $reply->is_sender ? 'pull-right' : 'pull-left';
                echo <<<HTML
<br>
<div class="record item">
    <div class="{$class}">
        <div class="direct-chat-info clearfix">
            <span class="direct-chat-name {$nameFloat}">{$name}</span>
            <span class="direct-chat-timestamp {$timeFloat}">
                &nbsp;<i class="fa fa-clock-o"></i>&nbsp;
                {$time}
            </span>
        </div>
        <img class="direct-chat-img chat-img" alt="message user image" src="{$avatar}">
        <div class="direct-chat-text">{$reply->content}</div>
    </div>
</div><br>

HTML;
            }

            ?>
        </div>
    </div>

    <div class="box-footer" id="feedback-box_footer">
        <div class="input-group">
            <input id="feedback-input_block" type="text" name="message" placeholder="Input Message ..." class="form-control">
            <span class="input-group-btn">
                <button id="feedback-input_btn" type="button" class="btn btn-success btn-flat">发送</button>
            </span>
        </div>
    </div>
</div>

<?php

$this->registerJs(<<<JS

    $.reply();

JS
);

?>