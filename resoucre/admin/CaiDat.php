<?php
    require_once("../../config/config.php");
    require_once("../../config/function.php");
    $title = 'Cài Đặt Website | Admin';
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
    if(check_img('favicon') == true)
    {
        $rand = random('0123456789QWERTYUIOPASDGHJKLZXCVBNM', 3);
        $uploads_dir = '../../assets/storage/images';
        $tmp_name = $_FILES['favicon']['tmp_name'];
        $url_img = "favicon".$rand.".png";
        $create = move_uploaded_file($tmp_name, $uploads_dir.$url_img);
        if($create)
        {
            $NguyenAll->update('options', [
                'value'  => '/assets/storage/images'.$url_img,
            ], " `name` = 'favicon' ");
        }
    }
    if(check_img('logo') == true)
    {
        $rand = random('0123456789QWERTYUIOPASDGHJKLZXCVBNM', 3);
        $uploads_dir = '../../assets/storage/images';
        $tmp_name = $_FILES['logo']['tmp_name'];
        $url_img = "logo".$rand.".png";
        $create = move_uploaded_file($tmp_name, $uploads_dir.$url_img);
        if($create)
        {
            $NguyenAll->update('options', [
                'value'  => '/assets/storage/images'.$url_img,
            ], " `name` = 'logo' ");
        }
    }
    if(check_img('anhbia') == true)
    {
        $rand = random('0123456789QWERTYUIOPASDGHJKLZXCVBNM', 3);
        $uploads_dir = '../../assets/storage/images';
        $tmp_name = $_FILES['anhbia']['tmp_name'];
        $url_img = "anhbia".$rand.".png";
        $create = move_uploaded_file($tmp_name, $uploads_dir.$url_img);
        if($create)
        {
            $NguyenAll->update('options', [
                'value'  => '/assets/storage/images'.$url_img,
            ], " `name` = 'anhbia' ");
        }
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
                <div class="col-lg-5">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Cài đặt Website
                        </div>
                        <div class="panel-body">
                        <form action="" method="POST">
                            <div class="row">
                                <div class="col-lg-12">
                                        <div class="form-group">
                                            <label>Tên Website</label>
                                            <input value="<?=$NguyenAll->site('tenweb');?>" name="tenweb" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label>Mô tả Website</label>
                                            <input name="mota" value="<?=$NguyenAll->site('mota');?>" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label>Từ khóa tìm kiếm</label>
                                            <input name="tukhoa" value="<?=$NguyenAll->site('tukhoa');?>" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label>Tắt/mở tạo đơn link ảo</label>
                                            <select class="form-control" name="tao_link_ao">
                                            <option value="<?=$NguyenAll->site('tao_link_ao');?>">
                                            <?php
                                                if($NguyenAll->site('tao_link_ao') == "ON"){ echo 'Mở';}
                                                if($NguyenAll->site('tao_link_ao') == "OFF"){ echo 'Tắt';}
                                                ?>
                                        </option>
                                        <option value="ON">Mở</option>
                                        <option value="OFF">Tắt</option>
                                            </select>
                                        </div>
                                </div>
                                </div>

                            <button type="submit" name="btnSaveOption" class="btn btn-success">Xác nhận thay đổi</button>
                            <!-- /.row (nested) -->
                        </div>
                        </form>
                        <!-- /.panel-body -->
                    </div>
            </div>



            <?php
if(isset($_POST['Savegialink'])) {
    foreach($_POST['sotien'] as $goi_id => $sotien) {
        $goi_id = intval($goi_id);
        $sotien = floatval($sotien);

        if ($goi_id > 0 && $sotien >= 0) {
            $NguyenAll->update("goi_link", array('sotien' => $sotien), " `id` = '$goi_id'");
        }
    }

    echo '<div class="alert alert-success">Cập nhật giá link thành công!</div>';
}

$goi_link_list = $NguyenAll->get_list("SELECT * FROM `goi_link` ORDER BY id DESC");
?>

            <div class="col-lg-3">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Cài đặt giá Link
                        </div>
                        <div class="panel-body">
                        <form action="" method="POST">
                            <div class="row">
                                <div class="col-lg-12">
                                <?php foreach($goi_link_list as $row) { ?>
                                        <div class="form-group">
                                            <label>Giá Loại <?=$row['tengoi'];?></label>
                                            <input value="<?=$row['sotien'];?>" name="sotien[<?=$row['id'];?>]" class="form-control">
                                        </div>
                                        <?php }?>
                                        <b>Chỉnh giá = 0 nếu để bảo trì</b>
                                </div>
                                </div>
                            <button type="submit" name="Savegialink" class="btn btn-success">Xác nhận thay đổi</button>
                            <!-- /.row (nested) -->
                        </div>
                        </form>
                        <!-- /.panel-body -->
                    </div>
            </div>



            <div class="col-lg-4">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Cài đặt ảnh
                        </div>
                        <div class="panel-body">
                        <form action="" method="POST" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-lg-12">
                                <div class="form-group">
                                            <label>Logo Website</label>
                                            <input name="logo" type="file">
                                            <img width="200px"  src="<?=$NguyenAll->site('logo');?>"/>
                                        </div>
                                <div class="form-group">
                                            <label>Icon Website</label>
                                            <input name="favicon" type="file">
                                            <img width="100px" height="100px" src="<?=$NguyenAll->site('favicon');?>"/>
                                        </div>
                                        <div class="form-group">
                                            <label>Ảnh bìa Website</label>
                                            <input name="anhbia" type="file">
                                            <img width="200px" src="<?=$NguyenAll->site('anhbia');?>"/>
                                        </div>
                                </div>
                                </div>
                            <button type="submit" name="btnSaveOption" class="btn btn-success">Xác nhận thay đổi</button>
                            <!-- /.row (nested) -->
                        </form>
                    </div>
                    </div>

                    
                    <!-- /.panel -->
                </div>







<?php 
    require_once("../../resoucre/admin/Footer.php");
?>