<?php
    require_once("../../config/config.php");
    require_once("../../config/function.php");
    $title = 'Document API';
    require_once("../../resoucre/client/Header.php");
    require_once("../../resoucre/client/Nav.php");
?>


<main class="content">
				<div class="container-fluid">

					<div class="header">
						<h1 class="header-title">
							Document API
						</h1>
					</div>
					<div class="row">
						<div class="col-12">
							<div class="card">
								<div class="card-header">
									<h5 class="card-title mb-0">1. Tra cứu thông tin tài khoản</h5>
								</div>
								<div class="card-body">
									<div id="changelog">
										<h4><span class="badge bg-primary">Ví dụ gửi đi</span></h4>
                                        <br>
										<h5>GET <?= BASE_URL("api/getinfo?api_key=2JRSA3boT9cjXaqK45krNwpyfVvi8BZW"); ?></h5>
										<ul>
											<li>{"status_code":200,"success":true,"data":{"money":"994600"}}</li>
										</ul>
                                        <h4><span class="badge bg-primary">Tham số gửi đi</span></h4>
                                        <br>
										<h5>api_key <b style="color:red;">(Bắt buộc)</b></h5>
										<ul>
											<li>API Key tài khoản của bạn.</li>
										</ul>
                                        <h4><span class="badge bg-primary">Danh sách trả về</span></h4>
                                        <br>
                                        <h5>status_code : Mã của kết quả.</h5>
										<ul>
											<li>200 : Thành công.</li>
                                            <li>401 : Không thể lấy thông tin.</li>
                                            <li>400 : API KEY Không đúng.</li>
										</ul>
                                        <h5>message : Thông tin thêm.</h5>
										<ul>
											<li>Thông tin báo nội dung lỗi.</li>
										</ul>
                                        <h5>data</h5>
										<ul>
											<li>money : Số tiền còn lại.</li>
										</ul>
									</div>
								</div>
							</div>
						</div>

                        <div class="col-12">
							<div class="card">
								<div class="card-header">
									<h5 class="card-title mb-0">2. Lấy danh sách các dịch vụ</h5>
								</div>
								<div class="card-body">
									<div id="changelog">
										<h4><span class="badge bg-primary">Ví dụ gửi đi</span></h4>
                                        <br>
										<h5>GET <?= BASE_URL("api/getservice?api_key=2JRSA3boT9cjXaqK45krNwpyfVvi8BZW"); ?></h5>
										<ul>
<li>{"status_code":200,"success":true,"data":[{"service_id":"1","name":"Facebook","price":"1000"},{"service_id":"2","name":"Google","price":"1200"}]}</li>
										</ul>
                                        <h4><span class="badge bg-primary">Tham số gửi đi</span></h4>
                                        <br>
										<h5>api_key <b style="color:red;">(Bắt buộc)</b></h5>
										<ul>
											<li>API Key tài khoản của bạn.</li>
										</ul>
                                        <h4><span class="badge bg-primary">Danh sách trả về</span></h4>
                                        <br>
                                        <h5>status_code : Mã của kết quả.</h5>
										<ul>
											<li>200 : Thành công.</li>
                                            <li>401 : Không thể lấy thông tin.</li>
                                            <li>400 : API KEY Không đúng.</li>
										</ul>
                                        <h5>message : Thông tin thêm.</h5>
										<ul>
											<li>Thông tin báo nội dung lỗi.</li>
										</ul>
                                        <h5>data</h5>
										<ul>
											<li>"service_id" : ID của dịch vụ.</li>
                                            <li>"name" : Tên của dịch vụ.</li>
                                            <li>"price" : Giá tiền của dịch vụ.</li>
										</ul>
									</div>
								</div>
							</div>
						</div>


                        <div class="col-12">
							<div class="card">
								<div class="card-header">
									<h5 class="card-title mb-0">3. Yêu cầu mua số điện thoại</h5>
								</div>
								<div class="card-body">
									<div id="changelog">
										<h4><span class="badge bg-primary">Ví dụ gửi đi</span></h4>
                                        <br>
            <h5>GET <?= BASE_URL("api/buyservice?api_key=2JRSA3boT9cjXaqK45krNwpyfVvi8BZW&service_id=1"); ?></h5>
										<ul>
<li>{"status_code":200,"success":true,"data":[{"service_id":"1","request_id":"fgaFyDzLYVtEdjiIoCbWvGxwuXJepONM","number":"84585761484","service":"Facebook","price":"1000","start":"2024/01/01 16:32:44"}]}</li>
										</ul>
                                        <h4><span class="badge bg-primary">Tham số gửi đi</span></h4>
                                        <br>
										<h5>api_key <b style="color:red;">(Bắt buộc)</b></h5>
										<ul>
											<li>API Key tài khoản của bạn.</li>
										</ul>
                                        <h5>service_id <b style="color:red;">(Bắt buộc)</b></h5>
										<ul>
											<li>ID của dịch vụ lấy ở mục <b>2</b>.</li>
										</ul>
                                        <h5>network (Không bắt buộc)</h5>
										<ul>
											<li>Danh sách các mạng: mobifone, vinaphone, viettel, vietnamobile. Nếu chọn nhiều mạng thì cách nhau bởi dấu |. Ví dụ chỉ lấy số của Viettel và Mobifone: network=viettel|mobifone</li>
										</ul>
                                        <h5>prefix (Không bắt buộc)</h5>
										<ul>
<li>Đầu số gồm 1-2 số (không bao gồm số 0 ở đầu). Nếu muốn chọn nhiều đầu số thì viết cách nhau bởi dấu |. Ví dụ chỉ lấy số có các đầu số 092, 090, 03: prefix=92|90|3</li>
										</ul>
                                        <h5>exceptPrefix (Không bắt buộc)</h5>
										<ul>
                    <li>Đầu số không muốn lấy. Ví dụ không muốn lấy đầu số 5 và 78 exceptPrefix=5|78</li>
										</ul>
                                        <h4><span class="badge bg-primary">Danh sách trả về</span></h4>
                                        <br>
                                        <h5>status_code : Mã của kết quả.</h5>
										<ul>
											<li>200 : Thành công.</li>
                                            <li>401 : API KEY không đúng.</li>
                                            <li>1 : Số dư không đủ.</li>
                                            <li>2 : Không có số.</li>
                                            <li>3 : Dịch vụ không hợp lệ.</li>
                                            <li>4 : Số quá nhiều, vui lòng đợi.</li>
                                            <li>5 : Có lỗi (Thông báo ở message).</li>
										</ul>
                                        <h5>message : Thông tin thêm.</h5>
										<ul>
											<li>Thông tin báo nội dung lỗi.</li>
										</ul>
                                        <h5>data</h5>
										<ul>
											<li>"service_id" : ID của dịch vụ.</li>
                                            <li>"request_id" : Mã giao dịch.</li>
                                            <li>"number" : Số điện thoại vừa lấy.</li>
                                            <li>"service" : Tên dịch vụ.</li>
                                            <li>"price" : Giá tiền của dịch vụ.</li>
                                            <li>"start" : Thời gian mua.</li>
										</ul>
									</div>
								</div>
							</div>
						</div>

                        <div class="col-12">
							<div class="card">
								<div class="card-header">
									<h5 class="card-title mb-0">4. Lấy mã code</h5>
								</div>
								<div class="card-body">
									<div id="changelog">
										<h4><span class="badge bg-primary">Ví dụ gửi đi</span></h4>
                                        <br>
                            <h5>GET <?= BASE_URL("api/getotp?api_key=2JRSA3boT9cjXaqK45krNwpyfVvi8BZW&request_id=cDRXfNzJhyeguTp24lvGZq1aAIEOswWCi"); ?></h5>
										<ul>
<li>{"status_code":0,"success":true,"data":{"request_id":"cDRXfNzJhyeguTp24lvGZq1aAIEOswWCi","sms_code":"346061","sms_content":"346061 là mã xác nhận Facebook của bạn"}}</li>
										</ul>
                                        <h4><span class="badge bg-primary">Tham số gửi đi</span></h4>
                                        <br>
										<h5>api_key <b style="color:red;">(Bắt buộc)</b></h5>
										<ul>
											<li>API Key tài khoản của bạn.</li>
										</ul>
                                        <h5>request_id <b style="color:red;">(Bắt buộc)</b></h5>
										<ul>
											<li>Mã giao dịch sau khi mua.</li>
										</ul>
                                        <h4><span class="badge bg-primary">Danh sách trả về</span></h4>
                                        <br>
                                        <h5>status_code : Mã của kết quả.</h5>
										<ul>
                                            <li>401 : API KEY không hợp lệ.</li>
                                            <li>3 : request_id không đúng.</li>
                                            <li>4 : Lỗi.</li>
											<li>0 : Thành công.</li>
                                            <li>1 : Đang chờ mã.</li>
                                            <li>2 : Hết hạn, hoàn tiền.</li>
                                            <li>4 : Lỗi.</li>
										</ul>
                                        <h5>message : Thông tin thêm.</h5>
										<ul>
											<li>Thông tin báo nội dung lỗi.</li>
										</ul>
                                        <h5>data</h5>
										<ul>
											<li>"request_id" : Mã giao dịch sau khi mua.</li>
                                            <li>"sms_code" : Mã code.</li>
                                            <li>"sms_content" : Nội dung tin nhắn mã code.</li>
										</ul>
									</div>
								</div>
							</div>
						</div>


					</div>
				</div>
			</main>
<?php 
    require_once("../../resoucre/client/Footer.php");
?>