<link rel="stylesheet" type="text/css" href="/css/jj/index.css">
<link rel="stylesheet" type="text/css" href="/css/jj/common.css">
<link rel="stylesheet" type="text/css" href="/css/jj/mui.min.css">
<link rel="stylesheet" type="text/css" href="/css/jj/iconfont.css">



<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
    <title>政务服务中心</title>
    <link href="assetsindex/fonts/iconfont/iconfont.css" rel="stylesheet" />
    <link href="assetsindex/css/mui.min.css" rel="stylesheet" />
    <link href="assetsindex/css/common.css" rel="stylesheet" />
    <link href="assetsindex/css/pages/chongqing-gaoxin-index.css" rel="stylesheet" />
    <style>
        a{
            color: #333;
        }
        .info-row{
            font-size:10px;
            text-align: center;
            color: rgba(105, 105, 105,1);
            background-color:rgba(255, 255, 255,1);
        }
    </style>
</head>
<body>

<div class="main mui-content" >
    <div style="background: url('http://221.209.110.28:4000/images/logo.png')">
        <img src="/files/images/logo.png" style="width: 100%">
    </div>
    <div class="index-banner"></div>
    <div class="topic-enter enter-notice"style="margin-top: 5px">
            <a href="/notice/index?cate_id=1">
                <div class="topic-enter-title">通知公告</div>
                <div class="topic-enter-btn">查看更多</div>
            </a>
        </div>  
    <div class="index-enter" style="    margin-top: 5px">
        
      
        <?php foreach ($notices as $one){
            echo "<a href='/notice/view?id={$one["id"]}'><p style=\"color: black;overflow:hidden\">$one[title]<span style='float: right'>$one[created_at]&nbsp;</span></p></a>";
        }?>
    </div>
    <div class="index-enter" style="    margin-top: 8px;">
        <div class="mui-row">
            <div class="mui-col-xs-3">
                <a href=<?php echo "/notice/index?cate_id=".\frontend\models\Notice::CATE_JMZZ;?>>
                    <div class="enter-icon icon-red">
                        <i class="iconfont icon-zhuce"></i>
                    </div>
                    <div class="enter-name">精密制造</div>
                </a>
            </div>

            <div class="mui-col-xs-3">
                <a href="/project-category/company-index">
                    <div class="enter-icon icon-blue">
                        <i class="iconfont icon-bijiben"></i>
                    </div>
                    <div class="enter-name">法人办事</div>
                </a>
            </div>
            <div class="mui-col-xs-3">
                <a href=<?php echo "/notice/index?cate_id=".\frontend\models\Notice::CATE_BSZN;?>>
                    <div class="enter-icon icon-yellow">
                        <i class="iconfont icon-detailed-list"></i>
                    </div>
                    <div class="enter-name">办事指南</div>
                </a>
            </div>
            <div class="mui-col-xs-3">
                <a href="/order/index">
                    <div class="enter-icon icon-green">
                        <i class="iconfont icon-yuyue"></i>
                    </div>
                    <div class="enter-name">在线预约</div>
                </a>
            </div>

            <div class="mui-col-xs-3">
                <a href="/selection/create">
                    <div class="enter-icon icon-blue">
                        <i class="iconfont icon-like"></i>
                    </div>
                    <div class="enter-name">我要评价</div>
                </a>
            </div>
            <div class="mui-col-xs-3">
                <a href="/space/approval">
                    <div class="enter-icon icon-green">
                        <i class="iconfont icon-multiple"></i>
                    </div>
                    <div class="enter-name">进度查询</div>
                </a>
            </div>
            <div class="mui-col-xs-3">
                <a href="/space/message">
                    <div class="enter-icon icon-red">
                        <i class="iconfont icon-search3"></i>
                    </div>
                    <div class="enter-name">咨询查询</div>
                </a>
            </div>
            <div class="mui-col-xs-3">
                <a href="/space/order">
                    <div class="enter-icon icon-yellow">
                        <i class="iconfont icon-yuyuequhao"></i>
                    </div>
                    <div class="enter-name">预约查询</div>
                </a>
            </div>
        </div>
    </div>
    <div class="index-topic">
        <div class="mui-row">
            <div class="mui-col-xs-6">
                <div class="topic topic-query">
                    <a href=<?php echo "/notice/index?cate_id=".\frontend\models\Notice::CATE_QYTJ;?>>
                        <div class="topic-title">高新区企业<i>推介</i></div>
                        <div class="topic-info"></div>
                    </a>
                </div>
            </div>
            <div class="mui-col-xs-6">
                <a href="/message/create">
                    <div class="topic topic-feedback">
                        <div class="topic-title">办事<i>咨询</i></div>
                    </div>
                </a>
            </div>
        </div>

        <div class="topic-enter enter-policy">
            <a href=<?php echo "/notice/index?cate_id=".\frontend\models\Notice::CATE_POLICY;?>>
                <div class="topic-enter-title">政策解读</div>
                <div class="topic-enter-btn">查看更多</div>
            </a>
        </div>
        <br/>
        <?= $this->render('/layouts/bottom') ?>
    </div>
</div>
<script src="assetsindex/js/mui.min.js"></script>
<script type="text/javascript">
    mui.init();
    var gallery = mui('.mui-slider');
    gallery.slider({
        interval: 5000 //自动轮播周期，若为0则不自动播放，默认为0；
    });
    mui('body').on('tap', 'a', function() {
        if(this.getAttribute('href') != null){
            location.href = this.getAttribute('href');
        }
        if(this.dataset.target == 'ykb'){
            goYkb();
        }
    });

    function goYkb(){
        if(localStorage['USER_ID']==undefined){
            window.location.href = '/WeChat/login/login.html';
        }
        else{
            var userid = localStorage['USER_ID'];
            var usertype = localStorage['USER_TYPE']=="1" ? "0" : "1";
            location.href="http://tysb.cqgxqzwzx.com:17070/appWB/#/home/500356/"+userid+"/"+usertype+"/web";
        }

    }
</script>
</body>
</html>
