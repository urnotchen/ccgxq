<section class="content">

    <div class="row">
        <div class="col-md-3">

            <!-- Profile Image -->
            <div class="">
                <div class="box-body box-profile">
                    <img class="profile-user-img img-responsive img-circle" src="http://adminlte.la998.com/dist/img/user4-128x128.jpg" alt="User profile picture">

                    <h3 class="profile-username text-center"><?php echo $user['real_name']?></h3>

                    <p class="text-muted text-center"><?php echo $user['username']?></p>

                    <ul class="list-group list-group-unbordered">
                        <li class="list-group-item">
                            <a href="info" style="color: black"><b>个人资料</b></a>
                        </li>
                        <li class="list-group-item">
                            <a href="order" style="color: black"><b>我的在线预约</b></a>
                        </li>
                        <li class="list-group-item">
                            <a href="message" style="color: black"><b>我的留言咨询</b></a>
                        </li>
                        <li class="list-group-item">
                            <a href="approval" style="color: black"><b>我的在线办事</b></a>
                        </li>
                    </ul>


                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->

</section>