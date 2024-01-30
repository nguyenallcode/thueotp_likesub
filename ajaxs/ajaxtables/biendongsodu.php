<?php
require_once("../../config/config.php");
require_once("../../config/function.php");

header('Content-Type: application/json');

$row = $NguyenAll->get_list("SELECT * FROM `dongtien` WHERE `username` = '".$getUser['username']."' ORDER BY id DESC");
$data = array();

foreach ($row as $rows) {

    if ($rows['sotiensau'] > $rows['sotientruoc']){
        $type = '<b style="color: green;">- '.format_cash($rows['sotienthaydoi']).'đ</b>';
    } else {
        $type = '<b style="color: red;">- '.format_cash($rows['sotienthaydoi']).'đ</b>';
    }

    
    $data[] = array(
        'type' => ' '. $type . '',
        'soduconlai' => format_cash($rows['sotiensau']) . ' đ',
        'noidung' => '' . $rows['noidung'] . '',
        'thoigian' => '' . $rows['thoigian'] . '',
    );
}

echo json_encode(array('data' => $data));
?>
