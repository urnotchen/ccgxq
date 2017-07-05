$.feedback = function () {
    $(".btn-reply").on("click", function(){
        var id = this.getAttribute('fb_id');

        $("#modal-content_reply").load("reply?id=" +id);
        $("#modal-reply").modal({
            backdrop: 'static'
        });
        return false;
    });

    $(".btn-read").on("click", function(){
        var id = this.getAttribute('fb_id');

        $.ajax({
            url: "read",
            type: 'get',
            data: {
                id: id
            },
            success: function(data){
                console.log(data);
                $.pjax.reload({container: "#feedback-index",timeout: 5000});
            }
        });
    });

    $("#modal-reply").on("hidden.bs.modal", function() {
        $.pjax.reload({container:"#feedback-index",timeout: 5000});
    });
};

$.reply = function () {

    $('#feedback-input_btn').on("click", function () {
        var input = $("#feedback-input_block");
        var content = input.val();

        if (content == '') {

            return false;
        }

        $.ajax({
            url: 'send',
            type: 'post',
            data: {
                content: content,
                fb_id: $('#feedback-box_header').attr('fb_id')
            },
            success: function(data){
                data = JSON.parse(data);

                var dialog = $("#dialog-box");
                dialog.append(
                    createRecord(data.name, data.avatar, data.content, data.time)
                );

                var dialogBox = $('#feedback-box_body');
                dialogBox.scrollTop(dialogBox.prop("scrollHeight"));

                input.val("");
                input.focus();
            }
        });
    });

    /**
     * 回车事件绑定
     */
    $('#feedback-input_block').bind('keyup', function(event) {
        if (event.keyCode == "13") {
            //回车执行
            $('#feedback-input_btn').click();
        }
    });

    /**
     * 生成对话记录
     *
     * @param name
     * @param avatar
     * @param content
     * @param time
     */
    function createRecord(name, avatar, content, time)
    {
        content = htmlencode(content);

        var record =
                '<div class="record item">' +
                '<div class="direct-chat-msg right">' +
                '<div class="direct-chat-info clearfix">' +
                '<span class="direct-chat-name pull-right">' + name + '</span>' +
                '<span class="direct-chat-timestamp pull-left">' +
                '&nbsp;<i class="fa fa-clock-o"></i>&nbsp;' +
                time +
                '</span>' +
                '</div>' +
                '<img class="direct-chat-img chat-img" alt="message user image" src="' + avatar + '">' +
                '<div class="direct-chat-text">' +
                content +
                '</div>' +
                '</div>' +
                '</div><br>'
            ;

        return record;
    }

    /**
     * html转码
     * @param s
     * @returns {*}
     */
    function htmlencode(s){
        var div = document.createElement('div');
        div.appendChild(document.createTextNode(s));
        return div.innerHTML;
    }
    function htmldecode(s){
        var div = document.createElement('div');
        div.innerHTML = s;
        return div.innerText || div.textContent;
    }
};