<?php
 require_once("../../config/config.php");
 require_once("../../config/function.php");
 $title = 'Đăng ký tài khoản';
 require_once("../../resoucre/client/Header.php");
?>





<main class="main h-100 w-100">
		<div class="container h-100">
			<div class="row h-100">
				<div class="col-sm-10 col-md-8 col-lg-6 mx-auto d-table h-100">
					<div class="d-table-cell align-middle">

						<div class="text-center mt-4">
							<h1 class="h2">Đăng ký tài khoản</h1>
						</div>

						<div class="card">
							<div class="card-body">
								<div class="m-sm-4">
                                    <br>
                                <div id="thongbao"></div>
										<div class="mb-3">
											<label>Tài khoản</label>
											<input class="form-control form-control-lg" type="text" id="username" placeholder="Nhập tài khoản" />
										</div>
										<div class="mb-3">
											<label>Email</label>
											<input class="form-control form-control-lg" type="email" id="email" placeholder="Nhập email" />
										</div>
										<div class="mb-3">
											<label>Mật khẩu</label>
											<input class="form-control form-control-lg" type="password" id="repassword" placeholder="Nhập mật khẩu" />
										</div>
										<div class="mb-3">
											<label>Nhập lại mật khẩu</label>
											<input class="form-control form-control-lg" type="password" id="repassword" placeholder="Nhập lại mật khẩu" />
										</div>
										<div class="text-center mt-3">
											<a id="Register" class="btn btn-lg btn-primary">Đăng ký</a>
                                            <br><br>
											<b>Đã có tài khoản?</b> <a href="/sign-in" style="font-weight: 700;color: green;">Đăng nhập ngay</a>
										</div>
								</div>
							</div>
						</div>

					</div>
				</div>
			</div>
		</div>
	</main>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script type="text/javascript">
    $("#Register").on("click", function() {
        $('#Register').html('<i class="fa fa-spinner fa-spin"></i> Loading...').prop('disabled',
        true);
        $.ajax({
            url: "<?=BASE_URL("ajaxs/ajaxclient/sign_auth.php");?>",
            method: "POST",
            data: {
                type: 'Register',
                username: $("#username").val(),
                email: $("#email").val(),
                password: $("#password").val(),
                repassword: $("#repassword").val()
            },
            success: function(response) {
                $("#thongbao").html(response);
                $('#Register').html(
                        'Đăng ký')
                    .prop('disabled', false);
            }
        });
    });
    </script>




<?php
 require_once("../../resoucre/client/Footer.php");
?>