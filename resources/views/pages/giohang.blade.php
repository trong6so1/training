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
    @if (session('giohang'))
        <section id="cart_items">
            <div class="container">
                <div class="breadcrumbs">
                    <ol class="breadcrumb">
                        <li><a href="/trangchu">Trang Chủ</a></li>
                        <li class="active">Giỏ Hàng</li>
                    </ol>
                </div>

                <div class="table-responsive cart_info">
                    <table class="table table-condensed">
                        <thead>
                            <tr class="cart_menu">
                                <td class="image">Sản Phẩm</td>
                                <td class="description"></td>
                                <td class="price">Giá Tiền</td>
                                <td class="quantity">Số Lượng</td>
                                <td class="total">Thành Tiền</td>
                                <td></td>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($sanphamgiamgia) > 0)
                                @foreach ($sanphamgiamgia as $sp)
                                    <tr>
                                        <td class="cart_product">
                                            <img width="100px" height="100px" src="upload/sanpham/{{ $sp->SanPham->Hinh }}"
                                                alt="">
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
                                            <div class="cart_quantity_button">
                                                <a class="cart_quantity_down"
                                                    href="giohang/xoagiamgiagiohang/{{ $sp->id }}"> - </a>
                                                <input class="cart_quantity_input" type="text" name="quantity" value=1
                                                    autocomplete="off" size="2">
                                                <a class="cart_quantity_up"
                                                    href="giohang/themgiamgiavaogio/{{ $sp->id }}"> + </a>
                                            </div>
                                        </td>
                                        <td class="cart_total">
                                            <p class="cart_total_price">{{ number_format($sp->giakhuyenmai) . ' VNĐ' }}</p>
                                        </td>
                                        <td class="cart_delete">
                                            <a class="cart_quantity_delete"
                                                href="giohang/xoagiamgiagiohang/{{ $sp->id }}"><i
                                                    class="fa fa-times"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                            @foreach (session('giohang')->sanpham as $giohang)
                                @if ($giohang['soluong'] > 0)
                                    <tr>
                                        <td class="cart_product">
                                            <img width="100px" height="100px"
                                                src="upload/sanpham/{{ $giohang['sanpham']['Hinh'] }}" alt="">
                                        </td>
                                        <td class="cart_description">
                                            <h4><a
                                                    href="chitietsanpham/{{ $giohang['sanpham']['id'] }}">{{ $giohang['sanpham']['TenSanPham'] }}</a>
                                            </h4>
                                            <p>Mã Sản Phẩm:{{ $giohang['sanpham']['id'] }}</p>
                                        </td>
                                        <td class="cart_price">
                                            <p>{{ number_format($giohang['sanpham']['Gia']) . ' VNĐ' }}</p>
                                        </td>
                                        <td class="cart_quantity">
                                            <div class="cart_quantity_button">
                                                <a class="cart_quantity_down"
                                                    href="giohang/trugiohang/{{ $giohang['sanpham']['id'] }}"> - </a>
                                                <input class="cart_quantity_input" type="text" name="quantity"
                                                    value="{{ $giohang['soluong'] }}" autocomplete="off" size="2">
                                                <a class="cart_quantity_up"
                                                    href="giohang/themvaogio/{{ $giohang['sanpham']['id'] }}"> + </a>
                                            </div>
                                        </td>
                                        <td class="cart_total">
                                            <p class="cart_total_price">
                                                {{ number_format($giohang['sanpham']['Gia'] * $giohang['soluong']) . ' VNĐ' }}
                                            </p>
                                        </td>
                                        <td class="cart_delete">
                                            <a class="cart_quantity_delete"
                                                href="giohang/xoagiohang/{{ $giohang['sanpham']['id'] }}"><i
                                                    class="fa fa-times"></i></a>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
        <!--/#cart_items-->

        <section id="do_action">
            <div class="container">
                <a class="btn btn-default check_out" href="thanhtoan">Thanh Toán</a>
            </div>
        </section>
        <!--/#do_action-->
    @else
        <h1>Không có sản phẩm trong giỏ hàng</h1>
    @endif

@endsection
