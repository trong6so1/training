<!--A Design by W3layouts
Author: W3layout
Author URL: http://w3layouts.com
License: Creative Commons Attribution 3.0 Unported
License URL: http://creativecommons.org/licenses/by/3.0/
-->
<!DOCTYPE html>

<head>
    <base href="{{ asset('') }}">
    <title>Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="keywords"
        content="Visitors Responsive web template, Bootstrap Web Templates, Flat Web Templates, Android Compatible web template, 
	Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyEricsson, Motorola web design" />
    <script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
    <!-- bootstrap-css -->
    <link rel="stylesheet" href="back-end/css/bootstrap.min.css">
    <!-- //bootstrap-css -->
    <!-- Custom CSS -->
    <link href="back-end/css/style.css" rel='stylesheet' type='text/css' />
    <link href="back-end/css/style-responsive.css" rel="stylesheet" />
    <!-- font CSS -->
    <link
        href='//fonts.googleapis.com/css?family=Roboto:400,100,100italic,300,300italic,400italic,500,500italic,700,700italic,900,900italic'
        rel='stylesheet' type='text/css'>
    <!-- font-awesome icons -->
    <link rel="stylesheet" href="back-end/css/font.css" type="text/css" />
    <link href="back-end/css/font-awesome.css" rel="stylesheet">
    <link rel="stylesheet" href="back-end/css/morris.css" type="text/css" />
    <!-- calendar -->
    <link rel="stylesheet" href="back-end/css/monthly.css">
    <link rel="shortcut icon" href="back-end/images/logo.png">
    <link rel="icon" type="image/x-icon" href="back-end/images/logo.png" />
    <!-- //calendar -->
    <!-- //font-awesome icons -->
    <script src="back-end/js/raphael-min.js"></script>
    <script src="back-end/js/morris.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <script src="//cdn.ckeditor.com/4.20.1/full/ckeditor.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="sweetalert2.all.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
</head>

<body>
    <section id="container">
        <!--header start-->
        <header class="header fixed-top clearfix">
            <!--logo start-->
            <div class="brand">
                <a href="admin/tongquan" class="logo">
                    Admin
                </a>
                <div class="sidebar-toggle-box">
                    <div class="fa fa-bars"></div>
                </div>
            </div>
            <!--logo end-->

            <div class="top-nav clearfix">
                <!--search & user info start-->
                <ul class="nav pull-right top-menu">
                    <li>
                        <input type="text" class="form-control search" placeholder=" Search">
                    </li>
                    <!-- user login dropdown start-->
                    @if (session('admin'))
                        <li class="dropdown">
                            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                                @if (!empty(session('admin')->anhdaidien))
                                    <img class="imganhdaidien" src="upload/anhadmin/{{ session('admin')->anhdaidien }}"
                                        alt="">
                                @else
                                    <i class="fa-solid fa-user" style="font-size: 20px"></i>
                                @endif
                                <span class="username">{{ session('admin')->hoten }}</span>
                            </a>
                            <ul class="dropdown-menu extended logout">
                                <li><a href="admin/admin/thongtin/{{ session('admin')->id }}"><i
                                            class=" fa fa-suitcase"></i>Thông tin tài khoản</a></li>
                                <li><a href="admin/doimatkhau/{{ session('admin')->id }}"><i class="fa fa-cog"></i> Đổi
                                        mật khẩu</a></li>
                                <li><a href="/admin/dangxuat"><i class="fa fa-key"></i> Đăng Xuất</a></li>
                            </ul>
                        </li>
                    @endif
                    <!-- user login dropdown end -->

                </ul>
                <!--search & user info end-->
            </div>
        </header>
        <!--header end-->
        <!--sidebar start-->
        <aside>
            <div id="sidebar" class="nav-collapse">
                <!-- sidebar menu start-->
                <div class="leftside-navigation">
                    <ul class="sidebar-menu" id="nav-accordion">
                        <li>
                            <a class="active" href="admin/tongquan">
                                <i class="fa fa-dashboard"></i>
                                <span>Tổng quan</span>
                            </a>
                        </li>
                        @if (session('admin')->machucvu == 1)
                            <li class="sub-menu">
                                <a href="admin/admin/danhsach">
                                    <i class="fa-solid fa-users-gear"></i>
                                    <span>Quản Lí Tài Khoản</span>
                                </a>
                                <ul class="sub">
                                    <li><a href="admin/admin/danhsach">Danh Sách Tài Khoản</a></li>
                                    <li><a href="admin/admin/them">Thêm Tài Khoản</a></li>
                                </ul>
                            </li>
                            <li class="sub-menu">
                                <a href="admin/chucvu/danhsach">
                                    <i class="fa-solid fa-turn-up"></i>
                                    <span>Chức Vụ</span>
                                </a>
                                <ul class="sub">
                                    <li><a href="admin/chucvu/danhsach">Danh Sách Chức Vụ</a></li>
                                    <li><a href="admin/chucvu/them">Thêm Chức Vụ</a></li>
                                </ul>
                            </li>
                            <li class="sub-menu">
                                <a href="admin/khachhang/danhsach">
                                    <i class="fa-solid fa-user"></i>
                                    <span>Quản Lí Khách Hàng</span>
                                </a>
                                <ul class="sub">
                                    <li><a href="admin/khachhang/danhsach">Danh Sách Khách Hàng</a></li>
                                </ul>
                            </li>
                        @endif

                        <li class="sub-menu">
                            <a href="admin/danhmuc/danhsach">
                                <i class="fa fa-book"></i>
                                <span>Danh Mục Sản Phẩm</span>
                            </a>
                            <ul class="sub">
                                <li><a href="admin/danhmuc/danhsach">Danh sách</a></li>
                                <li><a href="admin/danhmuc/them">Thêm Danh Mục</a></li>
                            </ul>
                        </li>
                        <li class="sub-menu">
                            <a href="admin/sanpham/danhsach">
                                <i class="fa-solid fa-laptop"></i>
                                <span>Sản Phẩm</span>
                            </a>
                            <ul class="sub">
                                <li><a href="admin/sanpham/danhsach">Danh sách</a></li>
                                <li><a href="admin/sanpham/them">Thêm sản phẩm</a></li>
                            </ul>
                        </li>
                        <li class="sub-menu">
                            <a href="admin/giamgiasanpham/danhsach">
                                <i class="fa-solid fa-laptop"></i>
                                <span>Giảm Giá Sản Phẩm</span>
                            </a>
                            <ul class="sub">
                                <li><a href="admin/giamgiasanpham/danhsach">Danh sách giảm giá</a></li>
                                <li><a href="admin/giamgiasanpham/them">Thêm sản phẩm giảm giá</a></li>
                            </ul>
                        </li>
                        <li class="sub-menu">
                            <a href="admin/khuyenmai/danhsach">
                                <i class="fa-solid fa-percent"></i>
                                <span>Mã Khuyến Mãi</span>
                            </a>
                            <ul class="sub">
                                <li><a href="admin/khuyenmai/danhsach">Xem Danh Sách</a></li>
                                <li><a href="admin/khuyenmai/them">Thêm Mã</a></li>
                            </ul>
                        </li>
                        <li class="sub-menu">
                            <a href="admin/donhang/danhsach">
                                <i class="fa-solid fa-laptop"></i>
                                <span>Đơn Hàng</span>
                            </a>
                            <ul class="sub">
                                <li><a href="admin/donhang/danglam">Đơn Hàng Đã Nhận</a></li>
                                <li><a href="admin/donhang/danhsach">Tất Cả Đơn Hàng</a></li>
                            </ul>
                        </li>
                        <li class="sub-menu">
                            <a href="admin/slide/danhsach">
                                <i class="fa-solid fa-sliders"></i>
                                <span>Slide</span>
                            </a>
                            <ul class="sub">
                                <li><a href="admin/slide/danhsach">Danh sách Slide</a></li>
                                <li><a href="admin/slide/them">Thêm Slide</a></li>
                            </ul>
                        </li>
                        <li class="sub-menu">
                            <a href="admin/theloaibaiviet/danhsach">
                                <i class="fa-solid fa-bookmark"></i>
                                <span>Thể Loại Bài Viết</span>
                            </a>
                            <ul class="sub">
                                <li><a href="admin/theloaibaiviet/danhsach">Danh sách Thể Loại</a></li>
                                <li><a href="admin/theloaibaiviet/them">Thêm Thể Loại</a></li>
                            </ul>
                        </li>
                        <li class="sub-menu">
                            <a href="admin/baiviet/danhsach">
                                <i class="fa-solid fa-book-open"></i>
                                <span>Bài Viết</span>
                            </a>
                            <ul class="sub">
                                <li><a href="admin/baiviet/danhsach">Danh sách Bài Viết </a></li>
                                <li><a href="admin/baiviet/them">Thêm Bài Viết </a></li>
                            </ul>
                        </li>
                        <li class="sub-menu">
                            <a href="admin/diachi/danhsach">
                                <i class="fa-sharp fa-solid fa-location-dot"></i>
                                <span>Địa Chỉ</span>
                            </a>
                            <ul class="sub">
                                <li><a href="admin/diachi/danhsach">Danh sách Địa Chỉ </a></li>
                                <li><a href="admin/diachi/them">Thêm Địa Chỉ </a></li>
                            </ul>
                        </li>
                        <li class="sub-menu">
                            <a href="admin/danhgia/danhsach">
                                <i class="fa-solid fa-comment"></i>
                                <span>Đánh Giá</span>
                            </a>
                            <ul class="sub">
                                <li><a href="admin/danhgia/danhsach">Xem Đánh Giá </a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="admin/thongke">
                                <i class="fa-solid fa-bars"></i>
                                <span>Thông Kê</span>
                            </a>
                        </li>
                    </ul>
                </div>
                <!-- sidebar menu end-->
            </div>
        </aside>
        <!--sidebar end-->
        <!--main content start-->
        <section id="main-content">
            <section class="wrapper">
                @yield('content')
            </section>
            <!-- footer -->
            <!-- / footer -->
        </section>
        <!--main content end-->
    </section>
    @yield('script')
    <script src="back-end/js/bootstrap.js"></script>
    <script src="back-end/js/jquery.dcjqaccordion.2.7.js"></script>
    <script src="back-end/js/scripts.js"></script>
    <script src="back-end/js/jquery.slimscroll.js"></script>
    <script src="back-end/js/jquery.nicescroll.js"></script>
    <!--[if lte IE 8]><script language="javascript" type="text/javascript" src="back-end/js/flot-chart/excanvas.min.js"></script><![endif]-->
    <script src="back-end/js/jquery.scrollTo.js"></script>
    <script type="text/javascript" language="javascript" src="ckeditor/ckeditor.js"></script>
    <!-- morris JavaScript -->
</body>

</html>
