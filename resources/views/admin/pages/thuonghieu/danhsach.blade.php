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
                Danh Sách Thương Hiệu
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-striped b-t b-light">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Tên Thương Hiệu</th>
                        <th>Mô Tả</th>
                        <th>Hiển Thị</th>
                        <th>Ngày Cập Nhật</th>
                        <th style="width:50px;"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($thuonghieu as $th)
                        <tr>
                            <td>{{ $th->id }}</td>
                            <td>{{ $th->TenThuongHieu }}</td>
                            <td>{{ $th->MoTa }}</td>
                            <td>
                                <a href="admin/thuonghieu/suahienthi/{{ $th->id }}">
                                    @if ($th->Hien === 1)
                                        <i class="fa-solid fa-thumbs-up"></i>
                                    @else
                                        <i class="fa-sharp fa-solid fa-thumbs-down"></i>
                                    @endif
                                </a>
                            </td>
                            <td>{{ $th->created_at }}</td>
                            <td>
                                <a href="admin/thuonghieu/chinhsua/{{ $th->id }}"><i
                                        class="fa-solid fa-pen-to-square"></i></a>
                                <a onclick="return confirm('Bạn có thật sự muốn xóa thương hiệu không?')"
                                    href="admin/thuonghieu/xoa/{{ $th->id }}"><i
                                        class="fa-sharp fa-solid fa-trash"></i></a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endsection
