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
                    <li class="active">Sản Phẩm Giảm Giá</li>
                </ol>
            </div>
            <div class="row">
                @include('layout.menu')
                <div class="col-sm-9 padding-right">
                    <div class="features_items">
                        <!--features_items-->
                        @if (count($giamgia) > 0)
                            <h2 class="title text-center" id="titlegiamgia">Sản Phẩm Giảm Giá</h2>
                            @foreach ($giamgia as $gg)
                                <div class="col-sm-4 giamgiasanpham">
                                    <div class="product-image-wrapper">
                                        <div class="single-products">
                                            <div class="productinfo text-center">
                                                <img src="upload/sanpham/{{ $gg->SanPham->Hinh }}" alt="" />
                                                <span class="text_product">{{ $gg->SanPham->TenSanPham }}</span>
                                                <div class="content_price_sale">
                                                    <p class="price_none_sale">{{ number_format($gg->SanPham->Gia) . ' VNĐ' }}
                                                    </p>
                                                    <h4 class="price_sale">{{ number_format($gg->giakhuyenmai) . ' VNĐ' }}
                                                    </h4>
                                                    <p><?php
                                                    date_default_timezone_set('Asia/Ho_Chi_Minh');
                                                    $giohientai = date_create(date('Y-m-d H:i:s'));
                                                    $chenhlech = date_create($gg->ngayketthuc)->diff($giohientai);
                                                    if ($chenhlech->d > 0) {
                                                        echo $chenhlech->d . ' Ngày';
                                                    } else {
                                                        echo $chenhlech->h . ':' . $chenhlech->i . ':' . $chenhlech->s . ' ';
                                                    }
                                                    ?>
                                                        &nbsp;&nbsp;&nbsp;&nbsp;<b>Số Lượng Còn:{{ $gg->soluong }}</b>
                                                    </p>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="choose">
                                            <ul class="nav nav-pills nav-justified">
                                                <li><a href="giohang/themgiamgiavaogio/{{ $gg->id }}"><i
                                                            class="fa fa-shopping-cart"></i>Thêm Vào Giỏ Hàng</a></li>
                                                <li><a href="muagiamgia/{{ $gg->id }}"><i
                                                            class="fa-solid fa-sack-dollar"></i>Mua Ngay</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <h2 class="text-center">Không Có Sản Phẩm Giảm Giá</h2>
                        @endif
                    </div>
                    <!--features_items-->
                </div>
            </div>
        </div>
    </section>
@endsection
@section('script')
    <script>
        function formatNumber(nStr, decSeperate, groupSeperate) {
            nStr += '';
            x = nStr.split(decSeperate);
            x1 = x[0];
            x2 = x.length > 1 ? '.' + x[1] : '';
            var rgx = /(\d+)(\d{3})/;
            while (rgx.test(x1)) {
                x1 = x1.replace(rgx, '$1' + groupSeperate + '$2');
            }
            return x1 + x2;
        }

        $(document).ready(function() {

            $("#timkiem").keydown(function(e) {
                if (e.keyCode == 13) {
                    var key = $("#timkiem").val();
                    var url = "timkiem/" + key;
                    $(".features_items > div").remove();
                    $(".features_items > h2").remove();
                    $.get(url,
                        function(data) {
                            $(".features_items").html(data);
                        },
                    );
                }
            });

            function themsanphamgiamgia(data) {
                for (let i = 0; i < data.length; i++) {
                    id = 'giamgiasanpham' + (data.length - i);
                    url = "#" + id
                    $html = "<div class='col-sm-4 giamgiasanpham' id='" + id + "' data-type='giamgia'>"
                    $("#titlegiamgia").after($html);
                    $html =
                        "<div class='product-image-wrapper'><div class='single-products'><div class='productinfo text-center'><img src='upload/sanpham/" +
                        data[i]['Hinh'] + "'/><span class='text_product'>" + data[i]['TenSanPham'] +
                        "</span><div class='content_price_sale'><p class='price_none_sale'>" + formatNumber(data[i][
                            'Gia'
                        ], '.', ',') + " VNĐ</p><h4 class='price_sale'>" + formatNumber(data[i]['giakhuyenmai'],
                            ',', '.') + " VNĐ</h4><p>" + data[i]['ngayketthuc'] +
                        "&nbsp;&nbsp;&nbsp;&nbsp;<b>Số Lượng Còn:" + data[i]['soluong'] +
                        "</b></p></div></div></div><div class='choose'><ul class='nav nav-pills nav-justified'><li><a href='giohang/themgiamgiavaogio/" +
                        data[i]['id'] +
                        "'><i class='fa fa-shopping-cart'></i>Thêm Vào Giỏ Hàng</a></li><li><a href='muagiamgia/" +
                        data[i]['id'] +
                        "'><i class='fa-solid fa-sack-dollar'></i>Mua Ngay</a></li></ul></div></div>"
                    $(url).append($html);
                }
            }
            setInterval(() => {
                $.get("sanphamgiamgiatrangsanpham",
                    function(data) {
                        if (data.length > 0) {
                            $(".giamgiasanpham").remove();
                            themsanphamgiamgia(data);
                        } else {
                            $html =
                                "<h4 class='text-center thongbaokhonggiamgia'>Không Có Sản Phẩm Giảm Giá</h4>"
                            $(".giamgiasanpham").remove();
                            $(".thongbaokhonggiamgia").remove()
                            $("#titlegiamgia").append($html);
                        }
                    },
                );
            }, 1000);

        });
    </script>
@endsection
