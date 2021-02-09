<script src="https://cdn.bootcss.com/jquery/3.3.1/jquery.js"></script>
<link href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">
<script src="https://cdn.bootcss.com/datatables/1.10.16/js/jquery.dataTables.js"></script>

<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<div class="approval-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'project_id')->widget(
        \kartik\select2\Select2::className(),
        [
            'data' => $project_kv,
            'language' => 'zh-CN',
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]
    ) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sequence')->textInput() ?>

    <?= $form->field($model, 'agency')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'basic_sxlx')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'basic_bjlx')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'basic_sszt')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'basic_xscj')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'basic_cnbjsx')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'basic_fdbjsx')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'basic_is_charge')->textInput() ?>

    <?= $form->field($model, 'basic_dbsxccs')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'basic_zxfs')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'basic_jdtsfs')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'basic_blsj')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'basic_bldd')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'process')->hiddenInput() ?>

    <?= $form->field($model, 'process_tmp')->fileInput(['onchange' => "var formData = new FormData();formData.append('file', $(this)[0].files[0]);$.ajax({contentType: false, cache: false,processData: false, url: '/project/approval/upload-image',type: 'POST',data: formData,success: function(data) {\$('#approval-process').val(data);}});"])->label(false) ?>

    <?= $form->field($model, 'blclml')->textarea(['rows' => 6])->hiddenInput();?>

    <div class="portlet light portlet-fit ">

        <div class="portlet-body">
            <div class="table-toolbar">
                <div class="row">
                    <div class="col-md-6">
                        <div class="btn-group">
                            <button id="detail_editable_1_new" class="btn green">
                                新增记录
                                <i class="fa fa-plus"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <table class="table table-striped table-hover table-bordered" id="detail_editable_1">
                <thead>
                <tr>
                    <th>序号</th>
                    <th> 材料名称</th>
                    <th> 材料填写样本 </th>
                    <th> 来源渠道</th>
                    <th> 纸质材料</th>
                    <th> 材料必要性 </th>
                    <th> 编辑 </th>
                    <th> 删除 </th>
                    <th>  </th>
                </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>


    <?= $form->field($model, 'sltj')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'sfbz')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sdyj')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'question')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'is_online')->radioList(\backend\modules\project\models\Approval::enum('is_online')) ?>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?= Html::Button($model->isNewRecord ? 'cs' : 'cs', ['class' => $model->isNewRecord ? 'btn btn-success1' : 'btn btn-primary']) ?>
        <span class="cs">cs</span>
    </div>

    <?php ActiveForm::end(); ?>

</div>





<script>
    //$(document).ready(function() {
    //    $('#detail_editable_1').DataTable( {
    //        data: <?php //echo $blclml?>
    //
    //    } );
    //} );
    //定义dataTable对象
    var table = $('#detail_editable_1');
    var blclml = $('#approval-blclml').val();

    var oTable = table.dataTable({
        "lengthMenu": [
            [5, 15, 20, -1],
            [5, 15, 20, "All"] // 改变每页的行数
        ],
        <?php
        if($blclml){
            echo "data:{$blclml},";
        }else{
            echo "data:[],";
        }
        ?>

        // data:[[1,2,3,4,5,6,7,8]],
        // 使用汉化
        // "language": {
        //     url: '//cdn.datatables.net/plug-ins/3cfcc339e89/i18n/Chinese.json'
        // },
        "paging": false,
        "info":     false,
        //初始化
        "pageLength": 100,
        "columnDefs": [{ // 设置默认列设置
            'orderable': true,
            'targets': [0],
            "searchable": false,
        }],
        "order": [
            [0, "asc"]
        ] // 将第一列设置为asc的默认排序

    });






    //编辑行
    function editRow(oTable, nRow) {
        var aData = oTable.fnGetData(nRow);
        var jqTds = $('>td', nRow);
        jqTds[0].innerHTML = '<input type="text" class="form-control input-small" value="' + aData[0] + '">';
        jqTds[1].innerHTML = '<input type="text" class="form-control input-small" value="' + aData[1] + '">';
        jqTds[2].innerHTML = '<input onchange="var formData = new FormData();formData.append(\'file\', $(this)[0].files[0]);$.ajax({contentType: false, cache: false,processData: false, url: \'/project/approval/upload-image\',type: \'POST\',data: formData,success: function(data) {console.log(data);console.log($(this).parent().parent().find(\'.upp\').val(data))}.bind(this),error: function() {alert(\'上传失败\');} });"' +
            '  type="file" class="form-control input-small upfile"  value="' + aData[2] + '">';
        jqTds[3].innerHTML = '<input type="text" class="form-control input-small" value="' + aData[3] + '">';
        jqTds[4].innerHTML = '<input type="text" class="form-control input-small" value="' + aData[4] + '">';
        jqTds[5].innerHTML = '<input type="text" class="form-control input-small" value="' + aData[5] + '">';

        jqTds[6].innerHTML = '<a class="edit" href="">保存</a>';
        jqTds[7].innerHTML = '<a class="cancel" href="">取消</a>';
        jqTds[8].innerHTML = '<input type="hidden"  class="upp form-control input-small" value="' + aData[8] + '">';
    }
    //取消行
    function restoreRow(oTable, nRow) {

        var jqInputs = $('input', nRow);
        oTable.fnUpdate(jqInputs[0].value, nRow, 0, false);
        oTable.fnUpdate(jqInputs[1].value, nRow, 1, false);
        oTable.fnUpdate(jqInputs[2].value, nRow, 2, false);
        oTable.fnUpdate(jqInputs[3].value, nRow, 3, false);
        oTable.fnUpdate(jqInputs[4].value, nRow, 4, false);
        oTable.fnUpdate(jqInputs[5].value, nRow, 5, false);
        oTable.fnUpdate('<a class="edit" href="">编辑</a>', nRow, 6, false);
        oTable.fnUpdate('<a class="delete" href="">删除</a>', nRow,7, false);
        oTable.fnUpdate(jqInputs[8].value, nRow, 8, false);
        oTable.fnDraw();
    }

    nNew = false;
    nEditing = null;
    //费用类型 发生时间 费用金额 费用说明
    var objList = [];
    //保存行数据，切换到普通模式
    function saveRow(oTable, nRow) {
        var jqInputs = $('input', nRow);
        console.log(jqInputs);
        //更新行中每个input的值
        oTable.fnUpdate(jqInputs[0].value, nRow, 0, false);
        oTable.fnUpdate(jqInputs[1].value, nRow, 1, false);
        oTable.fnUpdate(jqInputs[2].value, nRow, 2, false);
        oTable.fnUpdate(jqInputs[3].value, nRow, 3, false);
        oTable.fnUpdate(jqInputs[4].value, nRow, 4, false);
        oTable.fnUpdate(jqInputs[5].value, nRow, 5, false);
        oTable.fnUpdate('<a class="edit" href="">编辑</a>', nRow, 6, false);
        oTable.fnUpdate('<a class="delete" href="">删除</a>', nRow, 7, false);        console.log(2344);
        oTable.fnUpdate(jqInputs[6].value, nRow, 8, false);
        oTable.fnDraw();


        getTableData();
    }

    var addRow = 1;
    $('#detail_editable_1_new').click(function (e) {
        e.preventDefault();

        if (nNew && nEditing) {
            if (confirm("前面记录没有保存，您是否需要保存?")) {
                saveRow(oTable, nEditing);

                //$(nEditing).find("td:first").html("未保存");
                nEditing = null;
                nNew = false;
            } else {
                oTable.fnDeleteRow(nEditing); // cancel
                nEditing = null;
                nNew = false;
                return;
            }
        }

        //添加一条新的记录
        var aiNew = oTable.fnAddData([addRow++, '', '', '', '', '', '', '', '']);
        var nRow = oTable.fnGetNodes(aiNew[0]);
        editRow(oTable, nRow);
        nEditing = nRow;
        nNew = true;
    });
    //删除操作
    table.on('click', '.delete', function (e) {
        e.preventDefault();
        if (confirm("您确认要删除该行记录吗?") == false) {
            return;
        }
        //获取上一级tr行的数据
        var nRow = $(this).parents('tr')[0];
        var aData = oTable.fnGetData(nRow);

        var found = false;
        $.each(objList, function (i, item) {
            if (item["seq"] == aData[0]) {
                found = true;
                objList.splice(i, 1);
            }
        });
        oTable.fnDeleteRow(nRow);
    });
    //取消操作
    table.on('click', '.cancel', function (e) {
        e.preventDefault();

        if (nNew) {
            oTable.fnDeleteRow(nEditing);
            nEditing = null;
            nNew = false;
        } else {
            restoreRow(oTable, nEditing);
            nEditing = null;
        }
    });
    //编辑操作
    table.on('click', '.edit', function (e) {
        e.preventDefault();
        nNew = false;

        /*获取所击连接的行对象*/
        var nRow = $(this).parents('tr')[0];

        if (nEditing !== null && nEditing != nRow) {
            /* 当前正在编辑 - 但不是此行 - 在继续编辑模式之前恢复旧版 */
            restoreRow(oTable, nEditing);
            editRow(oTable, nRow);
            nEditing = nRow;
        } else if (nEditing == nRow && this.innerHTML == "保存") {
            /* 编辑该行，并准备保存记录 */
            saveRow(oTable, nEditing);
            getTableData();
            nEditing = null;

        } else {
            /* No edit in progress - let's start one */
            editRow(oTable, nRow);
            nEditing = nRow;
        }
    });


    //获取表格的数据，并返回对象列表
    function GetData() {
        var list = [];
        var trs = table.fnGetNodes();
        for (var i = 0; i < trs.length; i++) {
            var data = table.fnGetData(trs[i]);//获取指定行的数据

            var obj = {};
            //obj["seq"] = data[0];//序号
            obj["FeeType"] = data[1];
            obj["OccurTime"] = data[2];
            obj["FeeAmount"] = data[3];
            obj["FeeDescription"] = data[4];
            list.push(obj);
        }
        return list;
    }

    function getTableData(){
        var milasUrl = {};//新建对象，用来存储所有数据

        var subMilasUrlArr = {};//存储每一行数据
        var tableData = {};
        $("#detail_editable_1 tbody tr").each(function (trindex, tritem) {//遍历每一行

            tableData[trindex] = new Array();
            $(tritem).find("td").each(function (tdindex, tditem) {
                // console.log(tditem);
                tableData[trindex][tdindex] = $(tditem).text();//遍历每一个数据，并存入
                subMilasUrlArr[trindex] = tableData[trindex];//将每一行的数据存入
            });

        });
        for (var key in subMilasUrlArr) {
            milasUrl[key] = subMilasUrlArr[key];//将每一行存入对象
        }
        $("#approval-blclml").val(JSON.stringify(milasUrl));


    }
    // function uploadFile(e){
    //     console.log(e);
    //     // filedata = e.currentTarget.files[0];
    //
    //     console.log($(this).val());
    // }

</script>

<?php






