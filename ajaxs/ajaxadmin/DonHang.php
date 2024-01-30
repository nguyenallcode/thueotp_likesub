<?php
require_once("../../config/config.php");
require_once("../../config/function.php");

header('Content-Type: application/json');

if(isset($_GET['type']))
{

    $type = ''; 
    if($_GET['type'] == 'full')
    {
        $type = "";
    }
    if($_GET['type'] == 'success')
    {
        $type = "WHERE `response` = '0'";
    }
	if($_GET['type'] == 'refund')
    {
        $type = "WHERE `response` = '2'";
    }
}
else
{
    $type = '';
}

$row = $NguyenAll->get_list("SELECT * FROM `history_buy` $type ORDER BY id DESC");
$data = array();
$i = 1;
foreach ($row as $rows) {
    $getName = $NguyenAll->get_row("SELECT * FROM `list_sms` WHERE `id` = '".$rows['id_list_sms']."' ");
    $data[] = array(
        'id' => $i++,
        'id_cart' => '<span class="toggle-cart" data-hidden="true" data-original-text="' . $rows['id_cart'] . '">' . substr($rows['id_cart'], 0, 4) . '...</span>',
        'username' => '' . $rows['username'] . '',
        'name_api' => '' . $rows['name_api'] . '',
        'service' => '' . $getName['name'] . '',
        'number' => '' . $rows['number'] . '',
        'order_by' => '' . $rows['order_by'] . '',
        'response' => '' . $rows['response'] . '',
        'sms_code' => '' . $rows['sms_code'] . '',
        'sms_content' => '<span class="toggle-cart" data-hidden="true" data-original-text="' . $rows['sms_content'] . '">' . substr($rows['sms_content'], 0, 6) . '...</span>',
        'amount' => format_cash($rows['amount']) . ' đ',
        'profit' => format_cash($rows['amount'] - $rows['amount_api']) . ' đ',
        'start' => '' . $rows['star'] . '',
        'end' => '' . $rows['end'] . '',
    );
}

echo json_encode(array('data' => $data));
?>
