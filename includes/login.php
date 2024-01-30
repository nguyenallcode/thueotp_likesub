<?php
if(isset($_SESSION['username']))
{
    $getUser = $NguyenAll->get_row(" SELECT * FROM `users` WHERE `username` = '".$_SESSION['username']."' ");

    if(!$getUser)
    {
        header("location: ".BASE_URL('sign-out'));
        exit();
    }

    $token_expiry_time = strtotime($getUser['token']);
    if ($token_expiry_time < time()) {
        header("location: ".BASE_URL('sign-out'));
        exit();
    }

    if($getUser['banned'] != 0)
    {
        echo 'Tài khoản của bạn đã bị khóa bởi quản trị viên !';
        exit();
    }

    if($getUser['money'] < 0)
    {
        $NguyenAll->update("users", array(
            'banned' => 1
        ), "username = '".$getUser['username']."' ");
        die('Tài khoản của bạn đã bị khóa tự động bởi hệ thống - Khiếu lại liên hệ Zalo: 0786333381');
    }
}
else
{
    header("location: ".BASE_URL('/'));
    exit();
}
?>
