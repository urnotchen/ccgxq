<section class="content">

    <div class="row">
        <div class="col-md-12">

            <!-- Profile Image -->

            <!-- /.box -->

            <!-- About Me Box -->

            <div class="  box-primary box-header with-border" >
                <img class="profile-user-img img-responsive img-circle" src="http://adminlte.la998.com/dist/img/user4-128x128.jpg" alt="User profile picture">

                <h4 class="box-title1" style="text-align:center;">  &nbsp;在线办理</h4>

                <?php foreach($deals as $deal){echo"
                
                <!-- /.box-header -->
               

                    
                <div class=\"box-body\">
                    <strong><i class=\"fa fa-book margin-r-5\"></i>办理事项</strong>
                    <span style='float: right' class=text-muted>
                         <a href='/approval/view?id={$deal["approval_id"]}'>{$deal["approval_name"]}</a>
                    </span>

                    <hr>
                    <strong><i class=\"fa fa-calendar-times-o margin-r-5\"></i> 办理日期</strong>
                    <span style='float: right' class=text-muted>
                        {$deal["created_at"]}
                    </span>

                    <hr>

                    <strong><i class=\"fa fa-fw fa-bar-chart-o margin-r-5\"></i> 状态</strong>

                   <span style='float: right' class=text-muted>
                        {$deal["status"]}
                    </span>
                    
                    <hr>
          
                </div>";}?>

            </div>
        </div>
        <!-- /.col -->

        <!-- /.col -->
    </div>
    <!-- /.row -->

</section>