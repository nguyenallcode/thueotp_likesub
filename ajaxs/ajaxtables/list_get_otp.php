<?php
require_once("../../config/config.php");
require_once("../../config/function.php");

header('Content-Type: application/json');

// response = 0 | Lấy code thành công
// response = 1 | Chưa có code
// response = 2 | Quá 10 phút, đã hoàn tiền
// response = 3 | Đã bị lỗi


$roleFilter = "AND `response` = 1";
if (isset($_GET['typecheck'])) {
    $check = $_GET['typecheck'];
    switch ($check) {
        case 'htr_my':
            $roleFilter = "AND `response` = 0 OR `response` = 2";
            break;
        default:
            $roleFilter = "AND `response` = 1";
            break;
    }
}
$list_sms = $NguyenAll->get_list("SELECT * FROM `history_buy` WHERE `username` = '".$getUser['username']."' $roleFilter ORDER BY id DESC");
$data = array();
foreach ($list_sms as $list) {
$rowname = $NguyenAll->get_row("SELECT * FROM `list_sms`  WHERE `id` = '".$list['id_list_sms']."'");


// Bắt đầu sự kiện API sim24_cc
if ($list['response'] == 1 && $list['name_api'] == 'sim24_cc') {
    $api_sim24cc = $NguyenAll->site('api_sim24cc');
    $orderapi = "https://sim24.cc/api?action=code&id=" . $list['id_api'] . "&apikey=" . $api_sim24cc;
    $response = file_get_contents($orderapi);
    $dataArray = json_decode($response, true);
    if ($response === false) {
        die('Không thể lấy dữ liệu từ URL.');
    }
    // Xử lý hoàn tiền nếu quá 10 phút
    if (($list['star_time'] + 600) < time() && $list['response'] != '2') {
        $NguyenAll->update("history_buy", array(
            'end'               => gettime(),
            'end_time'          => time(),
            'sms_code'       => '',
            'response'       => '2',
            'sms_content'   => ''
        ), " `id` = '".$list['id']."' ");

        $NguyenAll->cong("users", "money", $list['amount'], " `username` = '".$getUser['username']."' ");
    }
    // Xử lý thành công
if (isset($dataArray['ResponseCode']) && $dataArray['ResponseCode'] == 0) {
    $id = $dataArray['Result']['id'];
    $SMS = $dataArray['Result']['SMS'];
    $otp = $dataArray['Result']['otp'];
    $NguyenAll->cong("users", "used_money", $list['amount'], " `username` = '".$getUser['username']."' ");

    $NguyenAll->insert("dongtien", array(
       'sotientruoc'   => $getUser['money'],
       'sotienthaydoi' => $list['amount'],
       'sotiensau'     => $getUser['money'] - $list['amount'],
       'thoigian'      => gettime(),
       'noidung'       => 'Thuê thành công 1 SMS '.$rowname['name'].' - ID: '.$list['id_cart'].'',
       'username'      => $getUser['username']
   ));
    $NguyenAll->update("history_buy", array(
        'end'               => gettime(),
        'end_time'          => time(),
        'sms_code'       => $otp,
        'response'       => '0',
        'sms_content'   => $SMS
    ), " `id` = '".$list['id']."' ");
}
}
// Kết thúc sự kiện API sim24_cc



// Bắt đầu sự kiện API viotp
if ($list['response'] == 1 && $list['name_api'] == 'viotp_com') {
    $api_viotp_com = $NguyenAll->site('api_viotp_com');
    $orderapi = "https://api.viotp.com/session/getv2?requestId=" . $list['id_api'] . "&token=$api_viotp_com";
    $response = file_get_contents($orderapi);
    $dataArray = json_decode($response, true);

    $id = $dataArray['data']['ID'];
    $SMS = $dataArray['data']['SmsContent'];
    $otp = $dataArray['data']['Code'];
    $price = $dataArray['data']['Price'];
    $checkstatusapi = $dataArray['data']['Status'];
    if ($response === false) {
        die('Không thể lấy dữ liệu từ URL.');
    }

    $NguyenAll->update("history_buy", array(
        'amount_api'        => $price
    ), " `id` = '".$list['id']."' ");
    // Xử lý hoàn tiền nếu quá 10 phút
    if (($list['star_time'] + 600) < time() && $list['response'] != '2') {

        $NguyenAll->update("history_buy", array(
            'end'               => gettime(),
            'end_time'          => time(),
            'sms_code'       => '',
            'response'       => '2',
            'amount_api'        => $price,
            'sms_content'   => ''
        ), " `id` = '".$list['id']."' ");

        $NguyenAll->tru("users", "used_money", $list['amount'], " `username` = '".$getUser['username']."' ");
        $NguyenAll->cong("users", "money", $list['amount'], " `username` = '".$getUser['username']."' ");
    }
    // Xử lý thành công
if (isset($checkstatusapi) && $checkstatusapi == 1) {
    $NguyenAll->insert("dongtien", array(
       'sotientruoc'   => $getUser['money'],
       'sotienthaydoi' => $list['amount'],
       'sotiensau'     => $getUser['money'] - $list['amount'],
       'thoigian'      => gettime(),
       'noidung'       => 'Thuê thành công 1 SMS '.$rowname['name'].' - ID: '.$list['id_cart'].'',
       'username'      => $getUser['username']
   ));
    $NguyenAll->update("history_buy", array(
        'end'               => gettime(),
        'end_time'          => time(),
        'sms_code'       => $otp,
        'response'       => '0',
        'amount_api'        => $price,
        'sms_content'   => $SMS
    ), " `id` = '".$list['id']."' ");
}
}
// Kết thúc sự kiện API viotp




if (!function_exists('getStatusText')) {
    function getStatusText($status) {
        if ($status === "0") {
            return '<b style="color:green;">Thành công</b>';
        } elseif ($status === "1") {
            return '<b style="color:blue;">Đang chờ OTP</b>';
        } elseif ($status === "2") {
            return '<b style="color:#d1b835;">Hoàn tiền</b>';
        } else {
            return '<span style="color: gray;">Unknown</span>';
        }
    }
}

    $data[] = array(
        'serveive' => '<img onerror="imgError(this)" src="' . $rowname['icon'] . '" width="30" height="30" class="me-2" alt="Icon">' . $rowname['name'],
        'number' => '<a href="javascript:void(0);" onclick="copyToClipboard(\'' . $list['number'] . '\')">' . $list['number'] . '</a>',
        'amount' => format_cash($list['amount']) . ' đ',
        'timeremaining' => '' . timeAgo($list['star_time']) . '',
        'action' => getStatusText($list['response']),
        'sms_code' => ' <a href="javascript:void(0);" onclick="copyToClipboard(\'' . $list['sms_code'] . '\')">' . $list['sms_code'] . '</a>',
        'sms_content' => ''. $list['sms_content'] .''
    );
}

echo json_encode(array('data' => $data));
?>
