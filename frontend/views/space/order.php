<section class="content">

    <div class="row">
        <div class="col-md-12">

            <!-- Profile Image -->

            <!-- /.box -->

            <!-- About Me Box -->

                <div class="  box-primary box-header with-border" >
                <img class="profile-user-img img-responsive img-circle" src="http://adminlte.la998.com/dist/img/user4-128x128.jpg" alt="User profile picture">

                <h4 class="box-title1" style="text-align:center;">  &nbsp;预约信息</h4>

                <?php foreach($books as $book){echo"
                
                <!-- /.box-header -->
               

                    
                <div class=\"box-body\">
                    <strong><i class=\"fa fa-book margin-r-5\"></i>预约项目名称</strong>
                    <span style='float: right' class=text-muted>
                         <a href='/order/view?id={$book['order_id']}'>{$book["order_name"]}</a>
                    </span>

                    <hr>
                    <strong><i class=\"fa fa-calendar-times-o margin-r-5\"></i> 预约项目时间</strong>
                    <span style='float: right' class=text-muted>
                        {$book["book_time"]}
                    </span>

                    <hr>

                    <strong><i class=\"fa fa-map-marker margin-r-5\"></i> 地址</strong>

                   <span style='float: right' class=text-muted>
                        {$book["address"]}
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