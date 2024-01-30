<?php
require_once("../config/config.php");
require_once("../config/function.php");

$api_key = isset($_GET['api_key']) ? $_GET['api_key'] : null;
// status_code = 200 | Lấy thông tin thành công
// status_code = 401 | Không có APIKEY tương ứng với user
// status_code = 400 | Thông báo thiếu APIKEY
if ($api_key) {
    $user = $NguyenAll->get_row("SELECT * FROM `users` WHERE `api_key` = '$api_key'");

    if ($user) {
        $networks = $NguyenAll->get_list("SELECT `id`, `name`, `amount` FROM `list_sms` WHERE `baotri` = 'no' ORDER BY `id` ");
        $formatted_networks = [];
        foreach ($networks as $network) {
            $formatted_network = [
                'service_id' => $network['id'],
                'name' => $network['name'],
                'price' => $network['amount']
            ];
            $formatted_networks[] = $formatted_network;
        }
        $response = [
            'status_code' => 200,
            'success' => true,
            'data' => $formatted_networks
        ];
    } else {
        $response = [
            'status_code' => 401,
            'success' => false,
            'message' => 'Không thể lấy danh sách dịch vỵ.'
        ];
    }
} else {
    $response = [
        'status_code' => 400,
        'success' => false,
        'message' => 'API KEY not provided'
    ];
}

header('Content-Type: application/json');
echo json_encode($response);
?>
