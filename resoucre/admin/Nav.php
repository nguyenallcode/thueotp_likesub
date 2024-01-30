<body>
    <div id="wrapper">
        <nav class="navbar navbar-default top-navbar" role="navigation">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="/">Admin Panel</a>
            </div>
            <?php if(empty($_SESSION['username'])) { ?>

<?php } else { ?>
            <ul class="nav navbar-top-links navbar-right">
             
              
                    <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false">
                    <?=$_SESSION['username'];?> - <?=format_cash($getUser['money']);?>đ <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="/Logout"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                        </li>
                    </ul>

                    <?php }?>
                </li>
            </ul>
        </nav>
        <nav class="navbar-default navbar-side" role="navigation">
            <div class="sidebar-collapse">
                <ul class="nav" id="main-menu">
                    <li>
                        <a class="<?=active_navmenu(['index.php']);?>-menu" href="/DashboardAdmin"><i class="fa fa-dashboard"></i> Trang chủ</a>
                    </li>
                    <li>
                        <a class="<?=active_navmenu(['DonHang.php']);?>-menu" href="/Admin/DonHang"><i class='bx bxs-cart'></i> Đơn hàng</a>
                    </li>
                    <li>
                        <a class="<?=active_navmenu(['EditUser.php', 'User.php']);?>-menu" href="/Admin/User"><i class='bx bx-user-circle'></i> Thành viên</a>
                    </li>
                    <li>
                        <a class="<?=active_navmenu(['CauHinhNapTien.php']);?>-menu" href="/Admin/CauHinhNapTien"><i class='bx bx-credit-card'></i> Cấu hình nạp tiền</a>
                    </li>
                    <li>
                        <a class="<?=active_navmenu(['CaiDatThongBao.php']);?>-menu" href="/Admin/CaiDatThongBao"><i class='bx bx-cog' ></i> Cài đặt Thông báo</a>
                    </li>
                    <li>
                        <a class="<?=active_navmenu(['CaiDat.php']);?>-menu" href="/Admin/CaiDat"><i class='bx bx-cog' ></i> Cài đặt Website</a>
                    </li>
                </ul>

            </div>

        </nav>