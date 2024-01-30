<?php
    require_once("../../config/config.php");
    require_once("../../config/function.php");
    $title = 'Cài Đặt Thông Báo | Admin';
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
    foreach ($_POST as $key => $value)
    {
        $NguyenAll->update("options", array(
            'value' => $value
        ), " `name` = '$key' ");
    }
    msg_success('Lưu thành công', '', 500);
}
?>


    <!-- Summernote CSS -->

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
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Cài đặt Website
                        </div>
                        <div class="panel-body">
                        <form action="" method="POST">
                            <div class="row">
                                <div class="col-lg-12">
                                        <div class="form-group">
                                            <label>Lưu ý mua hàng</label>
                                            <textarea name="thongbao" id="thongbao" placeholder="Nhập thông báo của bạn..."><?=$NguyenAll->site('thongbao');?></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label>Lưu ý nạp thẻ</label>
                                            <textarea name="luuy_napthe" id="luuy_napthe" placeholder="Nhập thông báo của bạn..."><?=$NguyenAll->site('luuy_napthe');?></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label>Lưu ý nạp ATM</label>
                                            <textarea name="luuy_napbank" id="luuy_napbank" placeholder="Nhập thông báo của bạn..."><?=$NguyenAll->site('luuy_napbank');?></textarea>
                                        </div>
                                </div>
                                </div>

                            <button type="submit" name="btnSaveOption" class="btn btn-success">Xác nhận thay đổi</button>
                            <!-- /.row (nested) -->
                        </div>
                        </form>
                    </div>
            </div>
                </div>


                <script defer>
   $(document).ready(function() {
      $('#thongbao').summernote();
      $('#luuy_napthe').summernote();
      $('#luuy_napbank').summernote();
   });
</script>



<?php 
    require_once("../../resoucre/admin/Footer.php");
?>