
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
    <title>在线预约</title>
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
    <div class="wx-dlmtit">
        <a href='javascript:void(0)'>在线预约</a>
    </div>
    <ul class="wx-dlmul dlmf">
        <?php
        foreach($list as $one){
            echo "<li >
     
                <img src={$one['img']} style='max-width: 25%;'> 
            <a href=\"/order/view?id={$one['id']}\" style='max-width: 65%;'>    {$one['name']}
                <span style='text-align: left;font-size: 14px;'>办理地点：{$one['position_id']}；&nbsp;&nbsp; 每小时最多办理人数：{$one['pre_hour_people']}人</span>
            </a>
                </li>";
            }
        ?>

    </ul>
    <div class="wx-dlmmore">
        <a href="javascript:void(0);" class="findmore db wap-cwx-more-btn">查看更多</a>
    </div>

</div>
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

