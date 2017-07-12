<?php

use common\helpers\Math;

use backend\modules\stat\models\User;
use backend\modules\stat\models\UserToken;
use backend\modules\stat\models\StatDaily;
use backend\modules\stat\models\StatWeekly;
use backend\modules\stat\models\StatMonthly;
use backend\modules\stat\models\StatUserAction;
/* @var $this yii\web\View */

$this->title = '用户评论统计';

$userTotal = User::getUserTotal();
$statDaily = StatDaily::getStatDaily();
$statWeekly = StatWeekly::getStatWeekly();
$statMonth = StatMonthly::getStatMonthly();

$userIncrement = User::getIncrementYesterday();

$today = Yii::$app->dateFormat->getTodayTimestamp();
list($rangeDate, $rangeData) = StatUserAction::getRangeStatComment(StatDaily::DAY*14, $today);


$userPlatform = UserToken::enum('platform');
$userPlatformCount = UserToken::getUserPlatformCount();

?>


<div class="row">
    <div class="col-lg-8 col-md-8 col-xs-12">
        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title">用户评论统计</h3>
                <input type="text" name="datefilter" class="form-control" style="width: 25%;float: right"/>
            </div>

            <div class="box-body" style="display: block;">
                <canvas id="myLineChart"></canvas>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-4 col-xs-12">

    </div>
</div>

<?php

\backend\assets\AppAsset::addPageCss($this, '/css/stat.css');
\backend\assets\AppAsset::addPageCss($this, '/css/daterangepicker.css');
\backend\assets\AppAsset::addPageScript($this, '/js/Chart.js');
\backend\assets\AppAsset::addPageScript($this, '/js/moment.min.js');
\backend\assets\AppAsset::addPageScript($this, '/js/daterangepicker.js');
\backend\assets\AppAsset::addPageScript($this, '/js/stat.js');

$platform = \yii\helpers\Json::encode(array_values($userPlatform));
$platformCount = \yii\helpers\Json::encode(array_values($userPlatformCount));
$lineDate =  \yii\helpers\Json::encode($rangeDate);
$lineData =  \yii\helpers\Json::encode($rangeData);

$this->registerJs(<<<JS

$.lineChart({$lineDate}, {$lineData});
$.donutChart({$platform}, {$platformCount});

JS
);

?>