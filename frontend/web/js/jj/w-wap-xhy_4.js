/*
 * @Author: jsj
 * @Date: 2019-08-15 16:50:46
 * @Last Modified by: xhy
 * @Last Modified time: 2020-01-19 16:45:32
 */
window.onload = function() {
    // 首页轮播
    var swiper = new Swiper(".index-wrap1-tab", {
        loop: true,
        pagination: {
            el: ".index-wrap1-tab .index-num",
            clickable: true
        },
        autoplay: {
            delay: 2500,
            disableOnInteraction: false,
        },
    });
    var swiper1 = new Swiper('.swiper-container', {
        navigation: {
            nextEl: '.g-swiper-button-next',
            prevEl: '.g-swiper-button-prev',
        },
    });
    $('.wx-tab').tabSwitch({
        tabHead: '.wx-tabas a',
        tabCont: '.wx-tabitems .wx-tabitem',
        cur: 'cur',
    });
    $(".wxhy-float").click(function() {
        $("html,body").animate({
                scrollTop: 0
            },
            500
        );
    });
    $(window).scroll(function() {
        var gun = $(document).scrollTop();
        if (gun <= 200) {
            $('.wxhy-float').hide();
        } else {
            $('.wxhy-float').show();
        }
    });
    //导航拉出
    $(".hidenav").height(document.body.clientHeight);
    $(".navtext").click(function(e) {
        e.stopPropagation();
        // $(".hidenav").show(0)
        $(".hidenav").animate({ width: '3rem' });
        $(document).on('click touchstart', function () {
            // var _con = $('.hidenav'); // 设置目标区域
            // if (!_con.is(event.target) && _con.has(event.target).length === 0 && $(".hidenav:animated").length == 0) {
                $(".hidenav").animate({ width: '0rem' });
                // $(".hidenav").hide(300)
            // }
        });
    })
    var fontIndex = 1;
    $(".wap-font span").click(function () {
        var fontIndexCur=$(".wap-font span").index($(this));
        $(".wap-p *").each(function () {
            //获取para的字体大小
            var thisEle = $(this).css("font-size");
            //parseFloat的第二个参数表示转化的进制，10就表示转为10进制
            var textFontSize = parseFloat(thisEle, 10);
            //javascript自带方法
            var unit = thisEle.slice(-2); //获取单位
            textFontSize += (fontIndex-fontIndexCur)*2;
            $(this).css("font-size", textFontSize + unit);
        })

        //设置
        fontIndex = fontIndexCur;
        $(".wap-font span").css('color', '#6a6a6a');
        $(this).css('color', '#3354a2');
    });
}