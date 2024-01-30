<?php
    require_once("../../config/config.php");
    require_once("../../config/function.php");
    $title = 'Cấu Hình Nạp Tiền | Admin';
    require_once("../../resoucre/admin/Header.php");
    require_once("../../resoucre/admin/Nav.php");
?>
<?php

if(isset($_POST['btnSaveOption']) && $getUser['level'] == 'admin')
{
    if($NguyenAll->site('status_demo') == 'ON')
    {
        msg_error("Liên hệ Phạm Nguyên để Active Website", "", 2000);
    }
//    if ($getUser['username'] != 'nguyenall' ) {
//         $errorMsg = sprintf("Bạn không phải Phạm Nguyên - Nếu cố tình chỉnh sửa TK (%s) của bạn sẽ bị Band ", $getUser['username']);
        
//         $NguyenAll->insert("logs", [
//             'username'  => $getUser['username'],
//             'ip'        => myip(),
//             'content'   => 'Đang thực hiện thay đổi API Nạp thẻ cào !',
//             'createdate'=> gettime(),
//             'time'      => time()
//         ]);
//         admin_msg_error($errorMsg, '', 5000);
//     }
    foreach ($_POST as $key => $value)
    {
        $NguyenAll->update("options", array(
            'value' => $value
        ), " `name` = '$key' ");
    }
    msg_success('Lưu thành công', '', 500);
}
?>

   <!-- /. NAV SIDE  -->
   <div id="page-wrapper" >
            <div id="page-inner">
			 <div class="row">
                    <div class="col-md-6">
                        <h1 class="page-header">
                            Forms Page <small>Best form elements.</small>
                        </h1>
                    </div>
                </div> 
                 <!-- /. ROW  -->
              <div class="row">
                <div class="col-lg-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Cấu hình nạp thẻ cào
                        </div>
                        <div class="panel-body">
                        <form action="" method="POST">
                            <div class="row">
                                <div class="col-lg-12">
                                        <div class="form-group">
                                            <label>URL API NẠP THẺ</label>
                                            <input value="<?=$NguyenAll->site('apinapthe');?>" name="apinapthe" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label>ID API</label>
                                            <input name="idapi" value="<?=$NguyenAll->site('idapi');?>" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label>KEY API</label>
                                            <input name="keyapi" value="<?=$NguyenAll->site('keyapi');?>" class="form-control">
                                        </div>
                                </div>
                            </div>
                            <button type="submit" name="btnSaveOption" class="btn btn-success">Xác nhận thay đổi</button>
                            <!-- /.row (nested) -->
                        </div>
                        </form>
                        
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->


                <!-- /.col-lg-12 -->
            </div>

            <div class="row">
                <div class="col-md-12">
                    <!-- Advanced Tables -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                             Lịch sử nạp tiền
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Mã giao dịch</th>
                                            <th>Người nạp</th>
                                            <th>Số tiền</th>
                                            <th>Thực nhận</th>
                                            <th>Ngân hàng</th>
                                            <th>Nội dung</th>
                                            <th>Thời gian</th>
                                        </tr>
                                    </thead>
                                    <tbody>
        <?php $i = 0; foreach($NguyenAll->get_list(" SELECT * FROM `bank_auto` ORDER BY id DESC ") as $row){ ?>
                                        <tr class="gradeX">
                                            <td><?=$i++;?></td>
                                            <td><?=$row['tid'];?></td>
                                            <td><?=$row['username'];?></td>
                                            <td><?=format_cash($row['amount']);?></td>
                                            <td><?=format_cash($row['thucnhan']);?></td>
                                            <td class="center"><?=$row['bank_nap'];?></td>
                                            <td class="center"><?=$row['description'];?></td>
                                            <td class="center"><?=$row['time'];?></td>
                                        </tr>
                                        <?php }?>
                                    </tbody>
                                </table>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <!-- Advanced Tables -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                             Lịch sử nạp tiền qua thẻ cào
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example1">
                                    <thead>
                                        <tr>
                                        <th>#</th>
                                        <th>Người nạp</th>
                                            <th>Seri</th>
                                            <th>Mã thẻ</th>
                                            <th>Mệnh giá</th>
                                            <th>Thực nhận</th>
                                            <th>Trạng thái</th>
                                            <th>Thời gian</th>
                                        </tr>
                                    </thead>
                                    <tbody>
<?php $i = 1; foreach($NguyenAll->get_list(" SELECT * FROM `cards`  ORDER BY id DESC ") as $row){ ?>
                                        <tr class="gradeX">
                                            <td><?=$i++;?></td>
                                            <td><?=$row['username'];?></td>
                                            <td><?=$row['seri'];?></td>
                                            <td><?=$row['pin'];?></td>
                                            <td><?=format_cash($row['menhgia']);?></td>
                                            <td><?=format_cash($row['thucnhan']);?></td>
                                            <td class="center"><?=$row['status'];?></td>
                                            <td class="center"><?=$row['createdate'];?></td>
                                        </tr>
                                        <?php }?>
                                    </tbody>
                                </table>
                    </div>
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