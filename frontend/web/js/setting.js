//------------------------------------------------------APP版本页面
$.app_version_index = function(){
    $(".shortcut").on('click',function(){
        var id = $(this).attr('value');
        $("#app_version_shortcut_content").load($(this).attr('url'));
        $("#app_version_shortcut").modal();
        return false;
    });
};

$.app_version_ajax = function(){
    $(".btn-shortcut").on('click', function(){
        $("#app_version_shortcut").modal('hide');
        var action = $('#form-app-version').attr("action");
        var formDate = $('#form-app-version').serializeArray();
        $.ajax({
            url: action,
            data: formDate,
            type: 'post',
            success: function (data) {
                if(data !== '1'){
                    alert('修改失败！');
                }
                $.pjax.reload({container:"#app-version-index", timeout:5000});         
            }
        });
    });
};
