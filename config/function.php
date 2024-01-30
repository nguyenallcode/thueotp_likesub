<?php
$NguyenAll = new NguyenAll;
require_once(__DIR__ . '/../vendor/autoload.php');
require_once(__DIR__ . '/../config/config.php');

function BASE_URL($url)
{
    $a = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://" . $_SERVER["HTTP_HOST"];
    if ($a == 'http://localhost:8080/') {
        $a = 'http://localhost:8080/';
    }
    return $a . '/' . $url;
}

$api_subgiare = $NguyenAll->site('api_subgiare');
function sendPostRequest($url, $data) {
    global $api_subgiare;
    $options = [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => http_build_query($data),
        CURLOPT_HTTPHEADER => [
            'Accept: application/json',
            'Content-Type: application/x-www-form-urlencoded',
            "Api-token: $api_subgiare",
        ],
    ];
    $ch = curl_init();
    curl_setopt_array($ch, $options);
    $response = curl_exec($ch);
    if (curl_errno($ch)) {
        echo 'Curl error: ' . curl_error($ch);
    } else {
        echo $response;
    }
    curl_close($ch);
}



function getCurURL()
{
    if (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on") {
        $pageURL = "https://";
    } else {
      $pageURL = 'http://';
    }
    if (isset($_SERVER["SERVER_PORT"]) && $_SERVER["SERVER_PORT"] != "80") {
        $pageURL .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . $_SERVER["REQUEST_URI"];
    } else {
        $pageURL .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
    }
    return $pageURL;
}
function get1coin($a = 172) {
    $b = 10000 / $a;
    return $b;
}

function get_website_name($url) {
    $url = str_replace("www.", "", $url);
    $url = parse_url($url, PHP_URL_HOST);
    $url = explode(".", $url);
    $count = count($url);
    $website_name = $url[$count-2] . "." . $url[$count-1];
    return $website_name;
}
function format_currency($amount)
{
    if (isset($_SESSION['lang'])) {
        if ($_SESSION['lang'] == 'en') {
            return '$' . number_format($amount / 23000, 2, '.', '');
        } else {
            return format_cash($amount, 'đ');
        }
    } else {
        return format_cash($amount, 'đ');
    }
}

function getUser($username, $row)
{
    global $NguyenAll;
    return $NguyenAll->get_row("SELECT * FROM `users` WHERE `username` = '$username' ")[$row];
}
function active_navmenu($path)
{
    foreach ($path as $row) {
        if ($row == substr($_SERVER["SCRIPT_NAME"], strrpos($_SERVER["SCRIPT_NAME"], "/") + 1)) {
            return 'active';
        }
    }
    return '';
}
function active_navmenumobile($path)
{
    foreach ($path as $row) {
        if ($row == substr($_SERVER["SCRIPT_NAME"], strrpos($_SERVER["SCRIPT_NAME"], "/") + 1)) {
            return 'is-active';
        }
    }
    return '';
}
function active_sidebar($path)
{
    foreach ($path as $row) {
        if ($row == substr($_SERVER["SCRIPT_NAME"], strrpos($_SERVER["SCRIPT_NAME"], "/") + 1)) {
            return 'active';
        }
    }
    return '';
}
function menuopen_sidebar($path)
{
    foreach ($path as $row) {
        if ($row == substr($_SERVER["SCRIPT_NAME"], strrpos($_SERVER["SCRIPT_NAME"], "/") + 1)) {
            return 'menu-open';
        }
    }
    return '';
}
function display_online($time)
{
    if (time() - $time <= 500) {
        return '<span class="badge badge-success">Online</span>';
    } else {
        return '<span class="badge badge-danger">Offline</span>';
    }
}
function insert_options($name, $value)
{
    global $NguyenAll;
    if (!$NguyenAll->get_row("SELECT * FROM `options` WHERE `name` = '$name' ")) {
        $NguyenAll->insert("options", [
            'name'  => $name,
            'value' => $value
        ]);
    }
}
function format_date($time)
{
    return date("H:i:s d/m/Y", $time);
}
function card24h($api_card, $loaithe, $menhgia, $seri, $pin, $code)
{
    $callback = BASE_URL('api/card.php');
    $url_api = 'https://card.robloxvietnam.com/';
    $json = json_decode(curl_get($url_api . 'api/card-auto.php?auto=true&type=' . $loaithe . '&menhgia=' . $menhgia . '&seri=' . $seri . '&pin=' . $pin . '&APIKey=' . $api_card . '&callback=' . $callback . '&content=' . $code), true);
    return $json;
}
// Check mã giảm giá
function checkCoupon($coupon, $user_id)
{
    global $NguyenAll;
    // check coupon có tồn tại hay không
    if (
        $coupon = $NguyenAll->get_row("SELECT * FROM `coupons` WHERE `code` = '".check_string($coupon)."' "))
         {
        // chek số lượng còn hay không
        if ($coupon['used'] < $coupon['amount']) 
        {
            // check đã dùng hay chưa
        if (!$NguyenAll->get_row("SELECT * FROM `coupon_used` WHERE `coupon_id` = '".$coupon['id']."' AND `user_id` = '".$user_id."' ")) {
            return $coupon['discount'];
            }
            return false;
        }
        return false;
    }
    return false;
}
function convert_vi_to_en($str) {
      $str = preg_replace("/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/", "a", $str);
      $str = preg_replace("/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/", "e", $str);
      $str = preg_replace("/(ì|í|ị|ỉ|ĩ)/", "i", $str);
      $str = preg_replace("/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/", "o", $str);
      $str = preg_replace("/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/", "u", $str);
      $str = preg_replace("/(ỳ|ý|ỵ|ỷ|ỹ)/", "y", $str);
      $str = preg_replace("/(đ)/", "d", $str);
      $str = preg_replace("/(À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ)/", "A", $str);
      $str = preg_replace("/(È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ)/", "E", $str);
      $str = preg_replace("/(Ì|Í|Ị|Ỉ|Ĩ)/", "I", $str);
      $str = preg_replace("/(Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ)/", "O", $str);
      $str = preg_replace("/(Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ)/", "U", $str);
      $str = preg_replace("/(Ỳ|Ý|Ỵ|Ỷ|Ỹ)/", "Y", $str);
      $str = preg_replace("/(Đ)/", "D", $str);
      $str = str_replace(" ", "-", str_replace("&*#39;","",$str));
      $str = strtolower($str);
      return $str;
  }


/* CONFIG RÚT TIỀN */
function listbank()
{
    $html = '
  
    <option value="THESIEURE">Ví THESIEURE.COM</option>
    <option value="MOMO">Ví điện tử MOMO</option>
    <option value="Zalo Pay">Ví điện tử Zalo Pay</option>
    <option value="VietinBank">Ngân hàng TMCP Công thương Việt Nam VietinBank</option>
    <option value="Vietcombank">Ngân hàng TMCP Ngoại Thương Việt Nam Vietcombank</option>
    <option value="BIDV">Ngân hàng TMCP Đầu tư và Phát triển Việt Nam BIDV</option>
    <option value="Agribank">Ngân hàng Nông nghiệp và Phát triển Nông thôn Việt Nam Agribank</option>
    <option value="OCB">Ngân hàng TMCP Phương Đông OCB</option>
    <option value="MBBank">Ngân hàng TMCP Quân đội MBBank</option>
    <option value="Techcombank">Ngân hàng TMCP Kỹ thương Việt Nam Techcombank</option>
    <option value="ACB">Ngân hàng TMCP Á Châu ACB</option>
    <option value="VPBank">Ngân hàng TMCP Việt Nam Thịnh Vượng VPBank</option>
    <option value="TPBank">Ngân hàng TMCP Tiên Phong TPBank</option>
    <option value="Sacombank">Ngân hàng TMCP Sài Gòn Thương Tín Sacombank</option>
    <option value="HDBank">Ngân hàng TMCP Phát triển Thành phố Hồ Chí Minh HDBank</option>
    <option value="VietCapitalBank">Ngân hàng TMCP Bản Việt VietCapitalBank</option>
    <option value="SCB">Ngân hàng TMCP Sài Gòn SCB</option>
    <option value="VIB">Ngân hàng TMCP Quốc tế Việt Nam VIB</option>
    <option value="SHB">Ngân hàng TMCP Sài Gòn - Hà Nội SHB</option>
    <option value="Eximbank">Ngân hàng TMCP Xuất Nhập khẩu Việt Nam Eximbank</option>
    <option value="MSB">Ngân hàng TMCP Hàng Hải MSB</option>
    <option value="CAKE">TMCP Việt Nam Thịnh Vượng - Ngân hàng số CAKE by VPBank CAKE</option>
    <option value="Ubank">TMCP Việt Nam Thịnh Vượng - Ngân hàng số Ubank by VPBank Ubank</option>
    <option value="SaigonBank">Ngân hàng TMCP Sài Gòn Công Thương SaigonBank</option>
    <option value="BacABank">Ngân hàng TMCP Bắc Á BacABank</option>
    <option value="PVcomBank">Ngân hàng TMCP Đại Chúng Việt Nam PVcomBank</option>
    <option value="Oceanbank">Ngân hàng Thương mại TNHH MTV Đại Dương Oceanbank</option>
    <option value="NCB">Ngân hàng TMCP Quốc Dân NCB</option>
    <option value="ShinhanBank">Ngân hàng TNHH MTV Shinhan Việt Nam ShinhanBank</option>
    <option value="ABBANK">Ngân hàng TMCP An Bình ABBANK</option>
    <option value="VietABank">Ngân hàng TMCP Việt Á VietABank</option>
    <option value="NamABank">Ngân hàng TMCP Nam Á NamABank</option>
    <option value="PGBank">Ngân hàng TMCP Xăng dầu Petrolimex PGBank</option>
    <option value="VietBank">Ngân hàng TMCP Việt Nam Thương Tín VietBank</option>
    <option value="BaoVietBank">Ngân hàng TMCP Bảo Việt BaoVietBank</option>
    <option value="SeABank">Ngân hàng TMCP Đông Nam Á SeABank</option>
    <option value="COOPBANK">Ngân hàng Hợp tác xã Việt Nam COOPBANK</option>
    <option value="LienVietPostBank">Ngân hàng TMCP Bưu Điện Liên Việt LienVietPostBank</option>
    <option value="KienLongBank">Ngân hàng TMCP Kiên Long KienLongBank</option>
    <option value="KBank">Ngân hàng Đại chúng TNHH Kasikornbank KBank</option>
    <option value="GPBank">Ngân hàng Thương mại TNHH MTV Dầu Khí Toàn Cầu GPBank</option>
    <option value="CBBank">Ngân hàng Thương mại TNHH MTV Xây dựng Việt Nam CBBank</option>
    <option value="CIMB">Ngân hàng TNHH MTV CIMB Việt Nam CIMB</option>
    <option value="DBSBank">DBS Bank Ltd - Chi nhánh Thành phố Hồ Chí Minh DBSBank</option>
    <option value="DongABank">Ngân hàng TMCP Đông Á DongABank</option>


    ';
    return $html;
}
function listrut()
{
    $html = '
   <option value="RÚT ROBUX">RÚT ROBUX</option>
    ';
    return $html;
}

function listrutvatpham()
{
    $html = '
  
   <option value="robux">Rút Robux</option>

   <option value="quanhuy">Rút Quân huy</option>

    ';
    return $html;
}
function daily($data)
{
    if ($data == 0) {
        return 'Thành viên';
    } else if ($data == 1) {
        return 'Đại lý';
    }
}
function seller($data)
{
    if ($data == 'chuaban') {
        return 'Chưa bán';
    }
    if ($data == 'dangban') {
        return 'Đang bán';
    }
    if ($data == 'daban') {
        return 'Đã bán';
    } else if ($data == '') {
        return 'Xảy ra lỗi';
    }
}
function veriaccluutru($data)
{
    if ($data == 'verimailpin') {
        return 'Đã Veri PIN + Mail';
    }
    if ($data == 'chuaveri') {
        return 'Chưa Veri Pin + Mail';
    } else if ($data == '') {
        return 'Đang xác thực';
    }
}
function vongquay($data)
{
    if ($data == 'kimcuong') {
        return 'Kim Cương';
    }
    if ($data == 'quanhuy') {
        return 'Quân Huy';
    }
    if ($data == 'money') {
        return 'VNĐ';
    }
    if ($data == 'robux') {
        return 'Robux';
    } else if ($data == '') {
        return 'Robux';
    }
}
function rutvatpham($data)
{
    if ($data == 'kimcuong') {
        return 'Kim cương';
    }
    if ($data == 'quanhuy') {
        return 'Quân Huy';
    }
    if ($data == 'robux') {
        return 'Robux';
    } else if ($data == '') {
        return 'Chưa xác định';
    }
}
function typecongtien($data)
{
    if ($data == 'kimcuong') {
        return 'Kim Cương';
    }
    if ($data == 'quanhuy') {
        return 'Quân Huy';
    }
    if ($data == 'money') {
        return 'Số Dư';
    }
    if ($data == 'robux') {
        return 'Robux';
    }
    if ($data == 'ref_xu') {
        return 'XU';
    } else if ($data == '') {
        return 'Không xác định';
    }
}
function typegifcode($data)
{
    if ($data == 'kimcuong') {
        return 'Kim Cương';
    }
    if ($data == 'quanhuy') {
        return 'Quân Huy';
    }
    if ($data == 'money') {
        return 'VNĐ';
    }
    if ($data == 'robux') {
        return 'Robux';
    }
    if ($data == 'ref_xu') {
        return 'XU';
    } else if ($data == '') {
        return 'Không xác định';
    }
}
function dichapinapthe($data)
{
    if ($data == 'https://trumthe.vn/') {
        return 'TRUMTHE.VN';
    }
    if ($data == 'https://cardvip.vn/') {
        return 'CARDVIP.VN';
    }
    if ($data == 'https://cspay.vn/') {
        return 'CSPAY.VN';
    }
    if ($data == 'https://gachthe1s.com/') {
        return 'GACHTHE1S.COM';
    }
    if ($data == 'https://thesieure.com/') {
        return 'THESIEURE.COM';
    } else if ($data == '') {
        return 'Lỗi!!!';
    }
}
function trathuongvq($data)
{
    if ($data == 'kimcuong') {
        return 'Kim cương';
    }
    if ($data == 'quanhuy') {
        return 'Quân Huy';
    }
    if ($data == 'robux') {
        return 'Robux';
    } else if ($data == '') {
        return 'ERROR';
    }
}
function trangthai($data)
{
    if ($data == 'xuly') {
        return 'Đang xử lý';
    } else if ($data == 'hoantat') {
        return 'Hoàn tất';
    } else if ($data == 'thanhcong') {
        return 'Thành công';
    } else if ($data == 'huy') {
        return 'Hủy';
    } else if ($data == 'thatbai') {
        return 'Thất bại';
    } else {
        return 'Khác';
    }
}
function loaithe($data)
{
    if ($data == 'VIETTEL' || $data == 'viettel') {
        $show = 'https://i.imgur.com/xFePMtd.png';
    } else if ($data == 'VINAPHONE' || $data == 'vinaphone') {
        $show = 'https://i.imgur.com/s9Qq3Fz.png';
    } else if ($data == 'MOBIFONE' || $data == 'mobifone') {
        $show = 'https://i.imgur.com/qQtcWJW.png';
    } else if ($data == 'VNMOBI' || $data == 'vietnamobile') {
        $show = 'https://i.imgur.com/IHm28mq.png';
    } else if ($data == 'ZING' || $data == 'zing') {
        $show = 'https://i.imgur.com/xkd7kQ0.png';
    } else if ($data == 'GARENA' || $data == 'garena') {
        $show = 'https://i.imgur.com/BLkY5qm.png';
    }
    return '<img style="text-align: center;" src="' . $show . '" width="70px" />';
}

function sendCSM($mail_nhan, $ten_nhan, $chu_de, $noi_dung, $bcc)
{
    global $NguyenAll;
    // PHPMailer Modify
    $mail = new PHPMailer();
    $mail->SMTPDebug = 0;
    $mail->Debugoutput = "html";
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = $NguyenAll->site('email'); // GMAIL STMP
    $mail->Password = $NguyenAll->site('pass_email'); // PASS STMP
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;
    $mail->setFrom($NguyenAll->site('email'), $bcc);
    $mail->addAddress($mail_nhan, $ten_nhan);
    $mail->addReplyTo($NguyenAll->site('email'), $bcc);
    $mail->isHTML(true);
    $mail->Subject = $chu_de;
    $mail->Body    = $noi_dung;
    $mail->CharSet = 'UTF-8';
    $send = $mail->send();
    return $send;
}
function parse_order_id($des)
{
    global $NguyenAll;
    $re = '/' . $NguyenAll->site('noidung_naptien') . '\d+/im';
    preg_match_all($re, $des, $matches, PREG_SET_ORDER, 0);
    if (count($matches) == 0)
        return null;
    // Print the entire match result
    $orderCode = $matches[0][0];
    $prefixLength = strlen($NguyenAll->site('noidung_naptien'));
    $orderId = intval(substr($orderCode, $prefixLength));
    return $orderId;
}
date_default_timezone_set('Asia/Ho_Chi_Minh');
function gettime()
{
    return date('Y/m/d H:i:s', time());
}
function check_string($data)
{
    return trim(htmlspecialchars(addslashes($data)));
    //return str_replace(array('<',"'",'>','?','/',"\\",'--','eval(','<php'),array('','','','','','','','',''),htmlspecialchars(addslashes(strip_tags($data))));
}
function compact_number($num) {
    $number = $num / 1000;
    if($number <= 0) {
        return 'Miễn Phí';
    }else {
        return $number.'K';
    }

}
function format_cash($price)
{
    return str_replace(",", ".", number_format($price));
}
function curl_get($url)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $data = curl_exec($ch);

    curl_close($ch);
    return $data;
}
function random($string, $int)
{
    return substr(str_shuffle($string), 0, $int);
}
function pheptru($int1, $int2)
{
    return $int1 - $int2;
}
function phepcong($int1, $int2)
{
    return $int1 + $int2;
}
function phepnhan($int1, $int2)
{
    return $int1 * $int2;
}
function phepchia($int1, $int2)
{
    return $int1 / $int2;
}
function check_img($img)
{
    $filename = $_FILES[$img]['name'];
    $ext = explode(".", $filename);
    $ext = end($ext);

    $valid_ext = array("png", "jpeg", "jpg", "PNG", "JPEG", "JPG", "gif", "GIF");
    if (in_array($ext, $valid_ext)) {
        return true;
    }
}
function msg_success222($text)
{
    return die('<div class="alert alert-success alert-dismissible error-messages"  style="
    color: #000000;
    background-color: #d7f8d7;
    border-color: #f5c6cb;
    position: relative;
    padding: 0.75rem 1.25rem;
    margin-bottom: 1rem;
    border: 2px dashed #ff00f2;
    border-radius: 0.25rem;
    max-width: 400px;
">
    <a href="#" class="close" data-dismiss="alert" aria-label="close"> </a>'.$text.'</div>');
}/*
function msg_error2($text)
{
    return die('<div class="alert alert-danger alert-dismissible error-messages">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>'.$text.'</div>');
}
function msg_warning2($text)
{
    return die('<div class="alert alert-warning alert-dismissible error-messages">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>'.$text.'</div>');
}
function msg_success($text, $url, $time)
{
    return die('<div class="alert alert-success alert-dismissible error-messages">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>'.$text.'</div><script type="text/javascript">setTimeout(function(){ location.href = "'.$url.'" },'.$time.');</script>');
}
function msg_error($text, $url, $time)
{
    return die('<div class="alert alert-danger alert-dismissible error-messages">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>'.$text.'</div><script type="text/javascript">setTimeout(function(){ location.href = "'.$url.'" },'.$time.');</script>');
}
function msg_warning($text, $url, $time)
{
    return die('<div class="alert alert-warning alert-dismissible error-messages">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>'.$text.'</div><script type="text/javascript">setTimeout(function(){ location.href = "'.$url.'" },'.$time.');</script>');
}
*/
function msg_nguyenall_error($text)
{
    return die('<div class="alert alert-danger alert-dismissible" role="alert">
    <div class="alert-icon">
        <i class="far fa-fw fa-bell"></i>
    </div>
    <div class="alert-message">' . $text . '</div>
    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
</div>');
}
function msg_nguyenall_success($text)
{
    return die('<div class="alert alert-success alert-dismissible" role="alert">
    <div class="alert-icon">
        <i class="far fa-fw fa-bell"></i>
    </div>
    <div class="alert-message">' . $text . '</div>
    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
</div>');
}
function msg_nguyenall_warning($text)
{
    return die('<script type="text/javascript">VanillaToasts.create({ type: "warning", positionClass: "topRight", title: "Thông báo", icon: "https://img.upanh.tv/2022/06/10/image5e75734cd2997662.png", text: "' . $text . '", timeout: 5000 });</script>');
}
function msg_nguyenall_info($text)
{
    return die('<script type="text/javascript">VanillaToasts.create({ type: "info", positionClass: "topRight", title: "Thông báo", icon: "https://img.upanh.tv/2022/06/10/imagea07d2afcc1936bd5.png", text: "' . $text . '", timeout: 5000 });</script>');
}
function msg_success2($text)
{
    return die('<script type="text/javascript">cuteToast({ type: "success", message: "' . $text . '", timer: 50000000 });</script>');
}
function msg_error2($text)
{
    return die('<script type="text/javascript">cuteToast({ type: "error", message: "' . $text . '", timer: 5000 });</script>');
}
function msg_warning2($text)
{
    return die('<script type="text/javascript">cuteToast({ type: "warning", message: "' . $text . '", timer: 5000 });</script>');
}
function msg_success($text, $url, $time)
{
    return die('<script type="text/javascript">Swal.fire("Thành Công", "' . $text . '","success");
    setTimeout(function(){ location.href = "' . $url . '" },' . $time . ');</script>');
}
function msg_success1($text)
{
    echo '<script type="text/javascript">Swal.fire("Thành Công", "' . $text . '","success");</script>';
    exit; // Thoát khỏi chương trình PHP
}
function msg_error1($text)
{
    echo '<script type="text/javascript">Swal.fire("Lỗi", "' . $text . '","error");</script>';
    exit; // Thoát khỏi chương trình PHP
}
function msg_error($text, $url, $time)
{
    return die('<script type="text/javascript">Swal.fire("Thất Bại", "' . $text . '","error");
    setTimeout(function(){ location.href = "' . $url . '" },' . $time . ');</script>');
}
function msg_warning($text, $url, $time)
{
    return die('<script type="text/javascript">Swal.fire("Thông Báo", "' . $text . '","warning");
    setTimeout(function(){ location.href = "' . $url . '" },' . $time . ');</script>');
}

function admin_msg_success($text, $url, $time)
{
    return die('<script type="text/javascript">Swal.fire("Thành Công", "' . $text . '","success");
    setTimeout(function(){ location.href = "' . $url . '" },' . $time . ');</script>');
}
function admin_msg_error($text, $url, $time)
{
    return die('<script type="text/javascript">Swal.fire("Thất Bại", "' . $text . '","error");
    setTimeout(function(){ location.href = "' . $url . '" },' . $time . ');</script>');
}
function admin_msg_warning($text, $url, $time)
{
    return die('<script type="text/javascript">Swal.fire("Thông Báo", "' . $text . '","warning");
    setTimeout(function(){ location.href = "' . $url . '" },' . $time . ');</script>');
}
function display_banned($data)
{
    if ($data == 1) {
        $show = '<span class="badge bg-danger">Banned</span>';
    } else if ($data == 0) {
        $show = '<span class="badge bg-success">Active</span>';
    }
    return $show;
}
function display_trangthai_account($data)
{
    if ($data == 'dangban') {
        $show = 'Đang bán';
    }
    
    if ($data == 'daban') {
        $show = 'Đã bán';
    }
    else if ($data == '') {
        $show = 'Không có dữ liệu';
    }
    return $show;
}
function display_chuyenmuc($data)
{
    if ($data == 'SHOW') {
        $show = '<span class="badge bg-success">Hoạt động</span>';
    }
    
    if ($data == 'HIDE') {
        $show = '<span class="badge bg-danger">Tạm đóng</span>';
    }
    else if ($data == '') {
        $show = '<span class="badge bg-danger">ERROR</span>';
    }
    return $show;
}
function display_nganhang($data)
{
    if ($data == 'SHOW') {
        $show = '<span class="badge bg-success">HIỆN</span>';
    }
    
    if ($data == 'HIDE') {
        $show = '<span class="badge bg-danger">ẨN</span>';
    }
    else if ($data == '') {
        $show = '<span class="badge bg-danger">ERROR</span>';
    }
    return $show;
}
function display_robux120h_admin($data)
{
    if ($data == 'cosan') {
        $show = '<span class="badge badge-success">KHO ROBUX CÓ SẴN</span>';
    }
    
    if ($data == 'dattruoc') {
        $show = '<span class="badge badge-info">ĐẶT TRƯỚC ROBUX</span>';
    }
    else if ($data == '') {
        $show = '<span class="badge badge-secondary">KHO ROBUX CÓ SẴN</span>';
    }
    return $show;
}

function ticket_display($data)
{
    if ($data == 'xuly') {
        $show = '<span class="badge badge-info">Đang xử lý</span>';
    }
    if ($data == 'done') {
        $show = '<span class="badge badge-success">Đã trả lời, đóng ticket</span>';
    }
    else if ($data == '') {
        $show = '<span class="badge badge-secondary">Không xác định</span>';
    }
    return $show;
}
function ticket_chude($data)
{
    if ($data == 'vongquay') {
        $show = '<span class="badge badge-danger">Ticket Lỗi MiniGame</span>';
    }
    if ($data == 'robux120h') {
        $show = '<span class="badge badge-danger">Ticket Lỗi Robux 120H</span>';
    }
    if ($data == 'muanick') {
        $show = '<span class="badge badge-danger">Ticket Lỗi Mua Nick</span>';
    }
    if ($data == 'caythue_gamepass') {
        $show = '<span class="badge badge-danger">Ticket lỗi Dịch Vụ, GamePass</span>';
    }
    if ($data == 'naptien') {
        $show = '<span class="badge badge-danger">Ticket lỗi Nạp Tiền</span>';
    }
    else if ($data == '') {
        $show = '<span class="badge badge-secondary">Không xác định</span>';
    }
    return $show;
}
function dautucophieu($data)
{
    if ($data == 'dautugroup') {
        return 'Đầu Tư Group';
    }
    if ($data == 'dauturobux') {
        return 'Đầu Tư Robux';
    }
    else if ($data == '') {
        return 'Lỗi';
    }
}
function displayhistoryrobux($data)
{
    if ($data == 'xuly') {
        return 'Đang xử lý';
    }
    if ($data == 'datiepnhan') {
        return 'Đã tiếp nhận';
    }
    if ($data == 'huy') {
        return 'Hủy';
    }
    if ($data == 'hoantat') {
        return 'Hoàn thành';
    }
    if ($data == 'loi') {
        return 'Lỗi do khách hàng';
    }
    else if ($data == '') {
        return 'KHO ROBUX CÓ SẴN';
    }
}
function display_robux120h_thanhvien($data)
{
    if ($data == 'cosan') {
        return 'KHO ROBUX CÓ SẴN';
    }
    if ($data == 'dattruoc') {
        return 'ĐẶT TRƯỚC ROBUX';
    }
    else if ($data == '') {
        return 'KHO ROBUX CÓ SẴN';
    }
}
function display_ctv($data)
{
    if ($data == 1) {
        return '<span class="badge badge-success">CTV</span>';
    }
    if ($data == 0) {
        return '';
    }
    return NULL;
}
function display_loaithe($data)
{
    if ($data == 0) {
        $show = '<span class="badge badge-warning">Bảo trì</span>';
    } else {
        $show = '<span class="badge badge-success">Hoạt động</span>';
    }
    return $show;
}
function display_ruttien($data)
{
    if ($data == 'xuly') {
        $show = '<span class="badge badge-info">Đang xử lý</span>';
    } else if ($data == 'hoantat') {
        $show = '<span class="badge badge-success">Rút thành công</span>';
    } else if ($data == 'huy') {
        $show = '<span class="badge badge-danger">Hủy</span>';
    }
    return $show;
}

function display_admin($data)
{
    if ($data == 'admin') {
        $show = '<span class="badge badge-success">Admin</span>';
    } else if ($data == '') {
        $show = '<span class="badge badge-info">Thành viên</span>';
    }
    return $show;
}
function display_profilectv($data)
{
    if ($data == '1') {
        $show = '<span class="badge badge-danger">CỘNG TÁC VIÊN</span>';
    } else if ($data == '0') {
        $show = '<span class="badge badge-info">THÀNH VIÊN</span>';
    }
    return $show;
}
function display_adminctv($data)
{
    if ($data == '1') {
        $show = '<span class="badge badge-primary">Có</span>';
    } else if ($data == '0') {
        $show = '<span class="badge badge-warning">Không</span>';
    }
    return $show;
}

function display_napthe($data)
{
    if ($data == 'xuly') {
        $show = '<span class="reload-page" style="background-color: #078485;"><i class="fas fa-redo"></i>Đang xử lý</span>';
    } else if ($data == 'thanhcong') {
        $show = '<span class="reload-page" style="background-color: #2e9917;">Thẻ đúng</span>';
    } else if ($data == 'thatbai') {
        $show = '<span class="reload-page" style="background-color: #ff3535;">Thẻ lỗi</span>';
    }
    return $show;
}
function display_caythuev2($data)
{
    if ($data == 'huy') {
        $show = '<span class="reload-page" style="background-color: #078485;"><i class="fas fa-redo"></i>Chờ xử lý</span>';
    } else if ($data == 'xuly') {
        $show = '<span class="reload-page" style="background-color: #078485;"><i class="fas fa-redo fa-spin"></i>Chờ xử lý</span>';
    } else if ($data == 'dangcay') {
        $show = '<span class="reload-page" style="background-color: #998c17;">Đang cày</span>';
    } else if ($data == 'datiepnhan') {
        $show = '<span class="reload-page" style="background-color: #998c17;">Đã tiếp nhận</span>';
    } else if ($data == 'hoantat') {
        $show = '<span class="reload-page" style="background-color: #2e9917;">Đã hoàn thành</span>';
    } else if ($data == 'loi') {
        $show = '<span class="reload-page" style="background-color: #ff3535;">Lỗi do khách hàng</span>';
    }
    return $show;
}
function display_caythue($data)
{
    if ($data == 'huy') {
        $show = '<span class="py-1 px-1 bg-red-600 text-white rounded">Hủy</span>';
    } else if ($data == 'xuly') {
        $show = '<span class="py-1 px-1 bg-pink-600 text-white rounded">Chờ xử lý</span>';
    } else if ($data == 'dangcay') {
        $show = '<span class="py-1 px-1 bg-orange-600 text-white rounded">Đang cày</span>';
    } else if ($data == 'datiepnhan') {
        $show = '<span class="py-1 px-1 bg-blue-600 text-white rounded">Đã tiếp nhận</span>';
    } else if ($data == 'hoantat') {
        $show = '<span class="py-1 px-1 bg-green-600 text-white rounded">Hoàn tất</span>';
    } else if ($data == 'loi') {
        $show = '<span class="py-1 px-1 bg-red-600 text-white rounded">Lỗi do khách hàng</span>';
    }
    return $show;
}
function display_ruttien_user($data)
{
    if ($data == 'xuly') {
        $show = '<span class="py-1 px-3 bg-blue-600 text-white rounded">Đang xử lý</span>';
    } else if ($data == 'hoantat') {
        $show = '<span class="py-1 px-3 bg-green-600 text-white rounded">Done</span>';
    } else if ($data == 'huy') {
        $show = '<span class="py-1 px-3 bg-red-600 text-white rounded">Hủy</span>';
    }
    return $show;
}
function display_payment($data)
{
    if ($data == 'xuly') {
        $show = '<span style=" color: #00bfff; ">Đang chờ thanh toán</span>';
    } else if ($data == 'hoantat') {
        $show = '<span style=" color: #00ff80; ">Đã thành công</span>';
    } else if ($data == 'huy') {
        $show = '<span style=" color: #ff0000; ">Hủy bỏ</span>';
    }
    return $show;
}

function XoaDauCach($text)
{
    return trim(preg_replace('/\s+/', ' ', $text));
}
function display($data)
{
    if ($data == 'HIDE') {
        $show = '<span class="badge badge-danger">ẨN</span>';
    } else if ($data == 'SHOW') {
        $show = '<span class="badge badge-success">HIỂN THỊ</span>';
    }
    return $show;
}
function status_admin($data)
{
    if ($data == 'xuly') {
        $show = '<span class="badge bg-info">Đang xử lý</span>';
    } else if ($data == 'hoantat') {
        $show = '<span class="badge bg-success">Hoàn tất</span>';
    } else if ($data == 'datiepnhan') {
        $show = '<span class="badge badge-warning">Đã nhận đơn</span>';
    } else if ($data == 'thanhcong') {
        $show = '<span class="badge bg-success">Thành công</span>';
    } else if ($data == 'success') {
        $show = '<span class="badge bg-success">Success</span>';
    } else if ($data == 'nhandon') {
        $show = '<span class="badge badge-warning">Đang cày</span>';
    } else if ($data == 'thatbai') {
        $show = '<span class="badge bg-danger">Thất bại</span>';
    } else if ($data == 'error') {
        $show = '<span class="badge bg-danger">Error</span>';
    } else if ($data == 'loi') {
        $show = '<span class="badge bg-danger">Lỗi, do khách hàng</span>';
    } else if ($data == 'huy') {
        $show = '<span class="badge bg-danger">Hủy</span>';
    } else if ($data == 'dangnap') {
        $show = '<span class="badge badge-warning">Đang đợi nạp</span>';
    } else if ($data == 2) {
        $show = '<span class="badge bg-success">Hoàn tất</span>';
    } else if ($data == 1) {
        $show = '<span class="badge bg-warning">Đang xử lý</span>';
    } else if ($data == 'dangcay') {
        $show = '<span class="badge bg-warning">Đang cày</span>';
    } else {
        $show = '<span class="badge bg-warning">Khác</span>';
    }
    return $show;
}
function status($data)
{
    if ($data == 'xuly') {
        $show = '<span class="badge badge-info">Đang xử lý</span>';
    } else if ($data == 'hoantat') {
        $show = '<span class="badge badge-success">Hoàn tất</span>';
    } else if ($data == 'datiepnhan') {
        $show = '<span class="badge badge-warning">Đã nhận đơn</span>';
    } else if ($data == 'thanhcong') {
        $show = '<span class="badge badge-success">Thành công</span>';
    } else if ($data == 'success') {
        $show = '<span class="badge badge-success">Success</span>';
    } else if ($data == 'nhandon') {
        $show = '<span class="badge badge-warning">Đang cày</span>';
    } else if ($data == 'thatbai') {
        $show = '<span class="badge badge-danger">Thất bại</span>';
    } else if ($data == 'error') {
        $show = '<span class="badge badge-danger">Error</span>';
    } else if ($data == 'loi') {
        $show = '<span class="badge badge-danger">Lỗi, do khách hàng</span>';
    } else if ($data == 'huy') {
        $show = '<span class="badge badge-danger">Hủy</span>';
    } else if ($data == 'dangnap') {
        $show = '<span class="badge badge-warning">Đang đợi nạp</span>';
    } else if ($data == 2) {
        $show = '<span class="badge badge-success">Hoàn tất</span>';
    } else if ($data == 1) {
        $show = '<span class="badge badge-info">Đang xử lý</span>';
    } else if ($data == 'dangcay') {
        $show = '<span class="badge badge-warning">Đang cày</span>';
    } else {
        $show = '<span class="badge badge-warning">Khác</span>';
    }
    return $show;
}
function status_bgdanhmuc($data)
{
    if ($data == 'https://img.upanh.tv/2022/03/21/image5d9d848e5ac2d147.png') {
        $show = '<span class="badge badge-info">Giao diện 1</span>';
    } else if ($data == 'https://img.upanh.tv/2022/03/21/imagecec35f1183333311.png') {
        $show = '<span class="badge badge-success">Giao diện 2</span>';
    } else if ($data == 'https://img.upanh.tv/2022/03/21/image52983138a118b911.png') {
        $show = '<span class="badge badge-success">Giao diện 3</span>';
    } else if ($data == 'https://img.upanh.tv/2022/03/21/image902f6f8f3cbe6f8a.png') {
        $show = '<span class="badge badge-success">Giao diện 4</span>';
    } else if ($data == 'https://img.upanh.tv/2022/03/21/image8ece5154ca0d01b4.png') {
        $show = '<span class="badge badge-danger">Giao diện 5</span>';
    } else if ($data == 'https://img.upanh.tv/2022/03/21/image6a38ff1aedc0b80f.png') {
        $show = '<span class="badge badge-danger">Giao diện 6</span>';
    } else if ($data == 'https://img.upanh.tv/2022/03/21/imagebb7e6d89ea33d816.png') {
        $show = '<span class="badge badge-danger">Giao diện 7</span>';
    }

    return $show;
}
function getHeader()
{
    $headers = array();
    $copy_server = array(
        'CONTENT_TYPE'   => 'Content-Type',
        'CONTENT_LENGTH' => 'Content-Length',
        'CONTENT_MD5'    => 'Content-Md5',
    );
    foreach ($_SERVER as $key => $value) {
        if (substr($key, 0, 5) === 'HTTP_') {
            $key = substr($key, 5);
            if (!isset($copy_server[$key]) || !isset($_SERVER[$key])) {
                $key = str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', $key))));
                $headers[$key] = $value;
            }
        } elseif (isset($copy_server[$key])) {
            $headers[$copy_server[$key]] = $value;
        }
    }
    if (!isset($headers['Authorization'])) {
        if (isset($_SERVER['REDIRECT_HTTP_AUTHORIZATION'])) {
            $headers['Authorization'] = $_SERVER['REDIRECT_HTTP_AUTHORIZATION'];
        } elseif (isset($_SERVER['PHP_AUTH_USER'])) {
            $basic_pass = isset($_SERVER['PHP_AUTH_PW']) ? $_SERVER['PHP_AUTH_PW'] : '';
            $headers['Authorization'] = 'Basic ' . base64_encode($_SERVER['PHP_AUTH_USER'] . ':' . $basic_pass);
        } elseif (isset($_SERVER['PHP_AUTH_DIGEST'])) {
            $headers['Authorization'] = $_SERVER['PHP_AUTH_DIGEST'];
        }
    }
    return $headers;
}

function check_username($data)
{
    if (preg_match('/^[a-zA-Z0-9_-]{6,16}$/', $data, $matches)) {
        return True;
    } else {
        return False;
    }
}
function getIsoTime() {
    $currentTime = time();
    $isoTime = date('Y-m-d\TH:i:s', $currentTime);

    return $isoTime;
}

function check_email($data)
{
    if (preg_match('/^.+@.+$/', $data, $matches)) {
        return True;
    } else {
        return False;
    }
}
function check_phone($data)
{
    if (preg_match('/^\+?(\d.*){3,}$/', $data, $matches)) {
        return True;
    } else {
        return False;
    }
}
function check_url($url)
{
    $c = curl_init();
    curl_setopt($c, CURLOPT_URL, $url);
    curl_setopt($c, CURLOPT_HEADER, 1);
    curl_setopt($c, CURLOPT_NOBODY, 1);
    curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($c, CURLOPT_FRESH_CONNECT, 1);
    if (!curl_exec($c)) {
        return false;
    } else {
        return true;
    }
}


function check_zip($img)
{
    $filename = $_FILES[$img]['name'];
    $ext = explode(".", $filename);
    $ext = end($ext);
    $valid_ext = array("zip", "ZIP");
    if (in_array($ext, $valid_ext)) {
        return true;
    }
}
function TypePassword($string)
{
    global $NguyenAll;
    if ($NguyenAll->site('TypePassword') == 'md5') {
        return md5($string);
    } else if ($NguyenAll->site('TypePassword') == 'sha1') {
        return sha1($string);
    } else if ($NguyenAll->site('TypePassword') == '') {
        return $string;
    } else {
        return md5($string);
    }
}
function phantrang($url, $start, $total, $kmess) {
    $out[] = '<li class="page-item disabled pre-1">';
    $neighbors = 2;
    if ($start >= $total) $start = max(0, $total - (($total % $kmess) == 0 ? $kmess : ($total % $kmess)));
    else $start = max(0, (int)$start - ((int)$start % (int)$kmess));
    $base_link = '<li class="page-item"><a class="page-link" href="' . strtr($url, array('%' => '%%')) . 'page=%d' . '">%s</a></li>';
    $out[] = $start == 0 ? '' : sprintf($base_link, $start / $kmess, '&lt;');
    if ($start > $kmess * $neighbors) $out[] = sprintf($base_link, 1, '1');
    if ($start > $kmess * ($neighbors + 1)) $out[] = '<li class="page-item disabled hidden-xs"><span class="page-link">...</span></li>';
    for ($nCont = $neighbors;$nCont >= 1;$nCont--) if ($start >= $kmess * $nCont) {
        $tmpStart = $start - $kmess * $nCont;
        $out[] = sprintf($base_link, $tmpStart / $kmess + 1, $tmpStart / $kmess + 1);
    }
    $out[] = '<li class="page-item active"><span class="page-link">' . ($start / $kmess + 1) . '</a></li>';
    $tmpMaxPages = (int)(($total - 1) / $kmess) * $kmess;
    for ($nCont = 1;$nCont <= $neighbors;$nCont++) if ($start + $kmess * $nCont <= $tmpMaxPages) {
        $tmpStart = $start + $kmess * $nCont;
        $out[] = sprintf($base_link, $tmpStart / $kmess + 1, $tmpStart / $kmess + 1);
    }
    if ($start + $kmess * ($neighbors + 1) < $tmpMaxPages) $out[] = '<li class="page-item disabled hidden-xs"><span class="page-link">...</span></li>';
    if ($start + $kmess * $neighbors < $tmpMaxPages) $out[] = sprintf($base_link, $tmpMaxPages / $kmess + 1, $tmpMaxPages / $kmess + 1);
    if ($start + $kmess < $total) {
        $display_page = ($start + $kmess) > $total ? $total : ($start / $kmess + 2);
        $out[] = sprintf($base_link, $display_page, '&gt;');
    }
    $out[] = '</span></li>';
    return implode('', $out);
}
function myip()
{
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip_address = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        $ip_address = $_SERVER['REMOTE_ADDR'];
    }
    return $ip_address;
}
function timeAgo($time_ago)
{
    $time_ago   = date("Y-m-d H:i:s", $time_ago);
    $time_ago   = strtotime($time_ago);
    $cur_time   = time();
    $time_elapsed   = $cur_time - $time_ago;
    $seconds    = $time_elapsed;
    $minutes    = round($time_elapsed / 60);
    $hours      = round($time_elapsed / 3600);
    $days       = round($time_elapsed / 86400);
    $weeks      = round($time_elapsed / 604800);
    $months     = round($time_elapsed / 2600640);
    $years      = round($time_elapsed / 31207680);
    // Seconds
    if ($seconds <= 60) {
        return "$seconds giây trước";
    }
    //Minutes
    else if ($minutes <= 60) {
        return "$minutes phút trước";
    }
    //Hours
    else if ($hours <= 24) {
        return "$hours tiếng trước";
    }
    //Days
    else if ($days <= 7) {
        if ($days == 1) {
            return "Hôm qua";
        } else {
            return "$days ngày trước";
        }
    }
    //Weeks
    else if ($weeks <= 4.3) {
        return "$weeks tuần trước";
    }
    //Months
    else if ($months <= 12) {
        return "$months tháng trước";
    }
    //Years
    else {
        return "$years năm trước";
    }
}
function dirToArray($dir)
{

    $result = array();

    $cdir = scandir($dir);
    foreach ($cdir as $key => $value) {
        if (!in_array($value, array(".", ".."))) {
            if (is_dir($dir . DIRECTORY_SEPARATOR . $value)) {
                $result[$value] = dirToArray($dir . DIRECTORY_SEPARATOR . $value);
            } else {
                $result[] = $value;
            }
        }
    }

    return $result;
}
function convertToIdString($title) 
{
    // Loại bỏ các ký tự không phải chữ cái, số, hoặc dấu gạch ngang
    $idString = preg_replace('/[^\w\d-]/', '', $title);

    // Chuyển đổi chữ hoa thành chữ thường
    $idString = strtolower($idString);

    // Thay thế khoảng trắng bằng dấu gạch ngang
    $idString = preg_replace('/\s+/', '-', $idString);

    return $idString;
}


function realFileSize($path)
{
    if (!file_exists($path))
        return false;

    $size = filesize($path);

    if (!($file = fopen($path, 'rb')))
        return false;

    if ($size >= 0) { //Check if it really is a small file (< 2 GB)
        if (fseek($file, 0, SEEK_END) === 0) { //It really is a small file
            fclose($file);
            return $size;
        }
    }

    //Quickly jump the first 2 GB with fseek. After that fseek is not working on 32 bit php (it uses int internally)
    $size = PHP_INT_MAX - 1;
    if (fseek($file, PHP_INT_MAX - 1) !== 0) {
        fclose($file);
        return false;
    }

    $length = 1024 * 1024;
    while (!feof($file)) { //Read the file until end
        $read = fread($file, $length);
        $size = bcadd($size, $length);
    }
    $size = bcsub($size, $length);
    $size = bcadd($size, strlen($read));

    fclose($file);
    return $size;
}
// Hàm kiểm tra định dạng URL
function isValidURL($url) {
    $urlComponents = parse_url($url);

    // Kiểm tra xem URL có các thành phần cần thiết không
    if ($urlComponents === false || !isset($urlComponents['scheme'], $urlComponents['host'])) {
        return false;
    }

    // Kiểm tra xem scheme có phải là "https" và host có phải là "trumthe.vn" không
    if ($urlComponents['scheme'] === 'https' && $urlComponents['host'] === 'trumthe.vn') {
        return true;
    }

    return false;
}
function FileSizeConvert($bytes)
{
    $bytes = floatval($bytes);
    $arBytes = array(
        0 => array(
            "UNIT" => "TB",
            "VALUE" => pow(1024, 4)
        ),
        1 => array(
            "UNIT" => "GB",
            "VALUE" => pow(1024, 3)
        ),
        2 => array(
            "UNIT" => "MB",
            "VALUE" => pow(1024, 2)
        ),
        3 => array(
            "UNIT" => "KB",
            "VALUE" => 1024
        ),
        4 => array(
            "UNIT" => "B",
            "VALUE" => 1
        ),
    );

    foreach ($arBytes as $arItem) {
        if ($bytes >= $arItem["VALUE"]) {
            $result = $bytes / $arItem["VALUE"];
            $result = str_replace(".", ",", strval(round($result, 2))) . " " . $arItem["UNIT"];
            break;
        }
    }
    return $result;
}
function GetCorrectMTime($filePath)
{

    $time = filemtime($filePath);

    $isDST = (date('I', $time) == 1);
    $systemDST = (date('I') == 1);

    $adjustment = 0;

    if ($isDST == false && $systemDST == true)
        $adjustment = 3600;

    else if ($isDST == true && $systemDST == false)
        $adjustment = -3600;

    else
        $adjustment = 0;

    return ($time + $adjustment);
}
function DownloadFile($file)
{ // $file = include path
    if (file_exists($file)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=' . basename($file));
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Pragma: public');
        header('Content-Length: ' . filesize($file));
        ob_clean();
        flush();
        readfile($file);
        exit;
    }
}


// Send Mesage to Bot Telegram when submit
function sendMessageBotTelegram($chat_id, $message)
{
    if (empty($chat_id)
        || empty($message)
    ) {
        return false;
    }

    $message = urlencode($message);
    $apiUrl = "https://api.telegram.org/bot" . API_TOKEN_TELEGRAM . "/sendMessage?chat_id=@{$chat_id}&text={$message}&parse_mode=markdown";

    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => $apiUrl,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
    ));

    $response = curl_exec($curl);
    curl_close($curl);

    return true;    
}
