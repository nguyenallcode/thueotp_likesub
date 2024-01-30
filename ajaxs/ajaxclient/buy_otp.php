<?php

require_once __DIR__.'/../../config/config.php';
require_once __DIR__.'/../../config/function.php';

if (isset($_POST['id'])) {


    $id = check_string($_POST['id']);
    $list_sms = $NguyenAll->get_row("SELECT * FROM `list_sms` WHERE `id` = '$id' AND `baotri` = 'no' ");
    $service = $list_sms['code_api'];


    if (empty($_SESSION['username'])) {
        $data = json_encode([
            'status' => 'error',
            'msg' => 'Vui lòng đăng nhập'
        ]);
        die($data);
    }

    if ($list_sms['amount'] > $getUser['money']) {
        $data = json_encode([
            'status' => 'error',
            'msg' => 'Số dư không đủ'
        ]);
        die($data);
    }

    if (!$list_sms) {
        $data = json_encode([
            'status' => 'error',
            'msg' => 'Dịch vụ này không có sẵn.'
        ]);
        die($data);
    }



// response = 0 | Lấy code thành công
// response = 1 | Chưa có code
// response = 2 | Quá 11 phút, đã hoàn tiền
// response = 3 | Đã bị lỗi


$locmang = isset($_POST['locmang']) ? $_POST['locmang'] : null;
$dausolay = isset($_POST['dausolay']) ? $_POST['dausolay'] : null;
$dausobo = isset($_POST['dausobo']) ? $_POST['dausobo'] : null;

if ($list_sms['name_api'] == 'sim24_cc') {
    $api_sim24cc = $NguyenAll->site('api_sim24cc');

    $operator = !empty($locmang) ? "&operator=$locmang" : "";
    $dausolay = !empty($dausolay) ? "&prefix=$dausolay" : "";
    $dausobo = !empty($dausobo) ? "&no_prefix=$dausobo" : "";
    $urlapi = "https://sim24.cc/api?action=number&service=$service&apikey=$api_sim24cc" . $operator . $dausolay . $dausobo;
$response = file_get_contents($urlapi);
$dataArray = json_decode($response, true);
   if ($response === FALSE) {
    $data = json_encode([
        'status' => 'error',
        'msg' => 'Đã có lỗi từ phía máy chủ!'
    ]);
    die($data);
}
if ($dataArray['ResponseCode'] == 1) {
    $data = json_encode([
        'status' => 'error',
        'msg' => 'Không có số, hãy thử lại!'
    ]);
    die($data);
}
if ($dataArray['ResponseCode'] == 2) {
    $data = json_encode([
        'status' => 'error',
        'msg' => 'Dịch vụ không hợp lệ'
    ]);
    die($data);
}
if ($dataArray['ResponseCode'] == 4) {
    $data = json_encode([
        'status' => 'error',
        'msg' => 'Mua số quá nhiều, hãy chờ một lát'
    ]);
    die($data);
}
$id = $dataArray['Result']['id'];
$number = $dataArray['Result']['number'];
$price = $dataArray['Result']['price'];
if (isset($dataArray['ResponseCode']) && $dataArray['ResponseCode'] == 0) {
    $NguyenAll->tru("users", "money", $list_sms['amount'], " `username` = '".$getUser['username']."' ");
    $NguyenAll->insert("history_buy", [
        'username'          => $getUser['username'],
        'id_list_sms'       => $list_sms['id'],
        'id_api'            => $id,
        'id_cart'            => random('qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM', 32),
        'name_api'          => 'sim24_cc',
        'response'          => '1',
        'order_by'          => 'Web',
        'number'            => $number,
        'code_api'          => $list_sms['code_api'],
        'amount'            => $list_sms['amount'],
        'amount_api'        => $price,
        'star'              => gettime(),
        'star_time'         => time()
    ]);

    $data = json_encode([
        'status' => 'success',
        'msg' => 'Mua thành công.'
    ]);
    die($data);
}

    
} elseif ($list_sms['name_api'] == 'viotp_com') {
    $api_viotp_com = rawurlencode($NguyenAll->site('api_viotp_com'));
function addLeadingZeros($input) {
    $numbers = explode('|', $input);
    $paddedNumbers = array_map(function($number) {
        return str_pad($number, 3, '0', STR_PAD_LEFT);
    }, $numbers);
    return implode('|', $paddedNumbers);
}
$network = !empty($locmang) ? "&network=" . strtoupper(addLeadingZeros($locmang)) : "";
$prefix = !empty($dausolay) ? "&prefix=" . addLeadingZeros($dausolay) : "";
$exceptPrefix = !empty($dausobo) ? "&exceptPrefix=" . addLeadingZeros($dausobo) : "";
$urlapi = "https://api.viotp.com/request/getv2?token=$api_viotp_com&serviceId=$service" . $network . $prefix . $exceptPrefix;

    // $NguyenAll->insert("logs", [
    //     'username'  => '',
    //     'ip'        => myip(),
    //     'content'   => $urlapi,
    //     'createdate'=> gettime(),
    //     'time'      => time()
    // ]);


$response = file_get_contents($urlapi);
$dataArray = json_decode($response, true);
   if ($response === FALSE) {
    $data = json_encode([
        'status' => 'error',
        'msg' => 'Đã có lỗi từ phía máy chủ!'
    ]);
    die($data);
}
if ($dataArray['status_code'] == '-3') {
    $data = json_encode([
        'status' => 'error',
        'msg' => 'Không có số, hãy thử lại!'
    ]);
    die($data);
}
if ($dataArray['status_code'] == 429) {
    $data = json_encode([
        'status' => 'error',
        'msg' => 'Limit exceeded, tối đa $ số chờ tin nhắn'
    ]);
    die($data);
}
if ($dataArray['status_code'] == 401) {
    $data = json_encode([
        'status' => 'error',
        'msg' => 'Lỗi xác thực'
    ]);
    die($data);
}
if ($dataArray['status_code'] == '-2') {
    $data = json_encode([
        'status' => 'error',
        'msg' => 'Đã có lỗi, liên hệ Admin'
    ]);
    die($data);
}
if ($dataArray['status_code'] == '-1') {
    $data = json_encode([
        'status' => 'error',
        'msg' => $dataArray['message']
    ]);
    die($data);
}

if ($dataArray['status_code'] == '-4') {
    $data = json_encode([
        'status' => 'error',
        'msg' => 'Ứng dụng không tồn tại hoặc đang tạm ngưng'
    ]);
    die($data);
}
$id = $dataArray['data']['request_id'];
$number = $dataArray['data']['re_phone_number'];
if (isset($dataArray['status_code']) && $dataArray['status_code'] == 200) {
    $NguyenAll->cong("users", "used_money", $list_sms['amount'], " `username` = '".$getUser['username']."' ");
    $NguyenAll->tru("users", "money", $list_sms['amount'], " `username` = '".$getUser['username']."' ");
    $NguyenAll->insert("history_buy", [
        'username'          => $getUser['username'],
        'id_list_sms'       => $list_sms['id'],
        'id_api'            => $id,
        'id_cart'            => random('qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM', 32),
        'name_api'          => 'viotp_com',
        'response'          => '1',
        'number'            => $number,
        'code_api'          => $list_sms['code_api'],
        'amount'            => $list_sms['amount'],
        'amount_api'        => '0',
        'star'              => gettime(),
        'star_time'         => time()
    ]);
    $data = json_encode([
        'status' => 'success',
        'msg' => 'Mua thành công.'
    ]);
    die($data);
}

} else {
    $data = json_encode([
        'status' => 'error',
        'msg' => 'Đã có lỗi nào đó, hãy liên hệ Admin'
    ]);
    die($data);
}


} else {
    $data = json_encode([
        'status' => 'error',
        'msg' => 'Đã có lỗi xảy ra.'
    ]);
    die($data);
}
