<section class="content">

    <div class="row">
        <div class="col-md-12">

            <!-- Profile Image -->

            <!-- /.box -->

            <!-- About Me Box -->
            <div class="">
                <div class="box-header with-border" style="">
                    <img class="profile-user-img img-responsive img-circle" src="http://adminlte.la998.com/dist/img/user4-128x128.jpg" alt="User profile picture">

                    <h4 class="box-title1" style="text-align:center;">  &nbsp;个人信息</h4>
                </div>
                <!-- /.box-header -->
                <div class=" box-body">
                    <strong>真实姓名</strong><span style="float: right"> <?php echo $user['real_name'];?></span>
                    <hr>
                    <strong>登录名称</strong><span style="float: right"> <?php echo $user['username'];?></span>
                    <hr>
                    <strong>注册时间</strong><span style="float: right"> <?php echo $user['created_at'];?></span>
                    <hr>



                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
        <!-- /.col -->

        <!-- /.col -->
    </div>
    <!-- /.row -->

</section>