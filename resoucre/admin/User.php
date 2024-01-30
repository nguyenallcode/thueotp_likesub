<?php
    require_once("../../config/config.php");
    require_once("../../config/function.php");
    $title = 'Thành viên | Admin';
    require_once("../../resoucre/admin/Header.php");
    require_once("../../resoucre/admin/Nav.php");
?>




<div id="page-wrapper">
    <div id="page-inner">
                        <div class="row">
                <div class="col-md-12">
                    <!-- Advanced Tables -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                             Danh sách thành viên
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                    <th>#</th>
                                        <th>Thông tin</th>
                                         <th>Số tiền</th>
                                        <th>Thời gian</th>
                                        <th>Thao tác</th>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $i = 0;
                                    foreach($NguyenAll->get_list(" SELECT * FROM `users` WHERE `username` IS NOT NULL ORDER BY id DESC ") as $row){
                                    ?>
                                    <tr>
                                        <td><?=$i++;?></td>
                                        <td>
                                            <ul>
                                                <li>Tên đăng nhập: <b><?=$row['username'];?></b></li>
                                                <li>IP: <b><?=$row['ip'];?></b></li>
                                                 <li>Banned: <?=display_banned($row['banned']);?></li>
                                            </ul>
                                        </td>
                                        <td>
                                            <ul>
                                                <li>Số dư khả dụng: <b style="color:blue;"><?=format_cash($row['money']);?></b></li>
                                                <li>Tổng nạp: <b style="color: blue;"><?=format_cash($row['total_money']);?></b></li>
                                                <li>Tổng nạp: <b style="color: blue;"><?=format_cash($row['used_money']);?></b></li>
                                            </ul>
                                        </td>

                                        <td><ul>
                                                <li>Đăng nhập gần đây: <b style="color:red;"><?=($row['createdate']);?></b></li>
                                                <li>Ngày tham gia: <b style="color: red;"><?=($row['timelogin']);?></b></li>
                                            </ul></td>
                                        <td>
                                          <a type="button" href="<?=BASE_URL('Admin/EditUser/');?><?=$row['id'];?>"
                                                class="btn btn-primary btn-sm"><i class="fa fa-edit "></i>
                                                <span>Xem</span></a>
                                            </button>
                                        </td>
                                    </tr>
                                    <?php }?>


                                    </tbody>
                                </table>
                            </div>
                            
                        </div>
                    </div>
                    <!--End Advanced Tables -->
                    
            <script>
function copyToClipboard(text) {
  navigator.clipboard.writeText(text).then(function() {
    var copiedText = text; 
    Swal.fire({
      icon: 'success',
      title: 'Copy thành công',
      text: 'Copy thành công: ' + copiedText,
      timer: 3000,
    });

  }, function() {
    console.error('Lỗi khi sao chép');
  });
}

</script>
            <script>
            $(document).ready(function () {
                $('#dataTables-example').dataTable();
            });
    </script>






<?php 
    require_once("../../resoucre/admin/Footer.php");
?>