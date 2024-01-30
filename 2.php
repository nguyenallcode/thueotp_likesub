<?php
    require_once(__DIR__."/config/config.php");
    require_once(__DIR__."/config/function.php");
    
$url = 'https://thuycute.hoangvanlinh.vn/api/service/facebook/sub-vip/list';
$data = [
    'idfb' => '100008318976680',
    'server_order' => 'sv5',
    'amount' => '100',
    'note' => 'your_amount',
];

sendPostRequest($url, $data);
