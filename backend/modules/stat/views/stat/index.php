<?php

use common\helpers\Math;

use backend\modules\stat\models\User;
use backend\modules\stat\models\UserToken;
use backend\modules\stat\models\StatDaily;
use backend\modules\stat\models\StatWeekly;
use backend\modules\stat\models\StatMonthly;

/* @var $this yii\web\View */

$this->title = '用户统计';

$userTotal = User::getUserTotal();
$statDaily = StatDaily::getStatDaily();
$statWeekly = StatWeekly::getStatWeekly();
$statMonth = StatMonthly::getStatMonthly();

$userIncrement = User::getIncrementYesterday();

$today = Yii::$app->dateFormat->getTodayTimestamp();
list($rangeDate, $rangeData) = StatDaily::getRangeStatDaily(StatDaily::DAY*14, $today);


$userPlatform = UserToken::enum('platform');
$userPlatformCount = UserToken::getUserPlatformCount();

?>

<div class="row">
    <div class="col-lg-4 col-md-4 col-xs-12">
        <div class="col-lg-12 col-md-12 col-xs-12 bg-yellow customized_min_height info-box">
            <div class="col-md-10 col-sm-10 margin">
                <div class="active-user-count-label-num">
                    <small><small><small><span class="glyphicon glyphicon-question-sign pointer" title="7日内平均活跃用户数(不包含注册当日)"></span></small></small></small>
                    日 ： <strong class="font_30"><?=$statDaily?></strong>
                    <small><small><?= Math::division($statDaily * 100, $userTotal)?>%</small></small>
                </div>
                <div class="active-user-count-label-num">
                    <small><small><small><span class="glyphicon glyphicon-question-sign pointer" title="上周活跃超过2天(含)的用户数"></span></small></small></small>
                    周 ： <strong class="font_30"><?=$statWeekly?></strong>
                    <small><small><?= Math::division($statWeekly * 100, $userTotal)?>%</small></small>
                </div>
                <div class="active-user-count-label-num">
                    <small><small><small><span class="glyphicon glyphicon-question-sign pointer" title="一个月内活跃超过4天(含)的用户数，必须有2天是7天以后的才行"></span></small></small></small>
                    月 ： <strong class="font_30"><?=$statMonth?></strong>
                    <small><small><?= Math::division($statMonth * 100, $userTotal)?>%</small></small>
                </div>
                <div class="user-count-tab-text">活跃用户</div>
            </div>
            <div class="icon col-md-4 col-sm-4 pull-right">
                <i class="ion ion-pie-graph pull-right"></i>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-4 col-xs-12">
        <div class="col-lg-12 col-md-12 col-xs-12 bg-red info-box" style="min-height:180px;">
            <div class="col-md-10 col-sm-10">
                <div class="user-count-label-num margin font_60">
                    <?=$userTotal?>
                </div>
                <div class="user-count-tab-text margin ">所有注册用户</div>
            </div>
            <div class="icon col-md-4 col-sm-4 pull-right">
                <i class="ion ion-stats-bars pull-right"></i>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-4 col-xs-12">
        <div class="col-lg-12 col-md-12 col-xs-12 bg-blue info-box" style="min-height:180px;">
            <div class="col-md-10 col-sm-10">
                <div class="user-count-label-num margin "><small><small><span class="font_60"><?= $userIncrement?></span></small></small></div>
                <div class="user-count-tab-text margin">昨日新增用户</div>
            </div>
            <div class="icon col-md-4 col-sm-4 pull-right">
                <i class="ion ion-person-add pull-right"></i>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-8 col-md-8 col-xs-12">
        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title">活跃用户统计</h3>
                <input type="text" name="datefilter" class="form-control" style="width: 25%;float: right"/>
            </div>

            <div class="box-body" style="display: block;">
                <canvas id="myLineChart"></canvas>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-4 col-xs-12">
        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title">用户注册渠道</h3>
                <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse" type="button">
                        <i class="fa fa-minus"></i>
                    </button>
                </div>
            </div>

            <div class="box-body" style="display: block;">
                <div class="row">
                    <div class="col-md-12">
                        <canvas id="myDonutChart" width="600px" height="400px"></canvas>
                    </div>
                </div>
            </div>

            <div class="box-footer no-padding" style="display: block;">
                <ul class="nav nav-pills nav-stacked">
                    <?php
                    foreach($userPlatform as $key => $value){
                        echo "<li><a>{$value}<span class='pull-right text-yellow'>" . Math::division($userPlatformCount[$key] * 100, $userTotal) . "%</span></a></li>";
                    }
                    ?>
                </ul>
            </div>
        </div>
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