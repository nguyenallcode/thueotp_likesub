
<?php
    require_once(__DIR__."/config/config.php");
    require_once(__DIR__."/config/function.php");
    $title = ''.$NguyenAll->site('tenweb');
    require_once(__DIR__."/resoucre/client/Header.php");
    require_once(__DIR__."/resoucre/client/Nav.php");
?>

			<main class="content">
				<div class="container-fluid">
					<div class="header">
						<h1 class="header-title">
							Welcome back, Linda!
						</h1>
						<p class="header-subtitle">You have 24 new messages and 5 new notifications.</p>
					</div>

				
                    <div class="row">
						<div class="col-12">
							<div class="card">
								<div class="card-header">
									<h5 class="card-title mb-0">Tabs</h5>
								</div>
								<div class="card-body">
									<p class="mb-0">Create a tabbed interface with tabbable regions using Bootstrap's JavaScript plugin.</p>
								</div>
							</div>
						</div>

						<div class="col-12 col-lg-12">
							<div class="tab">
								<ul class="nav nav-tabs" role="tablist">
									<li class="nav-item"><a class="nav-link active" href="#tab-1" data-bs-toggle="tab" role="tab"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-info align-middle me-2"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg>Giới thiệu</a></li>
									<li class="nav-item"><a class="nav-link" href="#tab-2" data-bs-toggle="tab" role="tab"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-sliders align-middle me-2"><line x1="4" y1="21" x2="4" y2="14"></line><line x1="4" y1="10" x2="4" y2="3"></line><line x1="12" y1="21" x2="12" y2="12"></line><line x1="12" y1="8" x2="12" y2="3"></line><line x1="20" y1="21" x2="20" y2="16"></line><line x1="20" y1="12" x2="20" y2="3"></line><line x1="1" y1="14" x2="7" y2="14"></line><line x1="9" y1="8" x2="15" y2="8"></line><line x1="17" y1="16" x2="23" y2="16"></line></svg>Điều khoản sử dụng</a></li>
								</ul>
								<div class="tab-content">
									<div class="tab-pane active" id="tab-1" role="tabpanel">
										<h4 class="tab-title">Nhận mã OTP online dễ dàng, nhanh chóng với <?=$NguyenAll->site('tenweb');?></h4>
<b>									
<?=$NguyenAll->site('tenweb');?> là dịch vụ cung cấp số điện thoại để nhận mã OTP khi đăng ký các loại tài khoản cần số điện thoại để xác thực người dùng.
<br><br>
Nếu bạn cần nhận mã OTP với giá rẻ khi đăng ký một hoặc nhiều tài khoản Facebook, Gmail/Youtube/Google, Telegram, Viber, Whatsapp, Instagram, Wechat, Microsoft/Hotmail/Live, Twitter, Linemessager, Tinder, Kakaotalk, Apple, Amazon, Discord, Nike, Shopee, Tiktok, Zalo, Foodpanda, Icq, Paxful, Steam, Linkedin hay bất cứ tài khoản nào khác, hãy tạo một tài khoản trên <?=$NguyenAll->site('tenweb');?> ngay và bắt đầu nhận OTP nhé.
<br><br>
Nếu bạn cần thêm bất kỳ thông tin nào, đừng ngần ngại liên hệ với chúng tôi qua Facebook</b>

									</div>
									<div class="tab-pane" id="tab-2" role="tabpanel">

<b>
1. Bạn chỉ nhận mã OTP của dịch vụ mà bạn đã mua. Trường hợp bạn chọn dịch vụ "other", bạn chỉ nhận được mã OTP của các dịch vụ không có trong danh sách các dịch vụ trên <?=$NguyenAll->site('tenweb');?>
										<br><br>
2. Thời gian sử dụng số điện thoại là 10 phút. Trong thời gian đó, nếu bạn nhận được mã OTP thì giao dịch hoàn tất. Ngược lại, bạn không nhận được OTP thì tài khoản của bạn sẽ được hoàn tiền.
<br><br>
3. Bạn không được hoàn tiền nếu đăng ký tài khoản Telegram và nhận được xác thực 2FA
<br><br>
4. Nghiêm cấm sử dụng dịch vụ vào các mục đích bất hợp pháp
<br><br>
5. Một giao dịch được xem là hoàn tất và bạn không được hoàn tiền nếu nhận được mã OTP từ dịch vụ mà bạn đã mua
<br><br>
6. Bất kỳ hành vi gian lận nào dù vô tình hay cố ý đều dẫn đến tài khoản của bạn sẽ bị khóa vĩnh viễn, và mọi số dư (nếu có) sẽ không được hoàn lại
<br><br>
7. Khi sử dụng bất kỳ dịch vụ nào trên <?=$NguyenAll->site('tenweb');?>, mặc định bạn đã đồng ý và nghiêm túc tuân thủ tất cả các quy định của chúng tôi.
<br><br>
8. Chúng tôi có quyền thay đổi các quy định mà không cần phải thông báo trước với bạn
</b>
									</div>
								</div>
							</div>
						</div>

					</div>
				</div>
			</main>
            <?php 
    require_once(__DIR__."/resoucre/client/Footer.php");
?>