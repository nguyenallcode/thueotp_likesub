<?php
    require_once("../../config/config.php");
    require_once("../../config/function.php");
    $title = 'Chỉnh sửa thành viên | Admin';
    require_once("../../resoucre/admin/Header.php");
    require_once("../../resoucre/admin/Nav.php");
?>



<?php

if(isset($_GET['id']) && $getUser['level'] == 'admin')
{
    $row = $NguyenAll->get_row(" SELECT * FROM `users` WHERE `id` = '".check_string($_GET['id'])."'  ");
    if(!$row)
    {
        admin_msg_error("Người dùng này không tồn tại", BASE_URL(''), 5000);
    }
}
else
{
    admin_msg_error("Liên kết không tồn tại", BASE_URL(''), 5000);
}

if(isset($_POST['btnSaveUser']) && isset($_GET['id']) && $getUser['level'] == 'admin')
{
    if($NguyenAll->site('status_demo') == 'ON')
    {
        admin_msg_warning("Vui lòng liên hệ Phạm Nguyên để được cấp phép sử dụng !", "", 2000);
    }
    $money = check_string($_POST['money']);
    $used_money = check_string($_POST['used_money']);
    $total_money = check_string($_POST['total_money']);
    $banned = check_string($_POST['banned']);
    $password = check_string($_POST['password']);
    if($row['money'] != $money)
    {
        $NguyenAll->insert("dongtien", array(
            'sotientruoc'   => $row['money'],
            'sotienthaydoi' => $money,
            'sotiensau'     => $money + $row['money'],
            'thoigian'      => gettime(),
            'noidung'       => 'Admin thay đổi số dư ',
            'username'      => $row['username']
            
        ));
    }
    $NguyenAll->update("users", array(
       'password'      => TypePassword($password),
        'money'         => $money,
        'total_money'   => check_string($_POST['total_money']),
        'used_money'   => check_string($_POST['used_money']),
        'banned'        => $banned
    ), " `id` = '".$row['id']."' ");
    admin_msg_success("Thay đổi user thành công", "", 1000);

}
?>






   <!-- /. NAV SIDE  -->
   <div id="page-wrapper" >
            <div id="page-inner">
			 <div class="row">
                    <div class="col-md-12">
                        <h1 class="page-header">
                            Forms Page <small>Best form elements.</small>
                        </h1>
                    </div>
                </div> 
                 <!-- /. ROW  -->
              <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Basic Form Elements
                        </div>
                        <div class="panel-body">
                        <form action="" method="POST">
                            <div class="row">
                                <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Tài khoản</label>
                                            <input value="<?=$row['username'];?>" class="form-control" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label>Mật khẩu</label>
                                            <input name="password" value="<?=$row['password'];?>" class="form-control" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Banned</label>
                                            <select class="form-control" name="banned">
                                            <option value="<?=$row['banned'];?>">
                                            <?php
                                                if($row['banned'] == "0"){ echo 'Hoạt động';}
                                                if($row['banned'] == "1"){ echo 'Banned';}
                                                ?>
                                        </option>
                                        <option value="0">Hoạt động</option>
                                        <option value="1">Banned</option>
                                            </select>
                                        </div>

                                </div>
                                <!-- /.col-lg-6 (nested) -->
                                <div class="col-lg-6">

                                    <div class="form-group">
                                            <label>Số dư</label>
                                            <input name="money" value="<?=$row['money'];?>" class="form-control" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Số tiền đã sử dụng</label>
                                            <input name="used_money" value="<?=$row['used_money'];?>" class="form-control" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Tổng số tiền đã nạp</label>
                                            <input name="total_money" value="<?=$row['total_money'];?>" class="form-control" required>
                                        </div>
                                        
                                </div>
                                
                                <!-- /.col-lg-6 (nested) -->
                            </div>
                            <button type="submit" name="btnSaveUser" class="btn btn-success">Xác nhận thay đổi</button>
                                        <a href="/Admin/User" type="reset" class="btn btn-default">Quay lại</a>
                            <!-- /.row (nested) -->
                        </div>
                        </form>
                        
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>


            <div class="row">
                <div class="col-md-12">
                    <!-- Advanced Tables -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                             Lịch sử dòng tiền gần đây
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                        <th>#</th>
<th>Số tiền trước</th>
<th>Số tiền giao dịch</th>
<th>Số tiền hiện tại</th>
<th>Thời gian</th>
<th>Nội dung</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $i = 0;
                                    foreach($NguyenAll->get_list(" SELECT * FROM `dongtien` WHERE `username` = '".$row['username']."' ORDER BY id DESC ") as $row){
                                    ?>
                                    <tr>
                                        <td><?=$i++;?></td>
                                        <td><?=format_cash($row['sotientruoc']);?></td>
                                        <td><?=format_cash($row['sotienthaydoi']);?></td>
                                        <td><?=format_cash($row['sotiensau']);?></td>
                                        <td><span class="badge badge-dark px-3"><?=$row['thoigian'];?></span></td>

                                        <td><?=$row['noidung'];?></td>
                                    </tr>
                                    <?php }?>
                                    </tbody>
                                </table>
                            </div>
                            
                        </div>
                    </div>
                    <!--End Advanced Tables -->
                </div>
            </div>


            <div class="row">
                <div class="col-md-12">
                    <!-- Advanced Tables -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                             Lịch sử hoạt dộng gần đây
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example1">
                                    <thead>
                                        <tr>
                                        <th>#</th>
<th>Hoạt động</th>
<th>IP</th>
<th>Thời gian</th>
<th>Time giây</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $i = 0;
                                    foreach($NguyenAll->get_list(" SELECT * FROM `logs` WHERE `username` = '".$row['username']."' ORDER BY id DESC ") as $row){
                                    ?>
                                    <tr>
                                    <td><?=$i++;?></td>
                                    <td><?=$row['content'];?></td>
                                    <td><?=$row['ip'];?></td>
                                    <td><span class="badge badge-dark"><?=$row['createdate'];?></span></td>
                                    <td><?=timeAgo($row['time']);?></td>
                                </tr>
                                <?php }?>
                                    </tbody>
                                </table>
                            </div>
                            
                        </div>
                    </div>
                    <!--End Advanced Tables -->
                </div>
            </div>



            <script>
            $(document).ready(function () {
                $('#dataTables-example').dataTable();
            });
            $(document).ready(function () {
                $('#dataTables-example1').dataTable();
            });
    </script>







<?php 
    require_once("../../resoucre/admin/Footer.php");
?>