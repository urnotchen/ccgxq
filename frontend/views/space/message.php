<section class="content">

    <div class="row">
        <div class="col-md-12">

            <!-- Profile Image -->

            <!-- /.box -->

            <!-- About Me Box -->

            <div class="  box-primary box-header with-border" >
                <img class="profile-user-img img-responsive img-circle" src="http://adminlte.la998.com/dist/img/user4-128x128.jpg" alt="User profile picture">

                <h4 class="box-title1" style="text-align:center;">  &nbsp;留言咨询</h4>

                <?php foreach($messages as $message){echo"
                
                <!-- /.box-header -->
               

                    
                <div class=\"box-body\">
                    <strong><i class=\"fa fa-book margin-r-5\"></i>留言标题</strong>
                    <span style='float: right' class=text-muted>
                         {$message["title"]}
                    </span>

                    <hr>
                    <strong><i class=\"fa fa-calendar-times-o margin-r-5\"></i> 留言日期</strong>
                    <span style='float: right' class=text-muted>
                        {$message["created_at"]}
                    </span>

                    <hr>

                    <strong><i class=\"fa fa-fw fa-bar-chart-o margin-r-5\"></i> 状态</strong>

                   <span style='float: right' class=text-muted>
                        {$message["status"]}
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