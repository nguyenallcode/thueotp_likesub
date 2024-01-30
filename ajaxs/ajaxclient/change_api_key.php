<?php
require_once __DIR__.'/../../config/config.php';
require_once __DIR__.'/../../config/function.php';

function generateApiKey() {
    return random('qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM123456789', 32);
}
$newApiKey = generateApiKey();


$result =  $NguyenAll->update("users", [
    'api_key' => $newApiKey,
], " `id` = '".$getUser['id']."' ");

if ($result) {
    $response = ['status' => 'success', 'apiKey' => $newApiKey];
} else {
    $response = ['status' => 'error', 'msg' => 'Không thể cập nhật API KEY'];
}

// Trả về kết quả dưới dạng JSON
header('Content-Type: application/json');
echo json_encode($response);
?>
