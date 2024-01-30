<?php
require_once("../../config/config.php");
require_once("../../config/function.php");

header('Content-Type: application/json');

$list_sms = $NguyenAll->get_list("SELECT * FROM `list_sms` WHERE `baotri` = 'no' ORDER BY uutien DESC");
$data = array();

foreach ($list_sms as $list) {
    $data[] = array(
        'name' => '<img onerror="imgError(this)" src="' . $list['icon'] . '" width="30" height="30" class="me-2" alt="Icon">' . $list['name'],
        'amount' => format_cash($list['amount']) . ' đ',
        'action' => '<button class="btn btn-primary buy-button" data-id="' . $list['id'] . '"><i class="align-middle me-2 fab fa-fw fa-dropbox"></i>Mua số</button>',
    );
}

echo json_encode(array('data' => $data));
?>
