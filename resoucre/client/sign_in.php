<?php
 require_once("../../config/config.php");
 require_once("../../config/function.php");
 $title = 'Đăng nhập';
 require_once("../../resoucre/client/Header.php");
?>

<main class="main h-100 w-100">
		<div class="container h-100">
			<div class="row h-100">
				<div class="col-sm-10 col-md-8 col-lg-6 mx-auto d-table h-100">
					<div class="d-table-cell align-middle">

						<div class="text-center mt-4">
							<h1 class="h2">Đăng nhập</h1>
						</div>
						<div class="card">
							<div class="card-body">
								<div class="m-sm-4">
									<div class="text-center">
										<img src="https://cdn-icons-png.flaticon.com/512/1791/1791961.png" alt="Linda Miller" class="img-fluid" width="132" height="132" />
									</div>
                                    <div id="thongbao"></div>
										<div class="mb-3">
											<label>Tài khoản</label>
											<input class="form-control form-control-lg" type="text" id="username" placeholder="Nhập tài khoản của bạn" />
										</div>
										<div class="mb-3">
											<label>Password</label>
											<input class="form-control form-control-lg" type="password" id="password" placeholder="Nhập mật khẩu của bạn" />
											<small>
												<a href='#'>Quên mật khẩu?</a>
											</small>
										</div>
										<div class="text-center mt-3">
											<a id="Login" class="btn btn-lg btn-primary">Đăng nhập</a>
                                            <br><br>
											<b>Chưa có tài khoản?</b> <a href="/sign-up" style="font-weight: 700;color: red;">Đăng ký ngay</a>
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
$("#Login").on("click", function() {
    $('#Login').html('<i class="fa fa-spinner fa-spin"></i> Loading...').prop('disabled',
        true);
    $.ajax({
        url: "<?=BASE_URL("ajaxs/ajaxclient/sign_auth.php");?>",
        method: "POST",
        data: {
            type: 'Login',
            username: $("#username").val(),
            password: $("#password").val()
        },
        success: function(response) {
            $("#thongbao").html(response);
            $('#Login').html(
                    'Đăng nhập')
                .prop('disabled', false);
        }
    });
});
</script>

<?php
 require_once("../../resoucre/client/Footer.php");
?>