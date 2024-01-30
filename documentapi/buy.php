<?php
require_once("../config/config.php");
require_once("../config/function.php");

$api_key = isset($_GET['api_key']) ? $_GET['api_key'] : null;
$service_id = isset($_GET['service_id']) ? $_GET['service_id'] : null;
$locmang = isset($_GET['network']) ? $_GET['network'] : null;
$dausolay = isset($_GET['prefix']) ? $_GET['prefix'] : null;
$dausobo = isset($_GET['exceptPrefix']) ? $_GET['exceptPrefix'] : null;

// 200 | Thành công
// 401 | API KEY không đúng
// 1 | Số dư không đủ
// 2 | Không có số
// 3 | Dịch vụ không hợp lệ
// 4 | Số quá nhiều, vui lòng đợi
// 5 | Đã có lỗi từ sever


    $user = $NguyenAll->get_row("SELECT * FROM `users` WHERE `api_key` = '$api_key'");
    if (empty($user)) {
        $response = [
            'status_code' => 401,
            'success' => false,
            'message' => 'API KEY không hợp lệ.'
        ];
        header('Content-Type: application/json');
        echo json_encode($response);
        die();
    }
    $list_sms = $NguyenAll->get_row("SELECT * FROM `list_sms` WHERE `id` = '$service_id' AND `baotri` = 'no' ");

    if (empty($list_sms)) {
        $response = [
            'status_code' => 3,
            'success' => false,
            'message' => 'Dịch vụ không có sẵn.'
        ];
        header('Content-Type: application/json');
        echo json_encode($response);
        die();
    }
    if ($list_sms['amount'] > $user['money']) {
        $response = [
            'status_code' => 1,
            'success' => false,
            'message' => 'Số dư không đủ.'
        ];
        header('Content-Type: application/json');
        echo json_encode($response);
        die();
    }

    if ($list_sms['name_api'] == 'sim24_cc') {
        $api_sim24cc = $NguyenAll->site('api_sim24cc');
        $operator = !empty($locmang) ? "&operator=$locmang" : "";
        $dausolay = !empty($dausolay) ? "&prefix=$dausolay" : "";
        $dausobo = !empty($dausobo) ? "&no_prefix=$dausobo" : "";
        $urlapi = "https://sim24.cc/api?action=number&service={$list_sms['code_api']}&apikey=$api_sim24cc$operator$dausolay$dausobo";
    $response = file_get_contents($urlapi);
    $dataArray = json_decode($response, true);
       if ($response === FALSE) {
        $response = [
            'success' => false,
            'message' => 'Đã có lỗi từ sever, hãy liên hệ Admin.'
        ];
    }
    if ($dataArray['ResponseCode'] == 1) {
        $response = [
            'status_code' => 2,
            'success' => false,
            'message' => 'Không có số, hãy thử lại.'
        ];
    }
    if ($dataArray['ResponseCode'] == 2) {
        $response = [
            'status_code' => 3,
            'success' => false,
            'message' => 'Dịch vụ không hợp lệ.'
        ];
    }
    if ($dataArray['ResponseCode'] == 4) {
        $response = [
            'status_code' => 4,
            'success' => false,
            'message' => 'Số quá nhiều, vui lòng đợi.'
        ];
    }

    if (isset($dataArray['ResponseCode']) && $dataArray['ResponseCode'] == 0) {
        $id = $dataArray['Result']['id'];
        $number = $dataArray['Result']['number'];
        $price = $dataArray['Result']['price'];
        $NguyenAll->tru("users", "money", $list_sms['amount'], " `username` = '".$getUser['username']."' ");
        $NguyenAll->insert("history_buy", [
            'username'          => $getUser['username'],
            'id_list_sms'       => $list_sms['id'],
            'id_api'            => $id,
            'id_cart'            => random('qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM', 32),
            'name_api'          => 'sim24_cc',
            'response'          => '1',
            'number'            => $number,
            'code_api'          => $list_sms['code_api'],
            'amount'            => $list_sms['amount'],
            'amount_api'        => $price,
            'star'              => gettime(),
            'star_time'         => time()
        ]);
    
        $transactionDetails = [];
        $transactionDetails[] = [
            'service_id'            => $service_id,
            'request_id'    => random('qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM', 32),
            'number'        => $number,
            'service'        => $list_sms['name'],
            'price'         => $list_sms['amount'],
            'start'         => gettime(),
        ];
        $response = [
            'status_code'       => 200,
            'success'           => true,
            'data'              => $transactionDetails
        ];
    }
    
        
    } elseif ($list_sms['name_api'] == 'viotp_com') {
        $api_viotp_com = rawurlencode($NguyenAll->site('api_viotp_com'));
    
        $network = !empty($locmang) ? "&network=" . strtoupper($locmang) : "";
        $prefix = !empty($dausolay) ? "&prefix=0$dausolay" : "";
        $exceptPrefix = !empty($dausobo) ? "&exceptPrefix=0$dausobo" : "";
        $urlapi = "https://api.viotp.com/request/getv2?token=$api_viotp_com&serviceId={$list_sms['code_api']}" . $network . $prefix . $exceptPrefix;
    
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
        $response = [
            'success' => false,
            'message' => 'Đã có lỗi từ sever'
        ];
    }
    if ($dataArray['status_code'] == '-3') {
        $response = [
            'status_code' => 2,
            'success' => false,
            'message' => 'Không có số, hãy thử lại.'
        ];
    }
    if ($dataArray['status_code'] == 429) {
        $response = [
            'status_code' => 4,
            'success' => false,
            'message' => 'Số quá nhiều, vui lòng đợi.'
        ];
    }
    if ($dataArray['status_code'] == '-2') {
        $response = [
            'status_code' => 5,
            'success' => false,
            'message' => 'Liên hệ Admin để xử lý.'
        ];
    }
    if ($dataArray['status_code'] == '-1') {
        $response = [
            'status_code' => 5,
            'success' => false,
            'message' => $dataArray['message']
        ];
    }
    if ($dataArray['status_code'] == '-4') {
        $response = [
            'status_code' => 5,
            'success' => false,
            'message' => 'Không có số, hãy thử lại.'
        ];
    }

    if (isset($dataArray['status_code']) && $dataArray['status_code'] == 200) {
        $id = $dataArray['data']['request_id'];
        $number = $dataArray['data']['re_phone_number'];
        $NguyenAll->cong("users", "used_money", $list_sms['amount'], " `username` = '".$getUser['username']."' ");
        $NguyenAll->tru("users", "money", $list_sms['amount'], " `username` = '".$getUser['username']."' ");
        $NguyenAll->insert("history_buy", [
            'username'          => $getUser['username'],
            'id_list_sms'       => $list_sms['id'],
            'id_api'            => $id,
            'id_cart'            => random('qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM', 32),
            'name_api'          => 'viotp_com',
            'response'          => '1',
            'order_by'          => 'API',
            'number'            => $number,
            'code_api'          => $list_sms['code_api'],
            'amount'            => $list_sms['amount'],
            'amount_api'        => '0',
            'star'              => gettime(),
            'star_time'         => time()
        ]);
        $transactionDetails = [];
        $transactionDetails[] = [
            'service_id'            => $service_id,
            'request_id'    => random('qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM', 32),
            'number'        => $number,
            'service'        => $list_sms['name'],
            'price'         => $list_sms['amount'],
            'start'         => gettime(),
        ];
        $response = [
            'status_code'       => 200,
            'success'           => true,
            'data'              => $transactionDetails
        ];
    }
    } else {
        $response = [
            'status_code' => 5,
            'success' => false,
            'message' => 'Đã có lỗi.'
        ];
    }  

    header('Content-Type: application/json');
    echo json_encode($response);
    die();
?>
