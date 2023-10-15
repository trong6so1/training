<header id="header"><!--header-->
    {{-- <div class="header_top"><!--header_top-->
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                    <div class="contactinfo">
                        <ul class="nav nav-pills">
                            <li><a href="#"><i class="fa fa-phone"></i> +2 95 01 88 821</a></li>
                            <li><a href="#"><i class="fa fa-envelope"></i> info@domain.com</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="social-icons pull-right">
                        <ul class="nav navbar-nav">
                            <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                            <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                            <li><a href="#"><i class="fa fa-linkedin"></i></a></li>
                            <li><a href="#"><i class="fa fa-dribbble"></i></a></li>
                            <li><a href="#"><i class="fa fa-google-plus"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div><!--/header_top--> --}}
    
    <div class="header-middle"><!--header-middle-->
        <div class="container">
            <div class="row">
                <div class="col-sm-2">
                    <div class="logo pull-left">
                        <a href="/"><img class="logo" src="front-end/images/home/logo.png" alt="" /></a>
                    </div>
                    
                    {{-- <div class="btn-group pull-right">
                        <div class="btn-group">
                            <button type="button" class="btn btn-default dropdown-toggle usa" data-toggle="dropdown">
                                USA
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu">
                                <li><a href="#">Canada</a></li>
                                <li><a href="#">UK</a></li>
                            </ul>
                        </div>
                        
                        <div class="btn-group">
                            <button type="button" class="btn btn-default dropdown-toggle usa" data-toggle="dropdown">
                                DOLLAR
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu">
                                <li><a href="#">Canadian Dollar</a></li>
                                <li><a href="#">Pound</a></li>
                            </ul>
                        </div>
                    </div> --}}
                </div>
                <div class="col-sm-7 middleheader">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                    </div>
                    <div class="mainmenu pull-left">
                        <ul class="nav navbar-nav collapse navbar-collapse">
                            <li class="list-menu"><a href="trangchu">Trang Chủ</a></li>
                            <li class="dropdown list-menu"><a href="sanpham/{{ 1 }}">Shop<i class="fa fa-angle-down" style="opacity: 90%"></i></a>
                                <ul role="menu" class="sub-menu">
                                    @foreach ($danhmuc as $dm)
                                        <li><a href="danhmuc/{{ $dm->id }}/{{ 1 }}">{{ $dm->TenDanhMuc }}</a></li>
                                    @endforeach
                                </ul>
                            </li> 
                            <li class="dropdown"><a href="baiviet/{{ 1 }}">Tin Tức<i class="fa fa-angle-down" style="opacity: 90%"></i></a>
                                <ul role="menu" class="sub-menu">
                                    @foreach ($theloaibaiviet as $tl)
                                        @if (count($tl->BaiViet)>0)
                                            <li><a href="baiviet/{{ $tl->id }}/{{ 1 }}">{{ $tl->tentheloai }}</a></li>
                                        @endif
                                    @endforeach
                                    
                                </ul>
                            </li>
                            <li class="dropdown list-menu"><a href="thongbao/donhang/tatca">Đơn Hàng<i class="fa fa-angle-down" style="opacity: 90%"></i></a>
                                <ul role="menu" class="sub-menu" id="sub-menu">
                                    <li><a href="thongbao/donhang/{{ 0 }}">Đang Chờ Xác Nhận</a></li>
                                    <li><a href="thongbao/donhang/{{ 1 }}">Đang Chờ Giao Hàng</a></li>
                                    <li><a href="thongbao/donhang/{{ 3 }}">Đơn Hàng Đã Hoàn Thành</a></li>
                                    <li><a href="thongbao/donhang/{{ -1 }}">Đơn Hàng Hủy</a></li>
                                    <li><a href="thongbao/donhang/danhgia">Đơn Hàng Chưa Đánh Giá</a></li>
                                    <li><a href="thongbao/donhang/xemdanhgia">Đơn Hàng Đã Đánh Giá</a></li>
                                    <li><a href="thongbao/donhang/tatca">Tất Cả Đơn Hàng</a></li>
                                </ul>
                            </li>
                            <li class="dropdown list-menu"><a href="thongbao/tatca" id="thongbao" 
                                @if (session('khachhang'))
                                    data-id="{{ session('khachhang')->id }}"
                                @endif>
                            Thông Báo<i class="fa fa-angle-down"></i></a>
                                <ul role="menu" class="sub-menu" id="sub-menu-thongbao">
                                    
                                </ul>
                            </li> 
                        </ul>
                    </div>
                </div>
                <div class="col-sm-3 pull-right">
                    <div class="shop-menu pull-right">
                        <ul class="nav navbar-nav">
                            <li><a href="giohang"><i class="fa fa-shopping-cart"></i> Giỏ Hàng</a></li>
                            @if (session('khachhang'))
                                @if (session('khachhang')->anhdaidien)
                                    <li><a href="thongbao/taikhoan/xemthongtin"><img src="upload/anhkhachhang/{{ session('khachhang')->anhdaidien }}"> {{ session('khachhang')->tennguoidung }}</a></li>
                                @else
                                    <li><a href="thongbao/taikhoan/xemthongtin"><i class="fa fa-user"></i> {{ session('khachhang')->tennguoidung }}</a></li>
                                @endif
                                <li><a href="dangxuat"><i class="fa fa-lock"></i> Đăng Xuất</a></li>
                            @else
                                {{-- <li><a href="#"><i class="fa fa-user"></i> Tài Khoản</a></li> --}}
                                <li><a href="login"><i class="fa fa-lock"></i> Đăng Nhập</a></li>
                            @endif
                            
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div><!--/header-middle-->
</header><!--/header-->
<script>
    $(document).ready(function () {
        $("#thongbao").mouseover(function () {
            if($("#thongbao").data('id') == null){
                $(".thong-bao").remove();
                $("#sub-menu-thongbao").append("<li class='thong-bao'><a href='login' id='sub-menu-thongbao-content-item1'>Vui lòng Đăng Nhập Để Xem Thông Báo</a></li>");
            }
            else{
                $(".thong-bao").remove();
                $.get("kiemtrathongbao",
                function (data) {
                    data.forEach(thongbao => {
                        var html = "<li class='thong-bao' id='sub-menu-thongbao-li'><img id='sub-menu-thongbao-img' src='upload/"+thongbao['hinhanh']+"'><div id='sub-menu-thongbao-content'><span id='sub-menu-thongbao-content-item1'>"+thongbao['tieude']+"</span><div id='sub-menu-thongbao-content-item2'>"+thongbao['noidung']+"</div></div></li>"
                        $("#sub-menu-thongbao").append(html);
                    });
                },
                );
            }
        });  
    });
</script>