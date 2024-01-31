<body>
	<div class="splash active">
		<div class="splash-icon"></div>
	</div>

	<div class="wrapper">
		<nav id="sidebar" class="sidebar">
			<a class='sidebar-brand' href='index.html'>
				<svg>
					<use xlink:href="#ion-ios-pulse-strong"></use>
				</svg>
				Spark
			</a>
			<div class="sidebar-content">
				<div class="sidebar-user">
					<img src="/theme/img/avatars/avatar.jpg" class="img-fluid rounded-circle mb-2" alt="NguyenAll" />
					<?php if(empty($_SESSION['username'])) { ?>
					<div class="fw-bold">Khách</div>
					<?php } else { ?>
						<div class="fw-bold"><?=$_SESSION['username'];?></div>
					<small>Số dư: <?=format_cash($getUser['money']);?>đ</small>
						<?php }?>
				</div>

				<ul class="sidebar-nav">
					<li class="sidebar-header">
						Bảng điều khiển
					</li>
					<li class="sidebar-item">
                    <a class='sidebar-link' href='/'>
							<i class="align-middle me-2 fas fa-fw fa-home"></i> <span class="align-middle">Trang chủ</span>
						</a>
					</li>
					<li class="sidebar-item">
                    <a class='sidebar-link' href='/profile'>
							<i class="align-middle me-2 fas fa-fw fa-user"></i> <span class="align-middle">Thông tin tài khoản</span>
						</a>
					</li>
					<li class="sidebar-header">
						Social Network
					</li>
			<?php foreach($NguyenAll->get_list("SELECT * FROM `category_social` WHERE `display` = 'SHOW' ORDER BY uutien DESC") as $category) { ?>
				<li class="sidebar-item">
						<a data-bs-target="#side_social<?=$category['id'];?>" data-bs-toggle="collapse" class="sidebar-link">
						<img style="width:24px; height:24px;" src="<?=$category['img'];?>" alt=""> <span class="align-middle"><?=$category['title'];?></span>
						</a>
		<?php foreach($NguyenAll->get_list("SELECT * FROM `groups_social` WHERE `display` = 'SHOW' AND `category` = '".$category['id']."'  ORDER BY uutien DESC") as $group) { ?>
		<ul id="side_social<?=$category['id'];?>" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
			<li class="sidebar-item"><a class='sidebar-link' href='/service/<?=$group['uid_title'];?>'><?=$group['title'];?></a></li>
		</ul>
		<?php }?>
					</li>
<?php }?>

					<li class="sidebar-header">
						Thuê số
					</li>
					<li class="sidebar-item">
						<a class='sidebar-link' href='/otp/order'>
						<i class="align-middle me-2 fas fa-fw fa-microchip"></i> <span class="align-middle">Mua code</span>
						</a>
					</li>
					<li class="sidebar-item">
						<a class='sidebar-link' href='/otp/history'>
						<i class="align-middle me-2 fas fa-fw fa-clock"></i> <span class="align-middle">Lịch sử thuê code</span>
						</a>
					</li>

					<li class="sidebar-header">
						API Document
					</li>
					<li class="sidebar-item">
						<a class='sidebar-link' href='/api'>
						<i class="align-middle me-2 fas fa-fw fa-book"></i> <span class="align-middle">Tài liệu API</span>
						</a>
					</li>


					<li class="sidebar-header">
						Panel Admin
					</li>
					<li class="sidebar-item">
						<a class='sidebar-link' href='/DashboardAdmin'>
						<i class="align-middle me-2 fas fa-fw fa-users-cog"></i> <span class="align-middle">Quản trị Admin</span>
						</a>
					</li>
				</ul>
			</div>
		</nav>
		<div class="main">
			<nav class="navbar navbar-expand navbar-theme">
				<a class="sidebar-toggle d-flex me-2">
					<i class="hamburger align-self-center"></i>
				</a>

				<form class="d-none d-sm-inline-block">
					<input class="form-control form-control-lite" type="text" placeholder="Search projects...">
				</form>

				<div class="navbar-collapse collapse">
					<ul class="navbar-nav ms-auto">


						<?php if(empty($_SESSION['username'])) { ?>
						<li class="nav-item dropdown active">
							<a class="nav-link dropdown-toggle position-relative" href="/sign-in">
							<button class="btn btn-pill btn-info"><i class="align-middle me-2 fas fa-fw fa-sign-in-alt"></i> Đăng nhập</button>
							</a>
						</li>
						<li class="nav-item dropdown active">
							<a class="nav-link dropdown-toggle position-relative" href="/sign-up">
							<button class="btn btn-pill btn-info"><i class="align-middle me-2 fas fa-fw fa-sign-in-alt"></i> Đăng ký</button>
							</a>
						</li>
						<?php } else { ?>
							<li class="nav-item dropdown ms-lg-2">
							<a class="nav-link dropdown-toggle position-relative" href="#" id="alertsDropdown" data-bs-toggle="dropdown">
								<i class="align-middle fas fa-bell"></i>
								<span class="indicator"></span>
							</a>
							<div class="dropdown-menu dropdown-menu-lg dropdown-menu-end py-0" aria-labelledby="alertsDropdown">
								<div class="dropdown-menu-header">
									4 New Notifications
								</div>
								<div class="list-group">
									<a href="#" class="list-group-item">
										<div class="row g-0 align-items-center">
											<div class="col-2">
												<i class="ms-1 text-danger fas fa-fw fa-bell"></i>
											</div>
											<div class="col-10">
												<div class="text-dark">Update completed</div>
												<div class="text-muted small mt-1">Restart server 12 to complete the update.</div>
												<div class="text-muted small mt-1">2h ago</div>
											</div>
										</div>
									</a>
									<a href="#" class="list-group-item">
										<div class="row g-0 align-items-center">
											<div class="col-2">
												<i class="ms-1 text-warning fas fa-fw fa-envelope-open"></i>
											</div>
											<div class="col-10">
												<div class="text-dark">Lorem ipsum</div>
												<div class="text-muted small mt-1">Aliquam ex eros, imperdiet vulputate hendrerit et.</div>
												<div class="text-muted small mt-1">6h ago</div>
											</div>
										</div>
									</a>
									<a href="#" class="list-group-item">
										<div class="row g-0 align-items-center">
											<div class="col-2">
												<i class="ms-1 text-primary fas fa-fw fa-building"></i>
											</div>
											<div class="col-10">
												<div class="text-dark">Login from 192.186.1.1</div>
												<div class="text-muted small mt-1">8h ago</div>
											</div>
										</div>
									</a>
									<a href="#" class="list-group-item">
										<div class="row g-0 align-items-center">
											<div class="col-2">
												<i class="ms-1 text-success fas fa-fw fa-bell-slash"></i>
											</div>
											<div class="col-10">
												<div class="text-dark">New connection</div>
												<div class="text-muted small mt-1">Anna accepted your request.</div>
												<div class="text-muted small mt-1">12h ago</div>
											</div>
										</div>
									</a>
								</div>
								<div class="dropdown-menu-footer">
									<a href="#" class="text-muted">Show all notifications</a>
								</div>
							</div>
						</li>
							<li class="nav-item dropdown active">
							<a class="nav-link dropdown-toggle position-relative" href="#" id="userDropdown" data-bs-toggle="dropdown">
							<button class="btn btn-pill btn-info"><?=$_SESSION['username'];?> - <?=format_cash($getUser['money']);?>đ</button>
							</a>
							<div class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
								<a class="dropdown-item" href="/profile"><i class="align-middle me-1 fas fa-fw fa-user"></i> Thông tin</a>
								<div class="dropdown-divider"></div>
								<a class="dropdown-item" href="/sign-out"><i class="align-middle me-1 fas fa-fw fa-arrow-alt-circle-right"></i> Đăng xuất</a>
							</div>
						</li>

							<?php }?>
					</ul>
				</div>
			</nav>