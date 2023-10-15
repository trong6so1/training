@extends('layout.main')
@section('content')
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
    <section id="slider">
        <!--slider-->
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div id="slider-carousel" class="carousel slide" data-ride="carousel">
                        <ol class="carousel-indicators">
                            <li data-target="#slider-carousel" data-slide-to="0" class="active"></li>
                            @for ($i = 0; $i < count($slide); $i++)
                                <li data-target="#slider-carousel" data-slide-to="{{ $i }}"></li>
                            @endfor
                        </ol>

                        <div class="carousel-inner">
                            <div class="item active">
                                <div class="col-sm-12">
                                    <img src="upload/slide/{{ $slidenoibat->anh }}" class="girl img-responsive"
                                        alt="" />
                                </div>
                            </div>
                            @foreach ($slide as $sl)
                                <div class="item">
                                    <div class="col-sm-12">
                                        <img src="upload/slide/{{ $sl->anh }}" class="girl img-responsive"
                                            alt="" />
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <a href="#slider-carousel" class="left control-carousel hidden-xs" data-slide="prev">
                            <i class="fa fa-angle-left"></i>
                        </a>
                        <a href="#slider-carousel" class="right control-carousel hidden-xs" data-slide="next">
                            <i class="fa fa-angle-right"></i>
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </section>
    <!--/slider-->

    <section>
        <div class="container">
            <div class="breadcrumbs">
                <ol class="breadcrumb">
                    <li><a href="trangchu">Trang Chủ</a></li>
                    <li class="active">Sản Phẩm</li>
                        <div class="search_box pull-right">
                                <input type="text" name="timkiem" id="timkiem" placeholder="Tìm Sản Phẩm"/>
                        </div>
                </ol>
                
            </div>
            <div class="row">
                @include('layout.menu')
                <div class="col-sm-9 padding-right">
                    <div class="features_items">
                        <!--features_items-->
                        <h2 class="title text-center">Sản Phẩm</h2>
                        @foreach ($sanpham as $sp)
                            <div class="col-sm-4">
                                <div class="product-image-wrapper">
                                    <div class="single-products">
                                        <a href="chitietsanpham/{{ $sp->id }}">
                                            <div class="productinfo text-center">
                                                <img src="upload/sanpham/{{ $sp->Hinh }}" alt="" />
                                                <span class="text_product">{{ $sp->TenSanPham }}</span>
                                                <span class="text_product2">{{ number_format($sp->Gia) . ' VNĐ' }}</span>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="choose">
                                        <ul class="nav nav-pills nav-justified">
                                            <li><a href="giohang/themvaogio/{{ $sp->id }}"><i
                                                        class="fa fa-shopping-cart"></i>Thêm Vào Giỏ Hàng</a></li>
                                            <li><a href="muangay/{{ $sp->id }}"><i
                                                        class="fa-solid fa-sack-dollar"></i>Mua Ngay</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <!--features_items-->
                    <div class="pagination-area">
                        <ul class="pagination">
                            <?php
                            $sotrang = (int) $sosanpham % 9 == 0 ? $sosanpham / 9 : $sosanpham / 9 + 1;
                            ?>
                            @for ($i = 1; $i <= $sotrang; $i++)
                                <li><a href="sanpham/{{ $i }}" class="active">{{ $i }}</a></li>
                            @endfor
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('script')
    <script>
        $(document).ready(function () {
            $("#timkiem").keyup(function (e) {
                $(".pagination-area").remove();
                if($("#timkiem").val()!="")
                    $url = "timkiemsanpham/"+$("#timkiem").val();
                else{
                    $url = "timkiemsanpham/-1";
                } 
                $.get($url,
                    function (data) {
                        $(".features_items").html(data);
                    },
                );
            });
        });
    </script>
@endsection
