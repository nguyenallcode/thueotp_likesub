<?php
require_once("../config/config.php");
require_once("../config/function.php");

function makeRequest($url) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);
    return $response;
}
$url1 = "/ajaxs/ajaxtables/list_get_otp.php";
$response1 = makeRequest($url1);


$api_key = isset($_GET['api_key']) ? $_GET['api_key'] : null;
$request_id = isset($_GET['request_id']) ? $_GET['request_id'] : null;
$api_key = $NguyenAll->get_row("SELECT * FROM `users` WHERE `api_key` = '$api_key'");
if (empty($api_key)) {
    $response = [
        'status_code' => 401,
        'success' => false,
        'message' => 'API KEY không hợp lệ.'
    ];
    header('Content-Type: application/json');
    echo json_encode($response);
    die();
}
// 401 | API KEY không hợp lệ
// 3 | Request_id không đúng
// 0 | Thành công
// 1 | Đang chờ mã
// 2 | Hết hạn, hoàn tiền
// 4 | Lỗi

$request_id_row = $NguyenAll->get_row("SELECT * FROM `history_buy` WHERE `id_cart` = '$request_id' ");
if (empty($request_id_row)) {
    $response = [
        'status_code' => 3,
        'success' => false,
        'message' => 'Request ID không đúng.'
    ];
    header('Content-Type: application/json');
    echo json_encode($response);
    die();
}
    $formatted_network = [
        'request_id' => $request_id_row['id_cart'],
        'sms_code' => $request_id_row['sms_code'],
        'sms_content' => $request_id_row['sms_content']
    ];
    if ($request_id_row['response'] === "0") {
        $response = [
            'status_code' => 0,
            'success' => true,
            'data' => $formatted_network
        ];
        header('Content-Type: application/json');
echo json_encode($response);
die();
    } elseif ($request_id_row['response'] === "1") {
        $response = [
            'status_code' => 1,
            'success' => false,
            'message' => 'Đang chờ mã'
        ];
        header('Content-Type: application/json');
echo json_encode($response);
die();
} elseif ($request_id_row['response'] === "2") {
    $response = [
        'status_code' => 2,
        'success' => false,
        'message' => 'Đã hết hạn, hoàn tiền'
    ];
    header('Content-Type: application/json');
echo json_encode($response);
die();
    } else {
        $response = [
            'status_code' => 4,
            'success' => false,
            'message' => 'Error'
        ];
        header('Content-Type: application/json');
echo json_encode($response);
die();
    }



header('Content-Type: application/json');
echo json_encode($response);
die();
