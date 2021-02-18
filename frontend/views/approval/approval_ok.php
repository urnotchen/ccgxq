<?php



?>

<br/>
<br/>
<div class="alert alert-success alert-dismissible">

    <h4><i class="icon fa fa-check"></i> 提交成功</h4>
    系统将在 <span id="time">3</span> 秒钟后自动跳转至首页，如果未能跳转，<a href="/site/index" title="点击访问">请点击</a>。</p>
</div>

<script type="text/javascript">
    delayURL();
    function delayURL() {
        var delay = document.getElementById("time").innerHTML;
        var t = setTimeout("delayURL()", 1000);
        if (delay > 0) {
            delay--;
            document.getElementById("time").innerHTML = delay;
        } else {
            clearTimeout(t);
            window.location.href = "/site/index";
        }
    }
</script>