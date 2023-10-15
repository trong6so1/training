@extends('layout.main')
@section('seo')
    <meta name="description" content="{{ $chitietsanpham->MoTa }}">
    <meta name="keywords" content="{{ $chitietsanpham->TuKhoa }}" />
    <meta property="og:image" content="upload/sanpham/{{ $chitietsanpham->Hinh }}" />
    <meta property="og:site_name" content="{{ url()->current() }}" />
    <meta property="og:description" content="{{ $chitietsanpham->Desc }}" />
    <meta property="og:title" content="{{ $chitietsanpham->TenSanPham }}" />
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:type" content="website" />
@endsection
@section('content')
    <section>
        @if (count($errors) > 0)
            <div class="alert alert-danger">
                @foreach ($errors->all() as $err)
                    {{ $err }}<br />
                @endforeach
            </div>
        @endif
        @if (session('thatbai'))
            <script>
                Swal.fire("Lỗi", "{{ session('thatbai') }}", "error", {
                    button: "OK",
                })
            </script>
        @endif
        @if (session('thanhcong'))
            <script>
                Swal.fire("Thành Công", "{{ session('thanhcong') }}", "success", {
                    button: "OK",
                })
            </script>
        @endif
        <div class="container">
            <div class="row">
                <div class="breadcrumbs">
                    <ol class="breadcrumb">
                        <li><a href="trangchu">Home</a></li>
                        <li><a
                                href="danhmuc/{{ $chitietsanpham->DanhMuc->id }}/{{ 1 }}">{{ $chitietsanpham->DanhMuc->TenDanhMuc }}</a>
                        </li>
                        <li class="active">{{ $chitietsanpham->TenSanPham }}</li>
                    </ol>
                </div>
                <!--/breadcrums-->
                @include('layout.menu')

                <div class="col-sm-9 padding-right">

                    <div class="product-details">
                        <!--product-details-->
                        <div class="col-sm-5">
                            <div class="view-product">
                                <img src="upload/sanpham/{{ $chitietsanpham->Hinh }}" alt="" />
                            </div>
                        </div>
                        <div class="col-sm-7">
                            <div class="product-information">
                                <!--/product-information-->
                                {{-- <img src="front-end/images/product-details/new.jpg" class="newarrival" alt="" /> --}}
                                <h2>{{ $chitietsanpham->TenSanPham }}</h2>
                                <p>Mã Sản Phẩm: {{ $chitietsanpham->id }}</p>
                                <div>
                                    <div>
                                        <h4>Gia:{{ number_format($chitietsanpham->Gia) . ' VNĐ' }}</h4>
                                    </div>
                                    <form action="/giohang/themvaogio/{{ $chitietsanpham->id }}" method="POST"
                                        enctype="multipart/form-data">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <label>số lượng:</label>
                                        <input type="number" name="SoLuong" min="1" value="1" />
                                        <input type="submit" class="btn btn-fefault cart" value="Thêm Vào Giỏ Hàng">
                                    </form>
                                </div>
                                <p><b>Trạng Thái:</b> Còn hàng</p>
                                <p><b>Tình Trạng</b> Mới 100%</p>
                                <div class="fb-share-button" data-href="{{ url()->current() }}" data-layout="button_count"
                                    data-size="small"><a target="_blank"
                                        href="https://www.facebook.com/sharer/sharer.php?u={{ url()->current() }}&amp;src=sdkpreparse"
                                        class="fb-xfbml-parse-ignore">Chia sẻ</a>
                                </div>
                                <p><b>Danh Mục Sản Phẩm</b> {{ $chitietsanpham->DanhMuc->TenDanhMuc }}</p>
                            </div>
                            <!--/product-information-->
                        </div>
                    </div>
                    <!--/product-details-->
                    <div class="category-tab shop-details-tab">
                        <!--category-tab-->
                        <div class="col-sm-12">
                            <ul class="nav nav-tabs" id="category-tab">
                                <li class="active"><a href="#details" data-toggle="tab">Chi Tiết</a></li>
                                <li><a href="#reviews" data-toggle="tab">Xem Đánh Giá</a></li>
                            </ul>
                        </div>
                        <div class="tab-content">
                            <div class="tab-pane fade active in" id="details">
                                <p>{!! $chitietsanpham->MoTa !!}</p>
                            </div>
                            <div class="tab-pane fade" id="reviews">
                                @if (count($danhgia[0]) > 0)
                                    <div class="rating-area">
                                        <ul class="ratings">
                                            <li class="rate-this">Đánh Giá:</li>
                                            <li>
                                                @for ($i = 1; $i <= 5; $i++)
                                                    @if ($saotrungbinh >= $i)
                                                        <i class="fa fa-star color"></i>
                                                    @else
                                                        <i class="fa fa-star"></i>
                                                    @endif
                                                @endfor
                                            </li>
                                            <li class="color">({{ $saotrungbinh }} <i class="fa fa-star color"></i>)</li>
                                        </ul>
                                    </div>
                                    <!--/rating-area-->
                                    {{-- Đánh Giá --}}
                                    <div class="response-area">

                                        <h2>{{ count($danhgia[0]) }} Lượt Đánh Giá</h2>

                                        <div class="category-tab shop-details-tab">
                                            <!--category-tab-->
                                            <div class="col-sm-12">
                                                <ul class="nav nav-tabs">
                                                    <li class="active"><a href="#tatca" data-toggle="tab">Tất Cả</a></li>
                                                    <li><a href="#1sao" data-toggle="tab">1 Sao</a></li>
                                                    <li><a href="#2sao" data-toggle="tab">2 Sao</a></li>
                                                    <li><a href="#3sao" data-toggle="tab">3 Sao</a></li>
                                                    <li><a href="#4sao" data-toggle="tab">4 Sao</a></li>
                                                    <li><a href="#5sao" data-toggle="tab">5 Sao</a></li>

                                                </ul>
                                            </div>
                                            <div class="tab-content">
                                                <div class="tab-pane fade in" id="tatca">
                                                    <ul class="media-list">
                                                        @foreach ($danhgia[0] as $dg)
                                                            <div>
                                                                <li class="media">
                                                                    <div class="pull-left">
                                                                        @if (empty($dg->NguoiDang->anhdaidien))
                                                                            <img class="media-object"
                                                                                src="upload/anhkhachhang/macdinh.png"
                                                                                alt="">
                                                                        @else
                                                                            <img class="media-object"
                                                                                src="upload/anhkhachhang/{{ $dg->NguoiDang->anhdaidien }}"
                                                                                alt="">
                                                                        @endif
                                                                    </div>
                                                                    <div class="media-body">
                                                                        <ul class="sinlge-post-meta">

                                                                            <li><i
                                                                                    class="fa fa-user"></i>{{ $dg->NguoiDang->tennguoidung }}
                                                                            </li>
                                                                            <?php
                                                                            $ngaydang = explode(' ', $dg->ngaydang);
                                                                            ?>
                                                                            <li><i class="fa fa-clock-o"></i>
                                                                                {{ $ngaydang[1] }}</li>
                                                                            <li><i class="fa fa-calendar"></i>
                                                                                {{ $ngaydang[0] }}</li>

                                                                        </ul>
                                                                        <span class="danhgiasanpham">
                                                                            @for ($i = 1; $i <= 5; $i++)
                                                                                @if ($dg->sosao >= $i)
                                                                                    <i class="fa fa-star color"></i>
                                                                                @else
                                                                                    <i class="fa fa-star"></i>
                                                                                @endif
                                                                            @endfor
                                                                        </span>

                                                                        <p>{!! $dg->noidung !!}</p>
                                                                    </div>
                                                                </li>
                                                            </div>
                                                            @if ($dg->TraLoi)
                                                                <li class="media second-media">
                                                                    <div class="pull-left">
                                                                        <img class="media-object"
                                                                            src="back-end/images/logo.jpg" alt="">
                                                                    </div>
                                                                    <div class="media-body">
                                                                        <ul class="sinlge-post-meta">

                                                                            <li><i class="fa fa-user"></i>Shop Đồ Uống</li>
                                                                            <?php
                                                                            $ngaydang = explode(' ', $dg->TraLoi->ngaydang);
                                                                            ?>
                                                                            <li><i class="fa fa-clock-o"></i>
                                                                                {{ $ngaydang[1] }}</li>
                                                                            <li><i class="fa fa-calendar"></i>
                                                                                {{ $ngaydang[0] }}</li>

                                                                        </ul>
                                                                        <p>{!! $dg->TraLoi->noidung !!}</p>
                                                                    </div>
                                                                </li>
                                                            @endif
                                                        @endforeach
                                                    </ul>
                                                </div>
                                                <div class="tab-pane fade active in" id="1sao">
                                                    <ul class="media-list">
                                                        @foreach ($danhgia[1] as $dg)
                                                            <div>
                                                                <li class="media">
                                                                    <div class="pull-left">
                                                                        @if (empty($dg->NguoiDang->anhdaidien))
                                                                            <img class="media-object"
                                                                                src="upload/anhkhachhang/macdinh.png"
                                                                                alt="">
                                                                        @else
                                                                            <img class="media-object"
                                                                                src="upload/anhkhachhang/{{ $dg->NguoiDang->anhdaidien }}"
                                                                                alt="">
                                                                        @endif
                                                                    </div>
                                                                    <div class="media-body">
                                                                        <ul class="sinlge-post-meta">

                                                                            <li><i
                                                                                    class="fa fa-user"></i>{{ $dg->NguoiDang->tennguoidung }}
                                                                            </li>
                                                                            <?php
                                                                            $ngaydang = explode(' ', $dg->ngaydang);
                                                                            ?>
                                                                            <li><i class="fa fa-clock-o"></i>
                                                                                {{ $ngaydang[1] }}</li>
                                                                            <li><i class="fa fa-calendar"></i>
                                                                                {{ $ngaydang[0] }}</li>

                                                                        </ul>
                                                                        <span class="danhgiasanpham">
                                                                            @for ($i = 1; $i <= 5; $i++)
                                                                                @if ($dg->sosao >= $i)
                                                                                    <i class="fa fa-star color"></i>
                                                                                @else
                                                                                    <i class="fa fa-star"></i>
                                                                                @endif
                                                                            @endfor
                                                                        </span>

                                                                        <p>{!! $dg->noidung !!}</p>
                                                                    </div>
                                                                </li>
                                                            </div>
                                                            @if ($dg->TraLoi)
                                                                <li class="media second-media">
                                                                    <div class="pull-left">
                                                                        <img class="media-object"
                                                                            src="back-end/images/logo.jpg" alt="">
                                                                    </div>
                                                                    <div class="media-body">
                                                                        <ul class="sinlge-post-meta">

                                                                            <li><i class="fa fa-user"></i>Shop Đồ Uống</li>
                                                                            <?php
                                                                            $ngaydang = explode(' ', $dg->TraLoi->ngaydang);
                                                                            ?>
                                                                            <li><i class="fa fa-clock-o"></i>
                                                                                {{ $ngaydang[1] }}</li>
                                                                            <li><i class="fa fa-calendar"></i>
                                                                                {{ $ngaydang[0] }}</li>

                                                                        </ul>
                                                                        <p>{!! $dg->TraLoi->noidung !!}</p>
                                                                    </div>
                                                                </li>
                                                            @endif
                                                        @endforeach
                                                    </ul>
                                                </div>
                                                <div class="tab-pane fade active in" id="2sao">
                                                    <ul class="media-list">
                                                        @foreach ($danhgia[2] as $dg)
                                                            <div>
                                                                <li class="media">
                                                                    <div class="pull-left">
                                                                        @if (empty($dg->NguoiDang->anhdaidien))
                                                                            <img class="media-object"
                                                                                src="upload/anhkhachhang/macdinh.png"
                                                                                alt="">
                                                                        @else
                                                                            <img class="media-object"
                                                                                src="upload/anhkhachhang/{{ $dg->NguoiDang->anhdaidien }}"
                                                                                alt="">
                                                                        @endif
                                                                    </div>
                                                                    <div class="media-body">
                                                                        <ul class="sinlge-post-meta">

                                                                            <li><i
                                                                                    class="fa fa-user"></i>{{ $dg->NguoiDang->tennguoidung }}
                                                                            </li>
                                                                            <?php
                                                                            $ngaydang = explode(' ', $dg->ngaydang);
                                                                            ?>
                                                                            <li><i class="fa fa-clock-o"></i>
                                                                                {{ $ngaydang[1] }}</li>
                                                                            <li><i class="fa fa-calendar"></i>
                                                                                {{ $ngaydang[0] }}</li>

                                                                        </ul>
                                                                        <span class="danhgiasanpham">
                                                                            @for ($i = 1; $i <= 5; $i++)
                                                                                @if ($dg->sosao >= $i)
                                                                                    <i class="fa fa-star color"></i>
                                                                                @else
                                                                                    <i class="fa fa-star"></i>
                                                                                @endif
                                                                            @endfor
                                                                        </span>

                                                                        <p>{!! $dg->noidung !!}</p>
                                                                    </div>
                                                                </li>
                                                            </div>
                                                            @if ($dg->TraLoi)
                                                                <li class="media second-media">
                                                                    <div class="pull-left">
                                                                        <img class="media-object"
                                                                            src="back-end/images/logo.jpg" alt="">
                                                                    </div>
                                                                    <div class="media-body">
                                                                        <ul class="sinlge-post-meta">

                                                                            <li><i class="fa fa-user"></i>Shop Đồ Uống</li>
                                                                            <?php
                                                                            $ngaydang = explode(' ', $dg->TraLoi->ngaydang);
                                                                            ?>
                                                                            <li><i class="fa fa-clock-o"></i>
                                                                                {{ $ngaydang[1] }}</li>
                                                                            <li><i class="fa fa-calendar"></i>
                                                                                {{ $ngaydang[0] }}</li>

                                                                        </ul>
                                                                        <p>{!! $dg->TraLoi->noidung !!}</p>
                                                                    </div>
                                                                </li>
                                                            @endif
                                                        @endforeach
                                                    </ul>
                                                </div>
                                                <div class="tab-pane fade active in" id="3sao">
                                                    <ul class="media-list">
                                                        @foreach ($danhgia[3] as $dg)
                                                            <div>
                                                                <li class="media">
                                                                    <div class="pull-left">
                                                                        @if (empty($dg->NguoiDang->anhdaidien))
                                                                            <img class="media-object"
                                                                                src="upload/anhkhachhang/macdinh.png"
                                                                                alt="">
                                                                        @else
                                                                            <img class="media-object"
                                                                                src="upload/anhkhachhang/{{ $dg->NguoiDang->anhdaidien }}"
                                                                                alt="">
                                                                        @endif
                                                                    </div>
                                                                    <div class="media-body">
                                                                        <ul class="sinlge-post-meta">

                                                                            <li><i
                                                                                    class="fa fa-user"></i>{{ $dg->NguoiDang->tennguoidung }}
                                                                            </li>
                                                                            <?php
                                                                            $ngaydang = explode(' ', $dg->ngaydang);
                                                                            ?>
                                                                            <li><i class="fa fa-clock-o"></i>
                                                                                {{ $ngaydang[1] }}</li>
                                                                            <li><i class="fa fa-calendar"></i>
                                                                                {{ $ngaydang[0] }}</li>

                                                                        </ul>
                                                                        <span class="danhgiasanpham">
                                                                            @for ($i = 1; $i <= 5; $i++)
                                                                                @if ($dg->sosao >= $i)
                                                                                    <i class="fa fa-star color"></i>
                                                                                @else
                                                                                    <i class="fa fa-star"></i>
                                                                                @endif
                                                                            @endfor
                                                                        </span>

                                                                        <p>{!! $dg->noidung !!}</p>
                                                                    </div>
                                                                </li>
                                                            </div>
                                                            @if ($dg->TraLoi)
                                                                <li class="media second-media">
                                                                    <div class="pull-left">
                                                                        <img class="media-object"
                                                                            src="back-end/images/logo.jpg" alt="">
                                                                    </div>
                                                                    <div class="media-body">
                                                                        <ul class="sinlge-post-meta">

                                                                            <li><i class="fa fa-user"></i>Shop Đồ Uống</li>
                                                                            <?php
                                                                            $ngaydang = explode(' ', $dg->TraLoi->ngaydang);
                                                                            ?>
                                                                            <li><i class="fa fa-clock-o"></i>
                                                                                {{ $ngaydang[1] }}</li>
                                                                            <li><i class="fa fa-calendar"></i>
                                                                                {{ $ngaydang[0] }}</li>

                                                                        </ul>
                                                                        <p>{!! $dg->TraLoi->noidung !!}</p>
                                                                    </div>
                                                                </li>
                                                            @endif
                                                        @endforeach
                                                    </ul>
                                                </div>
                                                <div class="tab-pane fade active in" id="4sao">
                                                    <ul class="media-list">
                                                        @foreach ($danhgia[4] as $dg)
                                                            <div>
                                                                <li class="media">
                                                                    <div class="pull-left">
                                                                        @if (empty($dg->NguoiDang->anhdaidien))
                                                                            <img class="media-object"
                                                                                src="upload/anhkhachhang/macdinh.png"
                                                                                alt="">
                                                                        @else
                                                                            <img class="media-object"
                                                                                src="upload/anhkhachhang/{{ $dg->NguoiDang->anhdaidien }}"
                                                                                alt="">
                                                                        @endif
                                                                    </div>
                                                                    <div class="media-body">
                                                                        <ul class="sinlge-post-meta">

                                                                            <li><i
                                                                                    class="fa fa-user"></i>{{ $dg->NguoiDang->tennguoidung }}
                                                                            </li>
                                                                            <?php
                                                                            $ngaydang = explode(' ', $dg->ngaydang);
                                                                            ?>
                                                                            <li><i class="fa fa-clock-o"></i>
                                                                                {{ $ngaydang[1] }}</li>
                                                                            <li><i class="fa fa-calendar"></i>
                                                                                {{ $ngaydang[0] }}</li>

                                                                        </ul>
                                                                        <span class="danhgiasanpham">
                                                                            @for ($i = 1; $i <= 5; $i++)
                                                                                @if ($dg->sosao >= $i)
                                                                                    <i class="fa fa-star color"></i>
                                                                                @else
                                                                                    <i class="fa fa-star"></i>
                                                                                @endif
                                                                            @endfor
                                                                        </span>

                                                                        <p>{!! $dg->noidung !!}</p>
                                                                    </div>
                                                                </li>
                                                            </div>
                                                            @if ($dg->TraLoi)
                                                                <li class="media second-media">
                                                                    <div class="pull-left">
                                                                        <img class="media-object"
                                                                            src="back-end/images/logo.jpg" alt="">
                                                                    </div>
                                                                    <div class="media-body">
                                                                        <ul class="sinlge-post-meta">

                                                                            <li><i class="fa fa-user"></i>Shop Đồ Uống</li>
                                                                            <?php
                                                                            $ngaydang = explode(' ', $dg->TraLoi->ngaydang);
                                                                            ?>
                                                                            <li><i class="fa fa-clock-o"></i>
                                                                                {{ $ngaydang[1] }}</li>
                                                                            <li><i class="fa fa-calendar"></i>
                                                                                {{ $ngaydang[0] }}</li>

                                                                        </ul>
                                                                        <p>{!! $dg->TraLoi->noidung !!}</p>
                                                                    </div>
                                                                </li>
                                                            @endif
                                                        @endforeach
                                                    </ul>
                                                </div>
                                                <div class="tab-pane fade active in" id="5sao">
                                                    <ul class="media-list">
                                                        @foreach ($danhgia[5] as $dg)
                                                            <div>
                                                                <li class="media">
                                                                    <div class="pull-left">
                                                                        @if (empty($dg->NguoiDang->anhdaidien))
                                                                            <img class="media-object"
                                                                                src="upload/anhkhachhang/macdinh.png"
                                                                                alt="">
                                                                        @else
                                                                            <img class="media-object"
                                                                                src="upload/anhkhachhang/{{ $dg->NguoiDang->anhdaidien }}"
                                                                                alt="">
                                                                        @endif
                                                                    </div>
                                                                    <div class="media-body">
                                                                        <ul class="sinlge-post-meta">

                                                                            <li><i
                                                                                    class="fa fa-user"></i>{{ $dg->NguoiDang->tennguoidung }}
                                                                            </li>
                                                                            <?php
                                                                            $ngaydang = explode(' ', $dg->ngaydang);
                                                                            ?>
                                                                            <li><i class="fa fa-clock-o"></i>
                                                                                {{ $ngaydang[1] }}</li>
                                                                            <li><i class="fa fa-calendar"></i>
                                                                                {{ $ngaydang[0] }}</li>

                                                                        </ul>
                                                                        <span class="danhgiasanpham">
                                                                            @for ($i = 1; $i <= 5; $i++)
                                                                                @if ($dg->sosao >= $i)
                                                                                    <i class="fa fa-star color"></i>
                                                                                @else
                                                                                    <i class="fa fa-star"></i>
                                                                                @endif
                                                                            @endfor
                                                                        </span>

                                                                        <p>{!! $dg->noidung !!}</p>
                                                                    </div>
                                                                </li>
                                                            </div>
                                                            @if ($dg->TraLoi)
                                                                <li class="media second-media">
                                                                    <div class="pull-left">
                                                                        <img class="media-object"
                                                                            src="back-end/images/logo.jpg" alt="">
                                                                    </div>
                                                                    <div class="media-body">
                                                                        <ul class="sinlge-post-meta">

                                                                            <li><i class="fa fa-user"></i>Shop Đồ Uống</li>
                                                                            <?php
                                                                            $ngaydang = explode(' ', $dg->TraLoi->ngaydang);
                                                                            ?>
                                                                            <li><i class="fa fa-clock-o"></i>
                                                                                {{ $ngaydang[1] }}</li>
                                                                            <li><i class="fa fa-calendar"></i>
                                                                                {{ $ngaydang[0] }}</li>

                                                                        </ul>
                                                                        <p>{!! $dg->TraLoi->noidung !!}</p>
                                                                    </div>
                                                                </li>
                                                            @endif
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <!--/category-tab-->
                                    </div>
                                    <!--/Response-area-->
                                @else
                                    <h4>Chưa Có Lượt Đánh Giá</h4>
                                @endif
                            </div>
                        </div>
                    </div>
                    <!--/category-tab-->


                    @if (count($sanphamlienquan) > 0)
                        <div class="features_items" id="sanphamgiamgia">
                            <!--features_items-->
                            <h2 class="title text-center">Sản Phẩm Liên Quan</h2>
                            <div id="recommended-item-carousel1" class="carousel slide" data-ride="carousel">
                                <div class="carousel-inner">
                                    <div class="item active">
                                        <?php if (count($sanphamlienquan) > 3) {
                                            $count = 3;
                                        } else {
                                            $count = count($sanphamlienquan);
                                        }
                                        
                                        ?>
                                        @for ($i = 0; $i < $count; $i++)
                                            <div class="col-sm-4">
                                                <div class="product-image-wrapper">
                                                    <div class="single-products">
                                                        <div class="productinfo text-center">
                                                            <a href="chitietsanpham/{{ $sanphamlienquan[$i]->id }}">
                                                                <img src="upload/sanpham/{{ $sanphamlienquan[$i]->Hinh }}"
                                                                    alt="" />
                                                                <h4 class="text_product"
                                                                    href="chitietsanpham/{{ $sanphamlienquan[$i]->id }}">
                                                                    {{ $sanphamlienquan[$i]->TenSanPham }}</h4>
                                                                <h4 class="price_sale">
                                                                    {{ number_format($sanphamlienquan[$i]->Gia) . ' VNĐ' }}
                                                                </h4>
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div class="choose">
                                                        <ul class="nav nav-pills nav-justified">
                                                            {{-- <li><a href="giohang/themvaogio/{{ $sanphambannhieu[$i]->id }}"><i class="fa fa-shopping-cart"></i>Thêm Vào Giỏ Hàng</a></li> --}}
                                                            <li><a
                                                                    href="giohang/themvaogio/{{ $sanphamlienquan[$i]->id }}"><i
                                                                        class="fa fa-shopping-cart"></i>Thêm Vào Giỏ
                                                                    Hàng</a></li>
                                                            <li><a href="muangay/{{ $sanphamlienquan[$i]->id }}"><i
                                                                        class="fa-solid fa-sack-dollar"></i>Mua Ngay</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        @endfor

                                    </div>
                                    @if (count($sanphamlienquan) > 3)
                                        <?php
                                        $sotrang = count($sanphamlienquan) % 3 == 0 ? count($sanphamlienquan) / 3 - 1 : count($sanphamlienquan) / 3;
                                        ?>
                                        @for ($n = 1; $n <= $sotrang; $n++)
                                            <div class="item">
                                                @for ($i = 3 * $n; $i <= 3 * $n + 2; $i++)
                                                    @if (isset($sanphamlienquan[$i]))
                                                        <div class="col-sm-4">
                                                            <div class="product-image-wrapper">
                                                                <div class="single-products">
                                                                    <div class="productinfo text-center">
                                                                        <a
                                                                            href="chitietsanpham/{{ $sanphamlienquan[$i]->id }}">
                                                                            <img src="upload/sanpham/{{ $sanphamlienquan[$i]->Hinh }}"
                                                                                alt="" />
                                                                            <h4
                                                                                href="chitietsanpham/{{ $sanphamlienquan[$i]->id }}">
                                                                                {{ $sanphamlienquan[$i]->TenSanPham }}</h4>
                                                                            <h4 class="price_sale">
                                                                                {{ number_format($sanphamlienquan[$i]->Gia) . ' VNĐ' }}
                                                                            </h4>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                                <div class="choose">
                                                                    <ul class="nav nav-pills nav-justified">
                                                                        {{-- <li><a href="giohang/themvaogio/{{ $sanphambannhieu[$i]->id }}"><i class="fa fa-shopping-cart"></i>Thêm Vào Giỏ Hàng</a></li> --}}
                                                                        <li><a
                                                                                href="giohang/themvaogio/{{ $sanphamlienquan[$i]->id }}"><i
                                                                                    class="fa fa-shopping-cart"></i>Thêm
                                                                                Vào
                                                                                Giỏ
                                                                                Hàng</a></li>
                                                                        <li><a
                                                                                href="muangay/{{ $sanphamlienquan[$i]->id }}"><i
                                                                                    class="fa-solid fa-sack-dollar"></i>Mua
                                                                                Ngay</a></li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                @endfor
                                            </div>
                                        @endfor

                                </div>
                                <a class="left recommended-item-control" href="#recommended-item-carousel1"
                                    data-slide="prev">
                                    <i class="fa fa-angle-left"></i>
                                </a>
                                <a class="right recommended-item-control" href="#recommended-item-carousel1"
                                    data-slide="next">
                                    <i class="fa fa-angle-right"></i>
                                </a>
                    @endif

                </div>
            </div>
            <!--features_items-->
            @endif
        </div>
        </div>
        </div>
    </section>
@endsection
