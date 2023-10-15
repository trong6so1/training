@extends('admin.layout')
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
                            @foreach ($chitiet as $ct)
                                @if ($ct->idsanpham == 0)
                                    <tr class="daxoa" style="opacity: 0.3">
                                    @else
                                    <tr>
                                @endif
                                <?php $tensanpham = explode('/', $ct->hinhxoa); ?>
                                <td>{{ $ct->iddonhang }}</td>
                                <td>
                                    @if ($ct->idsanpham == 0)
                                        <img src="upload/daxoa/sanpham/{{ $tensanpham[1] }}" width="100px"
                                            height="100px" />
                                    @else
                                        <img src="upload/sanpham/{{ $ct->SanPham->Hinh }}" width="100px" height="100px" />
                                    @endif
                                </td>
                                <td>
                                    @if ($ct->idsanpham == 0)
                                        <p>{{ $tensanpham[0] }}<span class="daxoatitle"
                                                style="color: red;font-weight:bold">(Đã Ngưng Bán)</span></p>
                                    @else
                                        {{ $ct->SanPham->TenSanPham }}
                                    @endif
                                </td>
                                <td>{{ number_format($ct->gia) . ' VNĐ' }}</td>
                                <td>{{ $ct->soluong }}</td>
                                <td>{{ number_format($ct->gia * $ct->soluong) . ' VNĐ' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="thongbao">
                @if ($donhang->tinhtrangdonhang < 1)
                    <a href="admin/donhang/xacnhandon/{{ $donhang->id }}" class="alert alert-success">Xác Nhận Đơn</a>
                @endif
                <a href="admin/donhang/hoanthanh/{{ $donhang->id }}" class="alert alert-success">Báo Cáo Đã Xong</a>
                <a href="admin/donhang/huydon/{{ $donhang->id }}" class="alert alert-danger">Đơn Bị Hủy</a>

                {{-- <a href="hoanthanh/{{ $donhang->id }}" class="alert alert-danger">Khách Hủy Đơn</a> --}}
            </div>
        @endsection
