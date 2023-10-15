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
                Danh Sách Sản Phẩm
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-striped b-t b-light">
                <thead>
                    <tr>
                        <th></th>
                        <th>Id</th>
                        <th>Tên Sản Phẩm</th>
                        <th>Mô Tả</th>
                        <th>Giá</th>
                        <th>Trạng Thái</th>
                        <th>Danh Mục</th>
                        <th>Ngày Cập Nhật</th>
                        <th style="width:50px;"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($sanpham as $sp)
                        <tr>
                            <td>{{ $sp->id }}</td>
                            <td>{{ $sp->TenSanPham }}</td>
                            <td><img src="upload/sanpham/{{ $sp->Hinh }}" width="100px" height="100px" alt="">
                            </td>
                            <td>{{ $sp->MoTa }}</td>
                            <td>{{ $sp->Gia }}</td>
                            <td>
                                <a href="admin/sanpham/suatrangthai/{{ $sp->id }}">
                                    @if ($sp->TrangThai === 1)
                                        Còn Hàng
                                    @else
                                        Hết Hàng
                                    @endif
                                </a>
                            </td>
                            <td>{{ $sp->DanhMuc->TenDanhMuc }}</td>
                            <td>{{ $sp->created_at }}</td>
                            <td>
                                <a href="admin/sanpham/chinhsua/{{ $sp->id }}" class="btn btn-warning">Sửa</a>
                                <a onclick="return confirm('Bạn có thật sự muốn xóa sản phẩm này không?')"
                                    href="admin/sanpham/xoa/{{ $sp->id }}" class="btn btn-danger">Xóa</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endsection
