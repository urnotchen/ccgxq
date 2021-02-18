/**
 * Created by chenxi on 2017/5/3.
 */

// ajax to  FilmProperty Controller for add property
function setProperty(){
    var property_id = $(this).attr('property_id');
    var movie_id = $(this).attr('value');
    var motion = $(this).attr('motion');
    $(this).attr('id','tempId');
    $.ajax({
        url:'/movie/film-property/set-property',
        data:{movie_id:movie_id,property_id:property_id,motion:motion},
        type:'post',
        success:function(data){
            $.pjax.reload({container:"#movie_index",timeout:5000});
            alert(data);
        },
        error:function(data){
            alert('保存失败');
        }
    });
}

function setSequence(){
    var motion = $(this).attr('motion');
    var property_id = $(this).attr('property_id');
    $(this).attr('id','tempId');
    $.ajax({
        url:'/movie/film-property/set-sequence',
        data:{motion:motion,property_id:property_id},
        type:'post',
        success:function(data){

            $.pjax.reload({container:"#movie_index",timeout:5000});

        },
        error:function(data){
            alert('移动失败');
        }
    });
}

/*
 * 首页快速调整位置
 * */
$(".quick_change_sequence").on("click",quickChangeSequence);
function quickChangeSequence(){

    var propertyId = $(this).attr('property_id');
    $("#modal_content_quick_change_sequence").load("/movie/film-property/quick-change-sequence?propertyId=" + propertyId);
    $("#modal_quick_change_sequence").modal();
    return false;
}

$("#submit_quick_change_sequence").on("click",submitQuickChangeSequence);
function submitQuickChangeSequence(){
    var sequence = $("#quick_change_sequence_val").val();
    var propertyId = $("#quick_change_sequence_val").attr('property_id');
    $.post({
        data:{sequence:sequence},
        url:"/movie/film-property/quick-change-sequence?propertyId=" + propertyId,
        success:function(){
            window.location.reload();
        }
    });
}