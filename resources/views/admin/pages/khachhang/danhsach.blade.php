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
                Danh Sách Khách Hàng
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-striped b-t b-light">
                <thead>
                    <tr>
                        <th></th>
                        <th>Họ Và Tên</th>
                        <th>Email</th>
                        <th>Số Điện Thoại</th>
                        <th>Số Đơn Hàng Đã Đặt</th>
                        <th>Số Đơn Hàng Đã Hủy</th>
                        <th>Chức Năng</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($khachhang as $kh)
                        <tr>
                            <th>
                                @if (!isset($kh->anhdaidien))
                                    <img class="imganhdaidien" src="upload/anhkhachhang/macdinh.png" alt="">
                                @else
                                    <img class="imganhdaidien" src="upload/anhkhachhang/{{ $kh->anhdaidien }}"
                                        alt="">
                                @endif
                            </th>
                            <th>{{ $kh->tennguoidung }}</th>
                            <th>{{ $kh->email }}</th>
                            <th>{{ $kh->sodienthoai }}</th>
                            <th>{{ count($kh->DonHang) }}</th>
                            <th>{{ count($sodonhuy[$kh->id]) }}</th>
                            <th>
                                <a onclick="return confirm('Bạn có thật sự muốn xóa khách hàng này không?')"
                                    href="admin/khachhang/xoa/{{ $kh->id }}" class="btn btn-danger">Xóa Khách Hàng</a>
                            </th>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endsection
