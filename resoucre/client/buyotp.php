<?php
    require_once("../../config/config.php");
    require_once("../../config/function.php");
    $title = 'Thuê số điện thoại';
    require_once("../../resoucre/client/Header.php");
    require_once("../../resoucre/client/Nav.php");
    CheckLogin();
?>

<main class="content">
				<div class="container-fluid">

					<div class="header">
						<h1 class="header-title">
							Thuê số điện thoại
						</h1>
						<!-- <nav aria-label="breadcrumb">
							<ol class="breadcrumb">
								<li class="breadcrumb-item"><a href='/dashboard-default'>Dashboard</a></li>
								<li class="breadcrumb-item"><a href="#">DataTables</a></li>
								<li class="breadcrumb-item active" aria-current="page">DataTables Column Search</li>
							</ol>
						</nav> -->
					</div>


					<div class="row">
						<div class="col-12">
							<div class="card">
								<div class="card-header">
                                <h2 style="font-size: 20px;" class="card-title">Danh sách dịch vụ</h2>
                                    <div class="row">
                                    <div class="mb-3 col-md-3">
											<label class="form-label">Lấy số theo mạng</label>
												<select class="form-control" id="locmang" name="validation-select2-multi" multiple style="width: 100%">
                                                <?php foreach($NguyenAll->get_list("SELECT * FROM `list_option_buy`") as $option) {?>
														<option value="<?=$option['network'];?>"><?=$option['name'];?></option>
                                                        <?php }?>
												</select>
                                                </div>
                                                <div class="mb-3 col-md-3">
											<label class="form-label">Đầu số lấy</label>
												<select class="form-control" id="dausolay" name="validation-select2-multi" multiple style="width: 100%">
                                                <?php foreach($NguyenAll->get_list("SELECT * FROM `list_dauso_buy`") as $option) {?>
														<option value="<?=$option['dauso'];?>">0<?=$option['dauso'];?></option>
                                                        <?php }?>
												</select>
                                                </div>
                                                <div class="mb-3 col-md-3">
											<label class="form-label">Đầu số bỏ</label>
												<select class="form-control" id="dausobo" name="validation-select2-multi" multiple style="width: 100%">
                                                <?php foreach($NguyenAll->get_list("SELECT * FROM `list_dauso_buy`") as $option) {?>
														<option value="<?=$option['dauso'];?>">0<?=$option['dauso'];?></option>
                                                        <?php }?>
												</select>
                                                </div>
								</div>
								<div style="white-space: nowrap;" class="card-body">
									<table id="datatables-column-search-text-inputs" class="table table-based" style="width:100%">
										<thead>
											<tr>
												<th>Tên dịch vụ</th>
												<th>Giá</th>
												<th>Mua số</th>
											</tr>
										</thead>
										<tbody>
										</tbody>
                                        <tfoot>
											<tr>
                                            <th>Tên dịch vụ</th>
												<th>Giá</th>
												<th>Mua số</th>
											</tr>
										</tfoot>
									</table>
								</div>
							</div>
						</div>
					</div>

                    <div class="row">
						<div class="col-12">
							<div class="card">
								<div class="card-header">
									<h2 style="font-size: 20px;" class="card-title">Danh sách số điện thoại đang chờ mã</h2>
									<h6 class="card-subtitle text-muted">Nếu quá 10 phút không nhận được mã OTP tự động hoàn tiền.</h6>
								</div>
								<div style="white-space: nowrap;" class="card-body">
									<table id="datatables-list-sms" class="table table-based" style="width:100%">
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



<?php 
    require_once("../../resoucre/client/Footer.php");
?>