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