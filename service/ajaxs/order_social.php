<?php 
require_once __DIR__.'/../../config/config.php';
require_once __DIR__.'/../../config/function.php';


    if($_POST['type'] == 'Order')
    {
        if(empty($_SESSION['username']))
        {
            admin_msg_error("Vui lòng đăng nhập để thanh toán !");
        }
        $id_url = check_string($_POST['id_url']);
        $server = check_string($_POST['server']);
        $amount = check_string($_POST['amount']);
        $ghichu = check_string($_POST['ghichu']);
        $uid_title = isset($_GET['uid_title']) ? $_GET['uid_title'] : null;
        $groups_social = $NguyenAll->get_row("SELECT * FROM `groups_social` WHERE `uid_title` = '$uid_title' ");
        $service_social = $NguyenAll->get_row("SELECT * FROM `service_social` WHERE `groups` = '".$groups_social['id']."' ");

        if(!$groups_social)
        {
            admin_msg_error("Dịch vụ không hợp lệ, F5 lại trang và thử lại!");
        }
        if(empty($id_url))
        {
            admin_msg_error("Trường ID không được bỏ trống.");
        }
        if(empty($server))
        {
            admin_msg_error("Trường máy chủ không được bỏ trống.");
        }
        $total_money = $service_social['rate'] * $amount;
        if($total_money > $getUser['money'])
        {
            admin_msg_error("Số dư không đủ vui lòng nạp thêm");
        }
         /* CỘNG CHI TIÊU */
        $NguyenAll->cong("users", "used_money", $total_money, " `username` = '".$getUser['username']."' ");
        $isMoney = $NguyenAll->tru("users", "money", $total_money, " `username` = '".$getUser['username']."' ");
        
        if($isMoney)
        {
            $isOrder = $NguyenAll->insert("orders_caythue", [
                'username' => $getUser['username'],
                'dichvu'   => $group['title'],
                'groups'   => $getname['title'],
                'idgroups'   => $getname['id'],
                'money'    => $total_money,
                'tk'   => $tk,
                'mk'    => $mk,
                'createdate' => gettime(),
                'status'     => 'xuly',
                'ghichu'     => $ghichu
            ]);
            $NguyenAll->insert("history_caythueao", [
                'username' => $getUser['username'],
                'dichvu'   => $group['title'],
                'idgroups'   => $getname['id'],
                'money'    => $total_money,
                'createdate' => gettime1(),
                'time'     => time()
            ]);
            if($isOrder)
            {
                /* GHI LOG DÒNG TIỀN */
                $NguyenAll->insert("dongtien", array(
                    'sotientruoc'   => $getUser['money'] + $total_money,
                    'sotienthaydoi' => $total_money,
                    'sotiensau'     => $getUser['money'],
                    'thoigian'      => gettime(),
                    'noidung'       => 'Đặt hàng gói ('.$group['title'].')',
                    'username'      => $getUser['username']
                ));
                msg_success("Thanh toán thành công!", BASE_URL("lich-su-mua-dich-vu"), 2000);
            }
            else
            {
                $NguyenAll->cong("users", "money", $total_money, " `username` = '".$getUser['username']."' ");
                admin_msg_error("Không thể xử lý giao dịch, vui lòng thử lại");
            }
        }
        else
        {
            admin_msg_error("Không thể xử lý giao dịch, vui lòng thử lại");
        }
    }