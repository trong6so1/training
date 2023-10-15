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
                Danh Sách Sản Phẩm Giảm Giá
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-striped b-t b-light">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Tên Sản Phẩm</th>
                        <th></th>
                        <th>Giá Khuyến Mãi</th>
                        <th>Số Lượng</th>
                        <th>Tiêu Đề Khuyến Mãi</th>
                        <th>Nội Dung Khuyến Mãi</th>
                        <th>Trạng Thái</th>
                        <th>Ngày Bắt Đầu </th>
                        <th>Ngày Kết Thúc</th>
                        <th style="width:50px;"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($giamgiasanpham as $gg)
                        <tr>
                            <td>{{ $gg->id }}</td>
                            <td>{{ $gg->SanPham->TenSanPham }}</td>
                            <td><img src="upload/sanpham/{{ $gg->SanPham->Hinh }}" width="100px" height="100px"
                                    alt=""></td>
                            <td>{{ $gg->giakhuyenmai }}</td>
                            <td>{{ $gg->soluong }}</td>
                            <td>{{ $gg->tieude }}</td>
                            <td>{{ $gg->noidung }}</td>
                            <td>
                                <a href="admin/giamgiasanpham/suahienthi/{{ $gg->id }}">
                                    @if ($gg->hienthi === 0)
                                        Ẩn
                                    @else
                                        Hiện
                                    @endif
                                </a>
                            </td>
                            <td>{{ $gg->ngaybatdau }}</td>
                            <td>{{ $gg->ngayketthuc }}</td>
                            <td>
                                <a onclick="return confirm('Bạn có thật sự muốn xóa sản phẩm này không?')"
                                    href="admin/giamgiasanpham/xoa/{{ $gg->id }}" class="btn btn-danger">Xóa</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endsection
