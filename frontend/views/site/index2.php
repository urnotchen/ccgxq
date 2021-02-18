<?php

/* @var $this yii\web\View */



?>

<div class="box box-primary">
    <div class="box-header">
        <i class="ion ion-clipboard"></i>

        <h3 class="box-title">公告</h3>


    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <!-- See dist/js/pages/dashboard.js to activate the todoList plugin -->
        <ul class="todo-list">
            <?php

                foreach ($notices as $notice){
                    echo "<li>
                
                <span class=\"text\">{$notice['title']}</span>
                <small class=\"label fa-pull-right label-info\"><i class=\"fa fa-clock-o\"></i>{$notice['created_at']}</small>
               
            </li>";


                }

            ?>



        </ul>

    </div>


    <!-- /.box-body -->
    <div class="box-footer clearfix no-border">
        <button type="button" class="btn btn-default pull-right"><i class="fa fa-plus"></i> 更多</button>
    </div>
</div>
<!--办事-->

<div class="box box-primary">
    <div class="box-header">
        <i class="ion ion-clipboard"></i>

        <h3 class="box-title">办事</h3>


    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <!-- See dist/js/pages/dashboard.js to activate the todoList plugin -->

        <div class="nav-tabs-custom" style="height: auto">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#activity" data-toggle="tab" aria-expanded="true">个人办事</a></li>
                <li class=""><a href="#timeline" data-toggle="tab" aria-expanded="false">法人办事</a></li>
            </ul>
            <div class="tab-content"  style="height: auto">
<!--                第一个框 个人办事-->
                <div class="tab-pane active" id="activity" style="height: auto">
                    <div class="active tab-pane" id="activity">
                        <!-- Post -->
                        <div class="post">

                            <!-- /.user-block -->

                            <ul class="list-inline">
                                <?php
                                foreach ($personal_project as $one){
//                                    echo " <li>{$one['name']}</li>";
//                            echo "<div class='col-sm-3 col-xs-3' >{$one['name']}</div>";
                                    echo " <button type=\"button col-xs-3\" class=\"btn btn-default\" style='width: 30%'>{$one['name']}</button>";

                                }
                                ?>

                            </ul>


                        </div>
                        <!-- /.post -->

                        <!-- Post -->

                        <!-- /.post -->

                        <!-- Post -->

                    </div>


                </div>
<!--                第二个框 法人办事-->
                <div class="tab-pane" id="timeline">
                    <ul class="list-inline">
                        <?php
                        foreach ($company_project as $one){
//                            echo " <li>{$one['name']}</li>";
                            echo " <button type=\"button col-xs-3\" class=\"btn btn-default\" style='width: 30%'>{$one['name']}</button>";

//                            echo "<div class='col-sm-3 col-xs-3' >{$one['name']}</div>";
                        }
                        ?>

                    </ul>

                </div>


                <div class="tab-pane" id="settings">

                </div>
                <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
        </div>
    </div>


</div>

<?= Yii::$app->getRequest()->userIP; ?>
