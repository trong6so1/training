@extends('layout.main')
@section('content')
    <section id="cart_items">
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
        <form action="thanhtoan" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="container">
                <div class="breadcrumbs">
                    <ol class="breadcrumb">
                        <li><a href="trangchu">Trang Chủ</a></li>
                        <li class="active">Thanh Toán</li>
                    </ol>
                </div>
                <!--/breadcrums-->

                <div class="table-responsive cart_info">
                    <div class="col-sm-6">
                        <div class="shopper-info">
                            <p>Thông Tin Người Nhận</p>
                            <div class="order-message">
                                <label>Tên Người Nhận:</label>
                                <input class="input" name="tennguoinhan" value="{{ session('khachhang')->tennguoidung }}"
                                    type="text">
                            </div>
                            <div class="order-message">
                                <label>SĐT Người Nhận:</label>
                                <input class="input" name="dienthoai" value="{{ session('khachhang')->sodienthoai }}"
                                    type="text">
                            </div>
                            <div class="order-message">
                                <div class="col-sm-5">
                                    <label>Tên Phường:</label>
                                    <select class="input" name="tenphuong" id="tenphuong">
                                        <option value={{ null }}>--Chọn Địa Chỉ--</option>
                                        @foreach ($diachi as $dc)
                                            <option value="{{ $dc->id }}">{{ $dc->tenphuong }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-6">
                                    <label>Số Nhà:</label>
                                    <input class="input" name="sonha" type="text">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="order-message">
                            <p>Ghi Chú Cho Shipper</p>
                            <textarea name="ghichu" placeholder="Ghi Chú Cho Shipper" rows="16"></textarea>
                        </div>
                    </div>
                </div>
                <div class="review-payment">
                    <h2>Review & Payment</h2>
                </div>

                <div class="table-responsive cart_info">
                    <table class="table table-condensed">
                        <thead>
                            <tr class="cart_menu">
                                <td class="description" style="width:200px"></td>
                                <td class="image">Tên Sản Phẩm</td>
                                <td class="price">Giá</td>
                                <td class="quantity">Số Lượng</td>
                                <td class="total">Thành Tiền</td>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($sanpham)
                                <tr>
                                    <td class="cart_product">
                                        <img width="100px" height="100px" src="upload/sanpham/{{ $sanpham->Hinh }}"
                                            alt=""></a>
                                    </td>
                                    <td class="cart_description">
                                        <h4><a href="chitietsanpham/{{ $sanpham->id }}">{{ $sanpham->TenSanPham }}</a>
                                        </h4>
                                        <p>Id:{{ $sanpham->id }}</p>
                                    </td>
                                    <td class="cart_price">
                                        <p>{{ number_format($sanpham->Gia) . ' VNĐ' }}</p>
                                    </td>
                                    <td class="cart_quantity">
                                        <div class="cart_quantity_button">
                                            <p>{{ 1 }}</p>
                                        </div>
                                    </td>
                                    <td class="cart_total">
                                        <p class="cart_total_price">{{ number_format($sanpham->Gia) . ' VNĐ' }}</p>
                                    </td>
                                </tr>
                            @else
                                @if (count($sanphamkhuyenmai) > 0)
                                    @foreach ($sanphamkhuyenmai as $sp)
                                        <tr>
                                            <td class="cart_product">
                                                <img width="100px" height="100px"
                                                    src="upload/sanpham/{{ $sp->SanPham->Hinh }}" alt="">
                                            </td>
                                            <td class="cart_description">
                                                <h4><a
                                                        href="chitietsanpham/{{ $sp->masanpham }}">{{ $sp->SanPham->TenSanPham }}</a>
                                                </h4>
                                                <p>Mã Sản Phẩm:{{ $sp->masanpham }}</p>
                                            </td>
                                            <td class="cart_price">
                                                <p>{{ number_format($sp->giakhuyenmai) . ' VNĐ' }}</p>
                                            </td>
                                            <td class="cart_quantity">
                                                <p>{{ 1 }}</p>
                                            </td>
                                            <td class="cart_total">
                                                <p class="cart_total_price">{{ number_format($sp->giakhuyenmai) . ' VNĐ' }}
                                                </p>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                                @foreach (session('giohang')->sanpham as $giohang)
                                    @if ($giohang['soluong'] > 0)
                                        <tr>
                                            <td class="cart_product">
                                                <img width="100px" height="100px"
                                                    src="upload/sanpham/{{ $giohang['sanpham']->Hinh }}"
                                                    alt=""></a>
                                            </td>
                                            <td class="cart_description">
                                                <h4><a
                                                        href="chitietsanpham/{{ $giohang['sanpham']->id }}">{{ $giohang['sanpham']->TenSanPham }}</a>
                                                </h4>
                                                <p>Id:{{ $giohang['sanpham']->id }}</p>
                                            </td>
                                            <td class="cart_price">
                                                <p>{{ number_format($giohang['sanpham']->Gia) . ' VNĐ' }}</p>
                                            </td>
                                            <td class="cart_price">
                                                <p>{{ number_format($giohang['soluong']) }}</p>
                                            </td>
                                            <td class="cart_total">
                                                <p class="cart_total_price">
                                                    {{ number_format($giohang['soluong'] * $giohang['sanpham']->Gia) . ' VNĐ' }}
                                                </p>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            @endif


                            <td colspan="4">

                                <div class="thanhtoan">
                                    <label>Nhập Mã Giảm Giá:</label>
                                    <div>
                                        <input type="text" placeholder="Nhập Mã Giảm Giá" id="magiamgia"
                                            name="magiamgia">
                                        <input type="button" id="giamgia" name="giamgia" class="giamgia" value="Nhập">
                                        <p class="error"></p>
                                    </div>

                                </div>
                                <div class="thanhtoan">
                                    <label>Hình Thức Thanh Toán:</label>
                                    <span>
                                        <label><input type="radio" name="hinhthucthanhtoan" value="1"> Trả sau khi nhận hàng</label>
                                    </span>
                                    <span>
                                        <label><input type="radio" name="hinhthucthanhtoan" value="2">
                                            MoMo</label>
                                    </span>
                                </div>
                            </td>
                            <td colspan="2">
                                <table class="table table-condensed total-result">
                                    <tr>
                                        <td>Tổng Tiền sản Phẩm</td>
                                        @if ($sanpham)
                                            <td class="tongtiensanpham" data-money={{ $sanpham->Gia }}>
                                                {{ number_format($sanpham->Gia) . ' VNĐ' }}</td>
                                        @else
                                            <td class="tongtiensanpham" data-money={{ session('giohang')->tonggiatien }}>
                                                {{ number_format(session('giohang')->tonggiatien) . ' VNĐ' }}</td>
                                        @endif
                                    </tr>
                                    <tr>
                                        <td>Tổng số lượng</td>
                                        @if ($sanpham)
                                            <td>{{ 1 }}</td>
                                        @else
                                            <td>{{ session('giohang')->tongsoluong }}</td>
                                        @endif
                                    </tr>
                                    <tr class="shipping-cost">
                                        <td>Tiền Ship</td>
                                        <td id="shipping" data-shipping={{ 0 }}>
                                            {{ number_format(0) . ' VNĐ' }}</td>
                                    </tr>
                                    <tr>
                                        <td>Giảm Giá</td>
                                        <td class="discount">{{ number_format(0) . ' VNĐ' }}</td>
                                    </tr>
                                    <tr>
                                        <td>Thành Tiền</td>
                                        @if ($sanpham)
                                            <td class="thanhtien" name="thanhtien" data-thanhtien={{ $sanpham->Gia }}>
                                                <span>{{ number_format($sanpham->Gia) . ' VNĐ' }}</span>
                                            </td>
                                        @else
                                            <td class="thanhtien" name="thanhtien"
                                                data-thanhtien={{ session('giohang')->tonggiatien }}>
                                                <span>{{ number_format(session('giohang')->tonggiatien) . ' VNĐ' }}</span>
                                            </td>
                                        @endif
                                    </tr>
                                </table>
                            </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="payment-options">

                    <input type="submit" value="Thanh Toán" class="btn btn-primary" style="text-align: right">
                    <a class="btn btn-primary" href="giohang">Quay về Trang Giỏ Hàng</a>

                </div>
            </div>
        </form>
    </section>
    <!--/#cart_items-->
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
            $tongtiensanpham = $(".tongtiensanpham").data('money');
            $shipping = 0;
            $giamgia = 0;
            $("#giamgia").click(function(e) {
                if ($("#giamgia").val() == "Nhập") {
                    $magiamgia = $("#magiamgia").val();
                    if ($magiamgia == "") {
                        $(".error").text("Vui lòng nhập mã giảm giá");
                    } else {
                        $.get("tinhtiengiamgia", {
                                magiamgia: $magiamgia
                            },
                            function(data) {
                                if (data['loi']) {
                                    $(".error").text(data['loi']);
                                } else {
                                    $(".error").text("");
                                    $data = data.split('-');
                                    $("#magiamgia").attr('readonly', 'true');
                                    $tongtiensanpham = $(".tongtiensanpham").data("money");
                                    if ($data[0] == 1) {
                                        $giamgia = $tongtiensanpham * $data[1] / 100;
                                        $(".discount").text(formatNumber($giamgia, '.', ',') + " VNĐ");
                                        $thanhtien = "<span>" + formatNumber($tongtiensanpham - Number(
                                                $giamgia) + Number($shipping), '.', ',') + " VNĐ" +
                                            "</span>";
                                        $(".thanhtien").html($thanhtien);
                                    } else {
                                        $giamgia = $data[1];
                                        $(".discount").text(formatNumber($giamgia, '.', ',') + " VNĐ");
                                        $thanhtien = "<span>" + formatNumber($tongtiensanpham - Number(
                                                $giamgia) + Number($shipping), '.', ',') + " VNĐ" +
                                            "</span>";
                                        $(".thanhtien").html($thanhtien);
                                    }
                                    $("#giamgia").data("id", $data[2]);
                                    $("#giamgia").val("Hủy");

                                }
                            }
                        );
                    }
                } else if ($("#giamgia").val() == "Hủy") {
                    $url = 'huygiamgia/' + $("#giamgia").data('id');
                    $.get($url, function() {});
                    $("#magiamgia").removeAttr('readonly');
                    $("#magiamgia").val(null);
                    $("#giamgia").removeData('id');
                    $("#giamgia").val("Nhập");
                    $giamgia = 0;
                    $(".discount").text(formatNumber($giamgia, '.', ',') + " VNĐ");
                    $thanhtien = "<span>" + formatNumber($tongtiensanpham - Number($giamgia) + Number(
                        $shipping), '.', ',') + " VNĐ" + "</span>";
                    $(".thanhtien").html($thanhtien);
                }
            });
            $("#tenphuong").change(function(e) {
                if ($("#tenphuong").val() != "") {
                    $url = "laygiatientutenphuong/" + $("#tenphuong").val()
                    $.get($url,
                        function(data) {
                            $shipping = data;
                            $("#shipping").text(formatNumber($shipping, '.', ',') + " VNĐ");
                            $thanhtien = "<span>" + formatNumber($tongtiensanpham - Number($giamgia) +
                                Number($shipping), '.', ',') + " VNĐ" + "</span>";
                            $(".thanhtien").html($thanhtien);
                        }
                    );
                } else {
                    $shipping = 0;
                    $("#shipping").text(formatNumber($shipping, '.', ',') + " VNĐ");
                    $thanhtien = "<span>" + formatNumber($tongtiensanpham - Number($giamgia) + Number(
                        $shipping), '.', ',') + " VNĐ" + "</span>";
                    $(".thanhtien").html($thanhtien);
                }
            });
        });
    </script>
@endsection
