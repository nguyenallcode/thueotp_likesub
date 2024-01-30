<?php 
    require_once("../../config/config.php");
    require_once("../../config/function.php");


    if($_POST['type'] == 'Login' )
    {
        $username = check_string($_POST['username']);
        $password = TypePassword(check_string($_POST['password']));
        
        if(empty($username))
        {
            msg_nguyenall_error("Vui lòng nhập tên đăng nhập");
        }
        if(!$row = $NguyenAll->get_row(" SELECT * FROM `users` WHERE `username` = '$username' "))
        {
            msg_nguyenall_error('Tên đăng nhập không tồn tại');
        }
        if(empty($password))
        {
            msg_nguyenall_error("Vui lòng nhập mật khẩu");
        }
        if($NguyenAll->get_row(" SELECT * FROM `users` WHERE `username` = '$username' AND `banned` = '1' "))
        {
            msg_nguyenall_error('Tài khoản đã bị khóa!');
        }
        if(!$NguyenAll->get_row(" SELECT * FROM `users` WHERE `username` = '$username' AND `password` = '$password' "))
        {
            msg_nguyenall_error('Mật khẩu đăng nhập không chính xác');
        }
$ip_address = $_SERVER['REMOTE_ADDR'];
$api_url = 'https://ipinfo.io/' . $ip_address . '?token=7c838d46a25bd1';
$response = file_get_contents($api_url);
$location = json_decode($response);
if ($location && $location->ip == $ip_address) {
    $region_name = $location->region;
} else {
    $region_name = 'No_Location';
}
$devicecheck = is_numeric(strpos(strtolower($_SERVER['HTTP_USER_AGENT']),"mobile"));
$devicecheck_android = is_numeric(strpos(strtolower($_SERVER['HTTP_USER_AGENT']),"android"));
$device_type = "Máy tính";
if ($devicecheck == 1 || $devicecheck_android == 1) {
    $device_type = "Điện thoại";
}
        $Mobile_Detect = new Mobile_Detect;
        $NguyenAll->update("users", [
             'otp'       => NULL,
             'ip'        => myip(),
             'timelogin'      => gettime(),
             'time'      => time(),
            'UserAgent' => $Mobile_Detect->getUserAgent()
        ], " `username` = '$username' ");
        $NguyenAll->insert("logs", [
            'username'  => $username,
            'ip'        => myip(),
            'content'   => 'Đăng nhập tài khoản bằng ' . $device_type . ' | ' . $region_name,
            'createdate'=> gettime(),
            'time'      => time()
        ]);
        $cookie_token = md5(uniqid(rand(), true));
        $expiry_time = time() + 30*24*3600;
        setcookie("username", $username, $expiry_time, '/');
        setcookie("token", $cookie_token, $expiry_time, '/');
        $NguyenAll->update("users", array('token' => $cookie_token), "username = '".$username."' ");
        $_SESSION['username'] = $username;
        echo "<meta http-equiv='refresh' content='1;URL=/' />";
        
        msg_nguyenall_success('Đăng nhập thành công ! ');
    }

  

    if($_POST['type'] == 'Register' )
    {
        $username = check_string($_POST['username']);
        $email = check_string($_POST['email']);
        $password = check_string($_POST['password']);
        $repassword = check_string($_POST['repassword']);
        if(empty($username))
        {
            msg_nguyenall_error("Vui lòng nhập tên tài khoản !");
        }
        if(check_username($username) != True)
        {
            msg_nguyenall_error('Vui lòng nhập định dạng tài khoản hợp lệ');
        }
        if(check_email($email) != True)
        {
            msg_nguyenall_error('Vui lòng nhập email hợp lệ');
        }
        if(strlen($username) < 6 || strlen($username) > 16)
        {
            msg_nguyenall_error('Tài khoản từ 6 đến 16 ký tự');
        }
        if($NguyenAll->get_row(" SELECT * FROM `users` WHERE `username` = '$username' "))
        {
            msg_nguyenall_error('Tên đăng nhập đã tồn tại!');
        }
        if(empty($password))
        {
            msg_nguyenall_error("Vui lòng nhập mật khẩu !");
        }
        if(strlen($password) < 3)
        {
            msg_nguyenall_error('Vui lòng đặt mật khẩu trên 3 ký tự');
        }
        if($password != $repassword)
        {
            msg_nguyenall_error('Nhập lại mật khẩu không đúng');
        }
         if($NguyenAll->num_rows(" SELECT * FROM `users` WHERE `ip` = '".myip()."' ") > 3)
        {
            msg_nguyenall_error('Bạn đã đạt giới hạn tạo 3 tài khoản');
        }
$ip_address = $_SERVER['REMOTE_ADDR'];
$api_url = 'https://ipinfo.io/' . $ip_address . '?token=7c838d46a25bd1';
$response = file_get_contents($api_url);
$location = json_decode($response);
if ($location && $location->ip == $ip_address) {
    $region_name = $location->region;
} else {
    $region_name = 'No_Location'; // Không có thông tin về tỉnh
}
$devicecheck = is_numeric(strpos(strtolower($_SERVER['HTTP_USER_AGENT']),"mobile"));
$devicecheck_android = is_numeric(strpos(strtolower($_SERVER['HTTP_USER_AGENT']),"android"));
$device_type = "Máy tính";
if ($devicecheck == 1 || $devicecheck_android == 1) {
    $device_type = "Điện thoại";
}
        $create = $NguyenAll->insert("users", [
            'username'      => $username,
            'email'      => $email,
            'password'      => TypePassword($password),
            'token'         => random('qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM', 64),
            'api_key'         => random('qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM', 32),
            'money'         => 0,
            'total_money'   => 0,
            'banned'        => 0,
            'ip'            => myip(),
            'timelogin'      => gettime(),
            'time'          => time(),
            'createdate'    => gettime()
        ]);
              $NguyenAll->insert("logs", [
            'username'  => $username,
            'ip'        => myip(),
            'content'   => 'Đăng kí tài khoản bằng ' . $device_type . ' | ' . $region_name,
            'createdate'=> gettime(),
            'time'      => time()
        ]);
        
        if ($create)
        {   
            $cookie_token = md5(uniqid(rand(), true));
            $expiry_time = time() + 30*24*3600;
            setcookie("username", $username, $expiry_time, '/');
            setcookie("token", $cookie_token, $expiry_time, '/');
            $NguyenAll->update("users", array('token' => $cookie_token), "username = '".$username."' ");
            
            $_SESSION['username'] = $username;
            $_SESSION['password'] = $password;

            echo "<meta http-equiv='refresh' content='1;URL=/' />";
            msg_nguyenall_success('Đăng kí tài khoản thành công ! ');
        }
        else
        {
            msg_nguyenall_error('Vui lòng kiểm tra cấu hình DATABASE');
        }
    }



    if($_POST['type'] == 'DoiMatKhau')
    {
        if($NguyenAll->site('status_demo') == 'ON')
        {
            msg_nguyenall_error("Chức năng này không khả dụng trên trang web DEMO!");
        }
        $row = $NguyenAll->get_row(" SELECT * FROM `users` WHERE `username` = '".$_SESSION['username']."' ");
        $password = check_string($_POST['password']);
        $passwordold = check_string($_POST['passwordold']);

        if(empty($passwordold))
        {
            msg_nguyenall_error("Bạn chưa nhập mật khẩu cũ");
        }
        if($passwordold != $row['password'])
        {
            msg_nguyenall_error("Mật khẩu cũ không đúng");
        }

        if(empty($password))
        {
            msg_nguyenall_error("Bạn chưa nhập mật khẩu mới");
        }

        if(empty($password))
        {
            msg_nguyenall_error("Bạn chưa nhập mật khẩu mới");
        }
        if(strlen($password) < 5)
        {
            msg_nguyenall_error('Vui lòng nhập mật khẩu có ích nhất 5 ký tự');
        }
        
        if(!$row)
        {
            msg_nguyenall_error("Bạn chưa đăng nhập");
        }
        $NguyenAll->insert("logs", [
            'username'  => $getUser['username'],
            'ip'        => myip(),
            'content'   => 'Thực hiện thay đổi mật khẩu mới',
            'createdate'=> gettime(),
            'time'      => time()
        ]);
        $NguyenAll->update("users", [
            'otp' => NULL,
            'password' => TypePassword($password)
        ], " `id` = '".$row['id']."' ");
        msg_nguyenall_success('Thay đổi mật khẩu thành công.');
    }