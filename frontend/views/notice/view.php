
<link rel="stylesheet" type="text/css" href="/css/jj/w-swiper_4.min.css">
<link rel="stylesheet" type="text/css" href="/css/jj/w-common_4.css">
<link rel="stylesheet" type="text/css" href="/css/jj/w-main_2.css">
<link rel="stylesheet" type="text/css" href="/css/jj/mdialog.css">

<script src="/js/jj/w-jquery_4.min.js"></script>
<script src="/js/jj/w-common_4.js"></script>
<script src="/js/jj/w-swiper_4.min.js"></script>
<script src="/js/jj/w-wap-xhy_4.js"></script>
<!DOCTYPE html>

?>

<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>公告通知</title>
    <!--站点类-->
    <meta name="SiteName" content="齐齐哈尔">
    <meta name="SiteDomain" content="gxq.cq.gov.cn">
    <meta name="SiteIDCode" content="5001070012">

    <!--栏目类-->
    <meta name="ColumnName" content="公告通知">

    <meta name="ColumnDescription" content="公告通知">



    <meta name="ColumnKeywords" content="公告通知">



    <meta name="ColumnType" content="公告通知">



</head>

<body style='background: url("/files/images/bg1.jpg") no-repeat top center'>
<!--头部-->
<!--SSI头部开始-->

<!--头部-->
<div class="wx-header">
    <div class="clearfix wx-h1">

        <a href="#" class="wx-logo db lf">
            <img src="/files/images/logo1.png" />
        </a>

    </div>
    <div class="wx-sear">
        <input id="serarch1" type="text" onkeydown="if(event.keyCode==13){submitsearch1();}"  placeholder="请输入搜索内容" />
        <button id="toSearcha2" onclick="submitsearch1();"></button>
    </div>
</div>
<script>function submitsearch1() {

        var val = $('#serarch1').val();
        val = $.trim(val);
        var reg = /[`~!@#$%^&*_+<>{}\/'[\]]/im;
        if (reg.test(val)) {
            alert('您输入的信息包含非法字符!');
            return false;
        }
        if (val == "请输入搜索内容" || val == "" || val == null) {
            alert('请输入检索条件!');
            return false;
        } else {
            val = val.replace("-", "\-");
            val = val.replace("(", "\(");
            val = val.replace(")", "\)");
        }
        window.location.href = 'index?keyword=' + val;
    }
</script>
<!--SSI头部结束-->
<!--内容-->
<div class="wx-dlm jofry">
    <div class="wx-c2c wx-c2c1">

        <script>
            $('#abc').find('a').each(function(){
                var url = $(this).attr('href')+'wap.html';
                $(this).attr('href',url)
            })
        </script>
    </div>
<style>.wap-detail-info {
        padding: 0 0.3rem;
        box-sizing: border-box;
        width: 100%;
        text-align: center;
    }
    .wap-detail-info .tit {
        font-size: 0.4rem;
        color: rgb(51, 51, 51);
        line-height: 0.6rem;
        font-weight: bold;
        margin-top: 0.39rem;
    }
    .mt30 {
        margin-top: 0.3rem;
    }
    .wap-date, .wap-font {
        text-align: center;
    }
    .wap-date span, .wap-font span {
        font-size: 0.28rem;
        color: rgb(51, 51, 51);
        line-height: 0.66rem;
    }
    .wap-p {
        margin-top: 0.24rem;
        font-size: 0.32rem;
        color: rgb(51, 51, 51);
        line-height: 0.6rem;
        text-align: left;
        text-indent: 0.5rem;
    }
    .wap-font {
        border-bottom: 0.01rem solid rgb(234, 234, 234);
        padding-bottom: 0.2rem;
    }
    .ml30 {
        margin-left: 0.3rem;
    }
</style>
    <div class="wap-detail-info">

        <p class="tit">
            <a href="javascript:void(0);">
                <?php echo $model['title'];?>
            </a>
        </p>
        <div class="wap-date mt30">
            <span>日期：</span>
            <span><?php echo date("Y-m-d",$model['created_at']);?></span>
            <span class="ml30">来源：</span><span><?php echo $model['from'] ?></span>
        </div>
        <div class="wap-font">

        </div>
        <div class="wap-p">

            <div style="width: 0px; height: 0px; margin: 20px auto; display: none; background-color: rgb(0, 0, 0); cursor: pointer; font-size: 20px;font-size:20px !important;" id="a1"><video controls="controls" src="" id="ckplayer_a1" width="100%" height="100%" autoplay="autoplay" style="font-size: 20px;font-size:20px !important;"></video>
            </div>

            <div class="view TRS_UEDITOR trs_paper_default trs_word" style="font-size: 20px;font-size:20px !important;">
                <?php echo $model['content'];?>
            </div>


            <script type="text/javascript" style="font-size: 20px;font-size:20px !important;">
                var hasFJ='';
                if(hasFJ!=''){
                    var FJarr=hasFJ.split("<BR/>")
                    document.write('<div style="border-top:#dcdcdc 1px solid;border-bottom: #dcdcdc 1px solid;margin-top:30px;margin-bottom: 30px;padding-top: 10px;"><p style="color:red;font-weight:600;font-size: 16px;line-height: 2;margin: 0px;padding: 0px;">附件下载：</p><p style="font-size: 16px;line-height: 2;margin: 0px;padding: 0px;">');

                    for(var i=1;i<=FJarr.length;i++){
                        document.write(i+"."+FJarr[i-1]+"<br/>");
                    }
                    document.write('</p></div>');
                }
            </script>

        </div>
    </div>


</div>
<!--尾部-->
<!--SSI底部开始-->
<style>
    .mb2-footer a {
        max-width: 7.5rem;
        text-align: center;
        font-size: 0.22rem;
        color: #666666;
        margin-bottom: 0.24rem;
    }
</style>
<!--尾部-->
<?= $this->render('/layouts/bottom') ?>

<!--返回顶部-->
<div class="wxhy-float">
    返回顶部
</div>
<!--SSI底部结束-->

<script>
    for (var j = 0; j < 20; j++) {
        $(".dlmf li:eq("+j+")").css("display","block");
        $(".dlmf li:eq("+j+")").css("opacity",0);
        $(".dlmf li:eq("+j+")").animate({opacity:1},500)
    }
    if($(".jofry ul li").length<20){
        $(".jofry .wap-cwx-more-btn").css("display","none");}
    var lsin = 2;
    var lslen =  Math.ceil($(".dlmf li").length/10);
    $(".jofry .wap-cwx-more-btn").click(function(){
        if(lsin<lslen-1){
            var lin = lsin*10;
            for (var i = 0; i<10; i++) {
                $(".dlmf li").eq(lin+i).css("display","block");
                $(".dlmf li").eq(lin+i).css("opacity",0);
                $(".dlmf li").eq(lin+i).stop().animate({opacity:1},500)
            }
            lsin++;
        } else {
            var lin = lsin*10;
            for (var i = 0; i<10; i++) {
                $(".dlmf li").eq(lin+i).css("display","block");
                $(".dlmf li").eq(lin+i).css("opacity",0);
                $(".dlmf li").eq(lin+i).stop().animate({opacity:1},500)
            }
            $(".jofry .wap-cwx-more-btn").css("display","none");
        }
    })

</script>

</body>
</html>

