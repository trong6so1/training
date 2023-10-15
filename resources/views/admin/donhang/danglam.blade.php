@extends('admin.layout')
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
    <div class="table-agile-info">
        <div class="panel panel-default">
            <div class="panel-heading">
                Danh Sách Đơn Hàng Đã Nhận
            </div>
        </div>
        @if (count($donhang) > 0)
            <div class="table-responsive">
                <table class="table table-striped b-t b-light">
                    <thead>
                        <tr>
                            <th>Mã Đơn Hàng</th>
                            <th>Người Đặt</th>
                            <th>Địa Chỉ</th>
                            <th>Tổng Tiền</th>
                            <th>Hình Thức Thanh Toán</th>
                            <th>Tình Trạng Đơn Hàng</th>
                            <th>Ghi chú cho shipper</th>
                            <th style="width:50px;"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($donhang as $dh)
                            <tr>
                                <td>{{ $dh->id }}</td>
                                @if ($dh->idkhachhang  >0)
                                <td>{{ $dh->KhachHang->tennguoidung }}</td>
                                @else
                                    <td><span style="color: red">Khách Hàng Đã Bị Xóa</span></td>
                                @endif
                                <td>{{ $dh->NguoiNhan->diachi }}</td>
                                <td>{{ number_format($dh->tongtien) . ' VNĐ' }}</td>
                                <td>
                                    @switch($dh->hinhthucthanhtoan)
                                        @case(0)
                                            {{ 'VNPay' }}
                                        @break

                                        @case(1)
                                            {{ 'Trả Sau' }}
                                        @break

                                        @case(2)
                                            {{ 'Ví MoMo' }}
                                        @break
                                    @endswitch
                                </td>
                                <td>
                                    @switch($dh->tinhtrangdonhang)
                                        @case(0)
                                            {{ 'Chờ Xác Nhận Đơn' }}
                                        @break

                                        @case(1)
                                            {{ 'Đã Xác Nhận Đơn,Chờ Lấy Hàng' }}
                                        @break

                                        @case(2)
                                            {{ 'Đã lấy hàng,Đang trong quá trình giao' }}
                                        @break

                                        @case(3)
                                            {{ 'Đã Hoàn Thành' }}
                                        @break
                                    @endswitch
                                </td>
                                <td>
                                    @if (!empty($dh->ghichu))
                                        {{ $dh->ghichu }}
                                </td>
                            @else
                                {{ 'Không' }}
                        @endif
                        <td>
                            <a href="admin/donhang/chitietdonhang/{{ $dh->id }}" class="btn btn-primary">Xem Đơn Hàng</a>
                        </td>
                        </tr>
        @endforeach
        </tbody>
        </table>
    </div>
@else
    {{ 'Không Có Đơn Hàng Mới' }}
    @endif

@endsection
