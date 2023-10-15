@extends('layout.main')
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
@section('content')
    <section>
        <div class="container">
            <div class="row">
                @include('layout.menuthongbao')
                <div class="col-sm-9 ">
                    <div class="features_items">
                        <!--login form-->
                        <div>
                            <div>
                                <div class="table-agile-info">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            Thông Tin Người Nhận
                                        </div>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table table-striped b-t b-light">
                                            <thead>
                                                <tr>
                                                    <th>Tên Người Nhận</th>
                                                    <th>Địa Chỉ</th>
                                                    <th>Số Điện Thoại</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>{{ $donhang->NguoiNhan->tennguoinhan }}</td>
                                                    <td>{{ $donhang->NguoiNhan->diachi }}</td>
                                                    <td>{{ $donhang->NguoiNhan->dienthoai }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div>
                                    <div class="table-agile-info">
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                Chi Tiết Đơn Hàng
                                            </div>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table table-striped b-t b-light">
                                                <thead>
                                                    <tr>
                                                        <th>Mã Đơn Hàng</th>
                                                        <th></th>
                                                        <th>Tên Sản Phẩm</th>
                                                        <th>Giá</th>
                                                        <th>Số Lượng</th>
                                                        <th>Thành Tiền</th>
                                                        <th style="width:50px;"></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $tong = 0; ?>
                                                    @foreach ($chitiet as $ct)
                                                        @if ($ct->idsanpham == 0)
                                                            <tr class="daxoa" style="opacity: 0.3">
                                                        @else
                                                            <tr>
                                                        @endif
                                                            <?php $tensanpham = explode('/',$ct->hinhxoa); ?>
                                                            <td>{{ $ct->iddonhang }}</td>
                                                            <td>
                                                                @if ($ct->idsanpham == 0)
                                                                    <img src="upload/daxoa/sanpham/{{ $tensanpham[1] }}" width="100px" height="100px" /></td>
                                                                @else
                                                                    <img src="upload/sanpham/{{ $ct->SanPham->Hinh }}" width="100px" height="100px" /></td>
                                                                @endif
                                                            <td>
                                                                @if ($ct->idsanpham == 0)
                                                                    <p class="daxoa">{{ $tensanpham[0] }}<span style="color: red;font-weight:bold">(Đã Ngưng Bán)<span></p>
                                                                @else
                                                                    {{ $ct->SanPham->TenSanPham }}
                                                                @endif
                                                            </td>
                                                            <td>{{ number_format($ct->gia) . ' VNĐ' }}</td>
                                                            <td>{{ $ct->soluong }}</td>
                                                            <?php
                                                            $tong += $ct->gia * $ct->soluong;
                                                            ?>
                                                            <td>{{ number_format($ct->gia * $ct->soluong) . ' VNĐ' }}</td>
                                                        </tr>
                                                    @endforeach
                                                    <td colspan="2">
                                                        <table class="table table-condensed total-result">
                                                            <tr>
                                                                <td>Tổng Tiền sản Phẩm</td>
                                                                <td class="tongtiensanpham">
                                                                    {{ number_format($tong) . ' VNĐ' }}</td>
                                                            </tr>
                                                            <tr class="shipping-cost">
                                                                <td>Tiền Ship</td>
                                                                <td id="shipping">
                                                                    {{ number_format($donhang->tienship) . ' VNĐ' }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Giảm Giá</td>
                                                                <?php
                                                                $giamgia = $tong + $donhang->tienship - $donhang->tongtien;
                                                                ?>
                                                                <td class="discount">{{ number_format($giamgia) . ' VNĐ' }}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>Thành Tiền</td>
                                                                <td class="thanhtien" name="thanhtien">
                                                                    <span>{{ number_format($donhang->tongtien) . ' VNĐ' }}</span>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>>
                    </div>
                </div>
    </section>
@endsection
