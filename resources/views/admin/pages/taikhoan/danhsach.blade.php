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
                Danh Sách Tài Khoản
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-striped b-t b-light">
                <thead>
                    <tr>
                        <th></th>
                        <th>Họ Và Tên</th>
                        <th>Email</th>
                        <th>Chức Vụ</th>
                        <th>Số Điện Thoại</th>
                        <th>Chức Năng</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($nhanvien as $nv)
                        <tr>
                            <th>
                                @if (!isset($nv->anhdaidien))
                                    <img class="imganhdaidien" src="upload/anhadmin/macdinh.png" alt="">
                                @else
                                    <img class="imganhdaidien" src="upload/anhadmin/{{ $nv->anhdaidien }}" alt="">
                                @endif
                            </th>
                            <th>{{ $nv->hoten }}</th>
                            <th>{{ $nv->email }}</th>
                            <th>{{ $nv->chucvu->tenchucvu }}</th>
                            <th>{{ $nv->sodienthoai }}</th>
                            <th>
                                @if (session('admin')->id != $nv->id)
                                    <a href="admin/admin/sua/{{ $nv->id }}" class="btn btn-warning">Sửa Chức Vụ</a>
                                    <a onclick="return confirm('Bạn có thật sự muốn xóa nhân viên này không?')"
                                        href="admin/admin/xoa/{{ $nv->id }}" class="btn btn-danger">Xóa Nhân Viên</a>
                                @endif
                            </th>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endsection
