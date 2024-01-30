<?php
    require_once("../../config/config.php");
    require_once("../../config/function.php");
    $title = 'Thông tin tài khoản';
    require_once("../../resoucre/client/Header.php");
    require_once("../../resoucre/client/Nav.php");
    CheckLogin();
?>

<main class="content">
				<div class="container-fluid">

					<div class="header">
						<h1 class="header-title">
						Thông tin tài khoản
						</h1>
					</div>
					<div class="row">
						<div class="col-md-3 col-xl-2">

							<div class="card">
								<div class="card-header">
									<h5 class="card-title mb-0">Profile Settings</h5>
								</div>

								<div class="list-group list-group-flush" role="tablist">
									<a class="list-group-item list-group-item-action active" data-bs-toggle="list" href="#account" role="tab">
										Tài khoản
									</a>
									<a class="list-group-item list-group-item-action" data-bs-toggle="list" href="#password" role="tab">
										Mật khẩu
									</a>
									<a class="list-group-item list-group-item-action" data-bs-toggle="list" href="#log_money" role="tab">
										Biến động số dư
									</a>
								</div>
							</div>
						</div>

						<div class="col-md-9 col-xl-10">
							<div class="tab-content">
								<div class="tab-pane fade show active" id="account" role="tabpanel">
									<div class="card">
										<div class="card-header">
											<div class="card-actions float-end">
												<a href="#" class="me-1">
													<i class="align-middle" data-feather="refresh-cw"></i>
												</a>
												<div class="d-inline-block dropdown show">
													<a href="#" data-bs-toggle="dropdown" data-bs-display="static">
														<i class="align-middle" data-feather="more-vertical"></i>
													</a>

													<div class="dropdown-menu dropdown-menu-end">
														<a class="dropdown-item" href="#">Action</a>
														<a class="dropdown-item" href="#">Another action</a>
														<a class="dropdown-item" href="#">Something else here</a>
													</div>
												</div>
											</div>
											<h5 class="card-title mb-0">Thông tin tài khoản</h5>
										</div>
										<div class="card-body">
												<div class="row">
													<div class="mb-3 col-md-6">
														<label for="inputFirstName">Tên đăng nhập</label>
														<input type="text" class="form-control"  value="<?=$getUser['username'];?>" disabled>
													</div>
													<div class="mb-3 col-md-6">
														<label for="inputLastName">Email</label>
														<input type="text" class="form-control"  value="<?=$getUser['email'];?>" disabled>
													</div>
												</div>
												<div class="row">
													<div class="mb-3 col-md-4">
														<label for="inputCity">Số dư hiện tại</label>
														<input type="text" class="form-control" value="<?=format_cash($getUser['money']);?>" disabled>
													</div>
													<div class="mb-3 col-md-4">
														<label for="inputZip">Số tiền đã nạp</label>
														<input type="text" class="form-control"  value="<?=format_cash($getUser['total_money']);?>" disabled>
													</div>
                                                    <div class="mb-3 col-md-4">
														<label for="inputZip">Số tiền đã tiêu</label>
														<input type="text" class="form-control"value="<?=format_cash($getUser['used_money']);?>" disabled>
													</div>
												</div>
                                                <div class="row">
													<div class="mb-3 col-md-4">
														<label for="inputCity">Đăng ký lúc</label>
														<input type="text" class="form-control"  value="<?=($getUser['createdate']);?>" disabled>
													</div>
													<div class="mb-3 col-md-4">
														<label for="inputZip">Đăng nhập gần đây</label>
														<input type="text" class="form-control" value="<?=($getUser['timelogin']);?>" disabled>
													</div>
                                                    <div class="mb-3 col-md-4">
														<label for="inputZip">IP</label>
														<input type="text" class="form-control"  value="<?=($getUser['ip']);?>" disabled>
													</div>
												</div>
                                                <div class="row">
    <div class="mb-3 col-md-6">
        <label for="inputCity">API KEY</label>
        <input type="text" class="form-control" value="<?= $getUser['api_key']; ?>" id="apiKeyInput" disabled>
        <button type="button" class="btn btn-primary" id="changeApiKeyBtn">Đổi API Key</button>
    </div>
</div>

							</div>
						</div>
					</div>
								<div class="tab-pane fade" id="password" role="tabpanel">
									<div class="card">
										<div class="card-body">
                                            <div id="thongbao"></div>
											<h5 class="card-title">Thay đổi mật khẩu</h5>
												<div class="mb-3">
													<label for="inputPasswordCurrent">Mật khẩu cũ</label>
													<input type="password" class="form-control" id="passwordold">
													<small><a href="#">Forgot your password?</a></small>
												</div>
												<div class="mb-3">
													<label for="inputPasswordNew">Mật khẩu mới</label>
													<input type="password" class="form-control" id="password">
												</div>
												<button id="DoiMatKhau" type="button" class="btn btn-primary">Thay đổi</button>
										</div>
									</div>
								</div>
							</div>
						<div class="tab-pane fade" id="log_money" role="tabpanel">
									<div class="card">
										<div class="card-body">
                                            <div id="thongbao"></div>
											<h5 class="card-title">Biến động số dư gần đây</h5>
									<table id="datatables-log_money" class="table table-striped" style="width:100%">
										<thead>
											<tr>
												<th>Biến động</th>
												<th>Số dư còn lại</th>
												<th>Hoạt động</th>
												<th>Thời gian</th>
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
						</div>
					</div>
				</div>
			</main>
            <script>
document.addEventListener("DOMContentLoaded", function () {
    var table = $('#datatables-log_money').DataTable({
        "ajax": {
            "url": "/ajaxs/ajaxtables/biendongsodu.php",
            "dataSrc": "data"
        },
        "columns": [
            { "data": "type" },
            { "data": "soduconlai" },
            { "data": "noidung" },
            { "data": "thoigian" },
        ],
        "ordering": false,
        "lengthMenu": [5, 10, 25, 50],
        "pageLength": 5,
        "searching": false,
        "drawCallback": function (settings) {
            var api = this.api();
            var totalPages = api.page.info().pages;
            if (totalPages <= 1) {
                $('#datatables-list-sms_paginate').hide();
            } else {
                $('#datatables-list-sms_paginate').show();
            }
        }
    });
});
</script>

            <script type="text/javascript">
                document.addEventListener("DOMContentLoaded", function() {
    $('#changeApiKeyBtn').click(function () {
        $.ajax({
            url: '<?=BASE_URL("ajaxs/ajaxclient/change_api_key.php");?>', 
            method: 'POST',
            dataType: 'json',
            success: function (response) {
    if (response.status === 'success') {
        $('#apiKeyInput').val(response.apiKey);
    } else {
        alert('Đã có lỗi khi đổi API KEY: ' + response.msg);
    }
},
            error: function () {
                alert('Đã có lỗi khi gửi yêu cầu đổi API KEY');
            }
        });
    });
});
            </script>


            <script type="text/javascript">
				document.addEventListener("DOMContentLoaded", function() {
$("#DoiMatKhau").on("click", function() {
    $.ajax({
        url: "/ajaxs/ajaxclient/sign_auth.php",
        method: "POST",
        data: {
            type: 'DoiMatKhau',
            password: $("#password").val(),
            passwordold: $("#passwordold").val()
        },
        success: function(response) {
            $("#thongbao").html(response);
        }
    });
});
});
</script>


<?php 
    require_once("../../resoucre/client/Footer.php");
?>