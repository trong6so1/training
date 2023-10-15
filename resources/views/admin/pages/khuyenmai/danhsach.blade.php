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
                Danh Sách Mã Khuyễn Mãi
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-striped b-t b-light">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Nội Dung Khuyễn Mãi</th>
                        <th>Mã Khuyến Mãi</th>
                        <th>Số Lượng</th>
                        <th>Loại Hình Khuyến Mãi</th>
                        <th>Số Tiền</th>
                        <th>Ngày Bắt Đầu</th>
                        <th>Ngày Kết Thúc</th>
                        <th style="width:50px;"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($khuyenmai as $km)
                        <tr>
                            <td>{{ $km->id }}</td>
                            <td>{{ $km->noidung }}</td>
                            <td>{{ $km->makhuyenmai }}</td>
                            <td>{{ $km->soluong }}</td>
                            <td>
                                @if ($km->loaikhuyenmai == 1)
                                    {{ 'Theo Phần Trăm' }}
                                @elseif ($km->loaikhuyenmai == 2)
                                    {{ 'Theo  Giá Tiền' }}
                                @endif
                            </td>
                            <td>
                                @if ($km->loaikhuyenmai == 1)
                                    {{ $km->sotien . '%' }}
                                @elseif ($km->loaikhuyenmai == 2)
                                    {{ number_format($km->sotien) . 'VNĐ' }}
                                @endif
                            </td>
                            <td>
                                {{ $km->ngaybatdau }}
                            </td>
                            <td>{{ $km->ngayketthuc }}</td>
                            <td>
                                <a onclick="return confirm('Bạn có thật sự muốn xóa mã khuyến mãi này không?')"
                                    href="admin/khuyenmai/xoa/{{ $km->id }}" class="btn btn-danger">Xóa</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endsection
