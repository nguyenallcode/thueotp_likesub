<?php
    require_once("../../config/config.php");
    require_once("../../config/function.php");
    $title = 'Trang chủ Admin';
    require_once("../../resoucre/admin/Header.php");
    require_once("../../resoucre/admin/Nav.php");
?>



   <div id="page-wrapper">
            <div id="page-inner">


                <div class="row">
                    <div class="col-md-12">
                        <h1 class="page-header">
                            Dashboard <small>Admin</small>
                        </h1>
                    </div>
                </div>
                <!-- /. ROW  -->

                <div class="row">
                <div class="col-md-3 col-sm-12 col-xs-12">
                        <div class="panel panel-primary text-center no-boder bg-color-brown">
                            <div class="panel-body">
                                <i class="fa fa-users fa-5x"></i>
                                <h3><?=$NguyenAll->num_rows("SELECT * FROM `users` ");?> </h3>
                            </div>
                            <div class="panel-footer back-footer-brown">
                                Tổng thành viên

                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-12 col-xs-12">
                        <div class="panel panel-primary text-center no-boder bg-color-green">
                            <div class="panel-body">
                            <i class='bx bx-money fa-5x'></i>
                                <h3><?=format_cash($NguyenAll->get_row("SELECT SUM(`money`) FROM `users` ")['SUM(`money`)']);?>đ</h3>
                            </div>
                            <div class="panel-footer back-footer-green">
                                Số dư thành viên

                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-12 col-xs-12">
                        <div class="panel panel-primary text-center no-boder bg-color-blue">
                            <div class="panel-body">
                            <i class="fa fa-bar-chart-o fa-5x"></i>
                                <h3>                            <?=format_cash(
                        $NguyenAll->get_row("SELECT SUM(`thucnhan`) FROM `cards` WHERE `status` = 'thanhcong'")['SUM(`thucnhan`)'] +
                        $NguyenAll->get_row("SELECT SUM(`amount`) FROM `bank_auto` ")['SUM(`amount`)']);?>đ</h3>
                            </div>
                            <div class="panel-footer back-footer-blue">
                                Tông doanh thu

                            </div>
                        </div>
                    </div>

                    <div class="col-md-3 col-sm-12 col-xs-12">
                        <div class="panel panel-primary text-center no-boder bg-color-red">
                            <div class="panel-body">
                            <i class='bx bxs-cart fa-5x' ></i>
                                <h3><?=$NguyenAll->num_rows("SELECT * FROM `history_buy` WHERE `response` = '0'");?> </h3>
                            </div>
                            <div class="panel-footer back-footer-red">
                                Số lượng đã bán
                            </div>
                        </div>
                    </div>

                    </div>



                    
                        <div class="row">
                    <div class="col-md-3 col-sm-3">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                        Doanh thu đơn hàng hôm nay
                        </div>
                        
                        <div class="panel-footer">
<?=format_cash($NguyenAll->get_row("SELECT SUM(`amount`) FROM `history_buy` WHERE `star` >= DATE(NOW()) AND `response` = '0' AND `star` < DATE(NOW()) + INTERVAL 1 DAY ")['SUM(`amount`)']);?>đ
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-3">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Số đơn hàng hôm nay
                        </div>
                        
                        <div class="panel-footer">
<?=format_cash($NguyenAll->num_rows("SELECT * FROM `history_buy` WHERE `star` >= DATE(NOW()) AND `response` = '0' AND `star` < DATE(NOW()) + INTERVAL 1 DAY "));?> đơn
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-3">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Thành viên mới hôm nay
                        </div>
                        
                        <div class="panel-footer">
            <?=format_cash($NguyenAll->num_rows("SELECT * FROM `users` WHERE `createdate` >= DATE(NOW()) AND `createdate` < DATE(NOW()) + INTERVAL 1 DAY "));?>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-3">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Tổng tiền nạp hôm nay
                        </div>
                        
                        <div class="panel-footer">
                        <?=format_cash(
        $NguyenAll->get_row("SELECT SUM(`amount`) FROM `bank_auto` WHERE `deletedate` IS NULL AND `time` >= DATE(NOW()) AND `time` < DATE(NOW()) + INTERVAL 1 DAY ")['SUM(`amount`)'] + 
        $NguyenAll->get_row("SELECT SUM(`thucnhan`) FROM `cards` WHERE `deletedate` IS NULL AND `status` = 'thanhcong' AND `createdate` >= DATE(NOW()) AND `createdate` < DATE(NOW()) + INTERVAL 1 DAY ")['SUM(`thucnhan`)']
                            
                            );?>đ
                        </div>
                    </div>
                </div>

                <!-- Tháng này -->

                <div class="col-md-3 col-sm-3">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                        Doanh thu đơn hàng tháng này
                        </div>
                        
                        <div class="panel-footer">
                        <?=format_cash($NguyenAll->get_row("SELECT SUM(`amount`) FROM `history_buy` WHERE YEAR(star) = ".date('Y')." AND `response` = '0' AND MONTH(star) = ".date('m')."  ")['SUM(`amount`)']);?>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-3">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            Số đơn hàng tháng này
                        </div>
                        
                        <div class="panel-footer">
<?=format_cash($NguyenAll->num_rows("SELECT * FROM `history_buy` WHERE YEAR(star) = ".date('Y')." AND `response` = '0' AND MONTH(star) = ".date('m')." "));?>       
                                     </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-3">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            Thành viên mới tháng này
                        </div>
                        
                        <div class="panel-footer">
                        <?=format_cash($NguyenAll->num_rows("SELECT * FROM `users` WHERE YEAR(createdate) = ".date('Y')." AND MONTH(createdate) = ".date('m')."  "));?>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-3">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            Tổng tiền nạp tháng này
                        </div>
                        
                        <div class="panel-footer">
                        <?=format_cash(
    $NguyenAll->get_row("SELECT SUM(`amount`) FROM `bank_auto` WHERE YEAR(time) = ".date('Y')." AND MONTH(time) = ".date('m')." ")['SUM(`amount`)'] + 
    $NguyenAll->get_row("SELECT SUM(`thucnhan`) FROM `cards` WHERE `status` = 'thanhcong' AND YEAR(createdate) = ".date('Y')." AND MONTH(createdate) = ".date('m')." ")['SUM(`thucnhan`)']
    );?>đ
                        </div>
                    </div>



                </div>
                </div>

                <div class="row">
                <div class="col-md-12">
                    <!-- Advanced Tables -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                             Lịch sử 1000 dòng tiền gần đây
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                        <th>#</th>
                                        <th>Tài khoản</th>
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
                                    foreach($NguyenAll->get_list(" SELECT * FROM `dongtien` ORDER BY id DESC LIMIT 1000") as $row){
                                    ?>
                                    <tr>
                                        <td><?=$i++;?></td>
                                        <td><a 
                                            href="<?=BASE_URL('Admin/EditUser/'.$NguyenAll->getUser($row['username'])['id']);?>"><?=$row['username'];?></a>
                                        </td>
                                        <td><b style="color: blue;"><?=format_cash($row['sotientruoc']);?>đ</b></td>
                                        <td><b style="color: red;"><?=format_cash($row['sotienthaydoi']);?>đ</b></td>
                                        <td><b style="color: green;"><?=format_cash($row['sotiensau']);?>đ</b></td>
                                        <td><span class="badge badge-dark"><?=$row['thoigian'];?></span></td>
                                        <td><i style="font-weight: bold;"><?=$row['noidung'];?></i></td>
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
                             Lịch sử 1000 hoạt dộng gần đây
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example1">
                                    <thead>
                                        <tr>
                                        <th>#</th>
                    <th>Username</th>
                    <th>Nội dung</th>
                    <th>IP</th>
                    <th>Thời gian</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                            $i = 0;
                            foreach($NguyenAll->get_list(" SELECT * FROM `logs` ORDER BY id DESC LIMIT 1000") as $row){
                            ?>
                                    <tr>
                                        <td><?=$i++;?></td>
                                        
                    <td><a
                href="<?=BASE_URL('Admin/EditUser/'.$NguyenAll->getUser($row['username'])['id']);?>"><?=$row['username'];?></a>
                    </td>
                                        
                                        <td><i style="font-weight: bold;"><?=$row['content'];?></i></td>
                                        <td><?=$row['ip'];?></td>
                                        <td><span class="badge badge-dark"><?=$row['createdate'];?></span></td>
                            
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