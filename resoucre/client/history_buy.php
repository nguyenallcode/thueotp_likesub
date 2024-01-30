<?php
    require_once("../../config/config.php");
    require_once("../../config/function.php");
    $title = 'Lịch sử thuê OTP';
    require_once("../../resoucre/client/Header.php");
    require_once("../../resoucre/client/Nav.php");
    CheckLogin();
?>

<main class="content">
				<div class="container-fluid">

					<div class="header">
						<h1 class="header-title">
							Lịch sử thuê OTP
						</h1>
					</div>
                    <div class="row">
						<div class="col-12">
							<div class="card">
								<div class="card-header">
									<h2 style="font-size: 20px;" class="card-title">Lịch sử số đã thuê thành công</h2>
								</div>
								<div style="white-space: nowrap;" class="card-body">
									<table id="datatables-htr-sms" class="table table-striped" style="width:100%">
										<thead>
											<tr>
                                            <th>Tên dịch vụ</th>
                                            <th>Số điện thoại</th>
                                            <th>Giá</th>
                                            <th>Thời gian thuê</th>
                                            <th>Trạng thái</th>
                                            <th>Mã Code</th>
                                            <th>Nội dung tin nhắn</th>
											</tr>
										</thead>
										<tbody>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
                    
				</div>
			</main>
            <script>
document.addEventListener("DOMContentLoaded", function() {
    var table = $('#datatables-htr-sms').DataTable({
        "ajax": {
            "url": "/ajaxs/ajaxtables/list_get_otp.php?typecheck=htr_my",
            "dataSrc": "data"
        },
        "columns": [
            { "data": "serveive" },
            { "data": "number" },
            { "data": "amount" },
            { "data": "timeremaining" },
            { "data": "action" },
            { "data": "sms_code" },
            { "data": "sms_content" },
        ],
        "ordering": false,
        "lengthMenu": [5, 10, 25, 50],
        "pageLength": 5,
        "searching": false
    });
});

</script>



<script>
function copyToClipboard(text) {
    var tempInput = document.createElement('input');
    tempInput.value = text;
    document.body.appendChild(tempInput);
    tempInput.select();
    tempInput.setSelectionRange(0, 99999);
    document.execCommand('copy');
    document.body.removeChild(tempInput);

    toastr.success('Copy thành công: ' + text, 'Copy thành công', { timeOut: 3000 });
}
</script>






<?php 
    require_once("../../resoucre/client/Footer.php");
?>