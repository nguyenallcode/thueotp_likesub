<?php



if(isset($_SESSION['username']))
{
    $getUser = $NguyenAll->get_row(" SELECT * FROM `users` WHERE `username` = '".$_SESSION['username']."' AND `level` = 'admin' ");
    if(!$getUser)
    {
        header("location:".BASE_URL('Logout'));
        exit();
    }
    if($getUser['banned'] != 0)
    {
        echo 'Tài khoản của bạn đã bị khóa bởi quản trị viên !';
        //header("location:".BASE_URL('banned.php'));
        exit();
    }
}
else
{
    header("location: ".BASE_URL(''));
    exit();
}