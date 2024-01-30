<?php
    require_once("../config/config.php");
    require_once("../config/function.php");


// status_code = 200 | Lấy thông tin thành công
// status_code = 401 | Không có APIKEY tương ứng với user
// status_code = 400 | Thông báo thiếu APIKEY


$api_key = isset($_GET['api_key']) ? $_GET['api_key'] : null;

if ($api_key) {
    $sql = "SELECT money FROM users WHERE api_key = '$api_key'";
    $numRows = $NguyenAll->num_rows($sql);

    if ($numRows > 0) {
        // Thực hiện truy vấn để lấy dữ liệu
        $result = $NguyenAll->get_row($sql);
        $money = $result['money'];

        // Trả về kết quả JSON
        $response = [
            'status_code' => 200,
            'success' => true,
            'data' => [
                'money' => $money
            ]
        ];

        header('Content-Type: application/json');
        echo json_encode($response);
    } else {
        // Trả về thông báo nếu không tìm thấy user với api_key tương ứng
        $response = [
            'status_code' => 401,
            'success' => false,
            'message' => 'Không thể lấy thông tin.'
        ];

        header('Content-Type: application/json');
        echo json_encode($response);
    }
} else {
    $response = [
        'status_code' => 400,
        'success' => false,
        'message' => 'API KEY not provided'
    ];

    header('Content-Type: application/json');
    echo json_encode($response);
}


?>








