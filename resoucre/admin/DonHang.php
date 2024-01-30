<?php
    require_once("../../config/config.php");
    require_once("../../config/function.php");
    $title = 'Đơn hàng | Admin';
    require_once("../../resoucre/admin/Header.php");
    require_once("../../resoucre/admin/Nav.php");
?>




<div id="page-wrapper">
    <div id="page-inner">
                        <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                             Danh sách đơn hàng 
                        </div>
                        <div class="panel-body">
                        <button id="full" class="btn btn-primary btn-sm">Tất cả</button>
                            <button id="success" class="btn btn-success btn-sm">Thành công</button>
                            <button id="refund" class="btn btn-warning btn-sm">Hoàn tiền</button>
                            <div class="table-responsive">
                                <table class="table table-striped  table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                        <th>#</th>
                                            <th>Mã đơn</th>
                                            <th>Người mua</th>
                                            <th>API</th>
                                            <th>Dịch vụ</th>
                                            <th>Order từ</th>
                                            <th>Trạng thái</th>
                                            <th>SMS</th>
                                            <th>Mã SMS</th>                              
                                            <th>Nội dung SMS</th>
                                            <th>Số tiền</th>
                                            <th>Lợi nhuận</th>
                                            <th>Bắt đầu</th>
                                            <th>Kết thúc</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <script>
$(document).ready(function() {
    $(document).on('click', '.toggle-cart', function() {
        const $cell = $(this);
        const originalText = $cell.data('original-text');
        const isHidden = $cell.data('hidden') === true;

        if (isHidden) {
            $cell.text(originalText);
        } else {
            const maxLength = 6;
            const truncatedText = originalText.substring(0, maxLength) + '...';
            $cell.text(truncatedText);
        }

        $cell.data('hidden', !isHidden);
    });

    $('.toggle-cart').after('<button class="show-cart">Show</button>');

    $(document).on('click', '.show-cart', function() {
        const $cell = $(this).prev('.toggle-cart');
        $cell.text($cell.data('original-text'));
        $(this).hide();
    });
});
</script>

            <script>
function copyToClipboard(text) {
  navigator.clipboard.writeText(text).then(function() {
    var copiedText = text; 
    Swal.fire({
      icon: 'success',
      title: 'Copy thành công',
      text: 'Copy thành công: ' + copiedText,
      timer: 3000,
    });
  }, function() {
    console.error('Lỗi khi sao chép');
  });
}
</script>

<script>
$(document).ready(function() {
    var dataTable = $('#dataTables-example').DataTable({
        "ajax": {
            "url": "/ajaxs/ajaxadmin/DonHang.php",
            "dataSrc": "data"
        },
        "columns": [
            { "data": "id" },
            { "data": "id_cart" },
            { "data": "username" },
            { "data": "name_api" },
            { "data": "service" },
            { "data": "order_by" },
            { "data": "response" },
            { "data": "number" },
            { "data": "sms_code" },
            { "data": "sms_content" },
            { "data": "amount" },
            { "data": "profit" },
            { "data": "start" },
            { "data": "end" },
        ],
        "lengthMenu": [10, 25, 50, 100, 500],
            "pageLength": 10,
            "deferRender": true,
            "processing": true,
    });
    $('#full').on('click', function() {
        dataTable.ajax.url('/ajaxs/ajaxadmin/DonHang.php').load();
    });
        $('#success').on('click', function() {
        dataTable.ajax.url('/ajaxs/ajaxadmin/DonHang.php?type=success').load();
    });
    $('#refund').on('click', function() {
        dataTable.ajax.url('/ajaxs/ajaxadmin/DonHang.php?type=refund').load();
    });
});
</script>




<?php 
    require_once("../../resoucre/admin/Footer.php");
?>