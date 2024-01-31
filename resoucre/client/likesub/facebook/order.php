<?php
    require_once("../../../../config/config.php");
    require_once("../../../../config/function.php");
    $check = $NguyenAll->get_row("SELECT * FROM `groups_social` WHERE `uid_title` = '".check_string($_GET['uid_title'])."'");
    $title = $check['title'];
    if (isset($_GET['uid_title'])) {
        if (!$check) {
            header("Location: /"); 
            exit(); 
        }
    } 
    require_once("../../../../resoucre/client/Header.php");
    require_once("../../../../resoucre/client/Nav.php");
    CheckLogin();

?>


<style>
    .card-header {
        margin-top: 0px;
    }
    
    .card-header .row {
        display: flex;
    }
    
    .card-header .col-md-6 {
        flex: 1;
    }
    
    .card-header .btn {
        background-color: #f1f1f1;
        padding: 10px;
        margin: 5px;
        cursor: pointer;
        color: #000;
        transition: background-color 0.3s, color 0.3s;
    }
    
    .card-header .btn.active {
        background-color: #4f88cb;
        color: #fff;
    }
    
    .card-header .btn:not(.active):hover {
        background-color: #dcdcdc;
        color: #333;
    }
</style>




<main class="content">
    <div class="container-fluid">

        <div class="header">
            <h1 class="header-title">
            <?=$check['title'];?>
            </h1>
        </div>
        <div class="row">
            <div class="col-12 col-xl-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-6 btn btn-primary text-center active" onclick="openTab('tab-1')" data-tab="tab-1">
                                <img src="https://subgiare.vn/assets/images/svg/order.svg" alt="" width="25" height="25"><b> Tạo đơn mới</b>
                            </div>
                            <div class="col-md-6 btn btn-primary text-center" onclick="openTab('tab-2')" data-tab="tab-2">
                                <img src="https://subgiare.vn/assets/images/svg/list-order.svg" alt="" width="25" height="25"> <b> Quản lý đơn</b>
                            </div>
                        </div>
                    </div>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab-1" role="tabpanel">
                            <div class="card-body">
                                <div class="row">
                                    <!-- 1 -->
                                    <div class="col-md-8">
                                        <div class="mb-3 row">
                                            <label class="col-form-label col-sm-2">ID Facebook</label>
                                            <div class="col-sm-10">
                                                <input type="number" id="id_url" class="form-control" placeholder="Nhập ID Profile cần tăng">
                                            </div>
                                        </div>
                                        <fieldset class="mb-3">
                                            <div class="row">
                                                <label class="col-form-label col-sm-2 pt-sm-0">Máy chủ</label>
                                                <div class="col-sm-10">
            <?php $i = 0; foreach($NguyenAll->get_list(" SELECT * FROM `service_social` WHERE `rate` != '0' AND groups = '" . $check['id'] . "' ORDER BY uutien DESC ") as $row){ ?>
                                                    <label class="form-check">
        <input id="radio-<?=$row['id'];?>" name="server-type" type="radio" class="form-check-input" data-money="<?=$row['rate'];?>" value="radio-<?=$row['id'];?>">
                    <span class="form-check-label"><?=$row['title'];?>
                        <span style="border-radius: 10px;" class="btn btn-primary btn-sm">
                            <b style="position: relative; top: -1px;"><?=format_cash($row['rate']);?>đ / Sub</b>
                        </span>
                    </span>
                </label>
                <?php }?>
                                                    <div id="info"></div>
                                                </div>
                                            </div>
                                        </fieldset>

                                        <div class="mb-3 row">
                                            <label class="col-form-label col-sm-2">Số lượng</label>
                                            <div class="col-sm-10">
                                                <input id="amount" type="number" class="form-control" value="1000" placeholder="Nhập số lượng cần tăng">
                                                <div style="background-color:#2ad76d; padding: 10px; color: #ffffff; margin-top: 20px;" class="card">
                                                    <b class="text-center">Tổng tiền = (Số lượng) x (Giá 1 sub)</b>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mb-3 row">
                                            <label class="col-form-label col-sm-2">Ghi chú</label>
                                            <div class="col-sm-10">
                                                <textarea class="form-control" id="ghichu" placeholder="Nhập ghi chú nếu cần" rows="3"></textarea>
                                                <!-- <div style="background-color:#ff2929; padding: 10px; color: #ffffff; margin-top: 20px;" class="card">
                                                    <b style="font-size: 20px;">Vui lòng đọc tránh mất tiền</b>
                                                    <b>- Mua bằng ID Facebook đã mở chế độ công khai, có nút theo dõi, có hỗ trợ tăng được cho tài khoản dưới 18+.</b>
                                                </div> -->
                                            </div>
                                        </div>

<div id="totalPayment" style="background-color: #1b9ab5;padding: 10px;color: #ffffff;margin-top: 20px;" class="card">
<b class="text-center" style="font-size: 23px;">Tổng thanh toán: <a style="color:#00ff51;">0 đ</a> </b>
</div>
<button type="button" id="Submit" style="background-color: #1bb549;
    padding: 8px;
    color: #ffffff;
    border-radius: 5px;
    border: 0;
    width: 100%;">
<b class="text-center"><img src="https://subgiare.vn/assets/images/svg/buy.svg" alt="" width="25" height="25"> Thanh toán</b>
</button>
    </div>

    <script type="text/javascript">
        document.addEventListener("DOMContentLoaded", function() {
$("#Submit").on("click", function() {
$('#Submit').html('<i class="fa fa-spinner fa-spin"></i> ĐANG XỬ LÝ').prop('disabled',
    true);
    $.ajax({
                url: '/service/ajaxs/order_social.php',
                method: "POST",
                dataType: "JSON",
                data: {
        type: 'Order',
        id_url: $("#id_url").val(),
        server: $('input[name="server-type"]:checked').val(),
        amount: $("#amount").val(),
        ghichu: $("#ghichu").val()
    },
                success: function(response) {
                    if (response.status == 'success') {
                        toastr.success(response.msg, 'Thành công', {
                            timeOut: 5000
                        });
                    } else {
                        toastr.error(response.msg, 'Thất bại', {
                            timeOut: 5000
                        });
                    }
                },
                error: function(error) {
                    toastr.error('Đã có lỗi xảy ra !', 'Lỗi', {
                        timeOut: 5000
                    });
                }
            });
});
});
</script>
                                    <!-- end 1 -->

                                    <!-- 2 -->
                                    <div class="col-md-4">
                                        <div class="taborder">
                                            <div>
                                                <h3 style="color: #fff;">Các trường hợp đơn bị hủy hoặc không lên follow</h3>
                                                <p style="margin: 10px;">ID không công khai, die, không mở nút follow hoặc có thể do tụt follow gốc.<br>Nếu tăng cho page profile (pro5) hãy mua thử số lượng nhỏ xem server đó có chạy không vì 1 số server không hỗ trợ</p>
                                            </div>
                                        </div>
                                        <br>
                                        <div style="background-color:#e33232;" class="taborder">
                                            <div>
                                                <h3 style="color: #fff;">Lưu ý</h3>
                                                <p style="margin: 10px;">Nghiêm cấm buff các đơn có nội dung vi phạm pháp luật, chính trị, đồ trụy... Nếu cố tình buff bạn sẽ bị trừ hết tiền và ban khỏi hệ thống vĩnh viễn, và phải chịu hoàn toàn trách nhiệm trước pháp luật.
                                                    <br> Nếu đơn đang chạy trên hệ thống mà bạn vẫn mua ở các hệ thống bên khác hoặc đè nhiều đơn, nếu có tình trạng hụt, thiếu số lượng giữa 2 bên thì sẽ không được xử lí.
                                                    <br> Đơn cài sai thông tin hoặc lỗi trong quá trình tăng hệ thống sẽ không hoàn lại tiền.
                                                    <br> Nếu gặp lỗi hãy nhắn tin hỗ trợ phía bên phải góc màn hình hoặc vào mục liên hệ hỗ trợ để được hỗ trợ tốt nhất</p>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end 2 -->
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane" id="tab-2" role="tabpanel">
                            <div class="card-body">
                                <table id="datatables-multi" class="table table-striped" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Position</th>
                                            <th>Office</th>
                                            <th>Age</th>
                                            <th>Start date</th>
                                            <th>Salary</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Tiger Nixon</td>
                                            <td>System Architect</td>
                                            <td>Edinburgh</td>
                                            <td>61</td>
                                            <td>2011/04/25</td>
                                            <td>$320,800</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>



                </div>
            </div>
        </div>
</main>
<style>
    #totalPayment {
        font-size: 23px;
    }
    
    #totalPayment span {
        color: #00ff51;
    }
</style>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        document.querySelectorAll('input[name="server-type"]').forEach(function(radioInput) {
            radioInput.addEventListener('change', function() {
                var quantity = document.getElementById('amount').value;

                var pricePerSub = parseInt(document.querySelector('input[name="server-type"]:checked').getAttribute('data-money')) || 1000;

                var totalPayment = quantity * pricePerSub;

                var totalPaymentElement = document.getElementById('totalPayment');
                totalPaymentElement.innerHTML = '<b class="text-center">Tổng thanh toán: <span>' + totalPayment.toLocaleString('en-US') + ' đ</span></b>';

                document.getElementById('info').innerHTML = 'Giá 1 sub: ' + pricePerSub.toLocaleString('en-US') + ' đ';
            });
        });

        document.getElementById('amount').addEventListener('input', function() {
            document.querySelector('input[name="server-type"]:checked').dispatchEvent(new Event('change'));
        });
    });
</script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const radioButtons = document.querySelectorAll('input[type="radio"]');
        const infoDiv = document.getElementById("info");

        radioButtons.forEach(function(radioButton) {
            radioButton.addEventListener("change", function() {
                const value = radioButton.value;
                switch (value) {
                    <?php $i = 0; foreach($NguyenAll->get_list("SELECT * FROM `service_social` WHERE `rate` != '0' AND groups = '" . $check['id'] . "' AND detail != '' ORDER BY id DESC ") as $row) { ?>
                    case 'radio-<?=$row['id'];?>':
                        infoDiv.innerHTML = `
                                <div style="background-color:#2ad7d5; padding: 10px; color: #160505; margin-top:10px;" class="card">
    <b><?=$row['detail'];?></b>
                                </div>
                                `;
                        break;
                        <?php }?>
                    default:
                        infoDiv.innerHTML = "";
                }
            });
        });
    });
</script>

<script>
    function openTab(tabId) {
        document.querySelectorAll('.tab-pane, .card-header .btn').forEach(item => {
            item.classList.remove('active');
        });
        document.getElementById(tabId).classList.add('active');
        document.querySelector(`.card-header .btn[data-tab="${tabId}"]`).classList.add('active');
    }
</script>




<?php 
    require_once("../../../../resoucre/client/Footer.php");
?>

