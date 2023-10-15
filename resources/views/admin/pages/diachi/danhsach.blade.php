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
                Danh Sách Địa Chỉ
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-striped b-t b-light">
                <thead>
                    <tr>
                        <th>Tên Phường</th>
                        <th>Giá</th>
                        <th>Chức Năng</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($diachi as $dc)
                        <tr>
                            <th>{{ $dc->tenphuong }}</th>
                            <th>{{ number_format($dc->gia) . ' VNĐ' }}</th>
                            <th>
                                <a href="admin/diachi/sua/{{ $dc->id }}" class="btn btn-warning">Sửa</a>
                                <a onclick="return confirm('Bạn có thật sự muốn xóa địa chỉ này không?')"
                                    href="admin/diachi/xoa/{{ $dc->id }}" class="btn btn-danger">Xóa</a>
                            </th>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endsection
