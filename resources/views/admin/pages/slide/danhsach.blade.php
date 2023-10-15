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
                Danh Sách Slide
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-striped b-t b-light">
                <thead>
                    <tr>
                        <th>Ảnh</th>
                        <th>Chức Năng</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($slide as $sl)
                        <tr>
                            <th>
                                <img  src="upload/slide/{{ $sl->anh }}" class="imgslide" alt="">
                            </th>
                            <th>
                                <a href="admin/slide/sua/{{ $sl->id }}" class="btn btn-warning">Sửa</a>
                                <a onclick="return confirm('Bạn có thật sự muốn xóa slide này không?')"
                                    href="admin/slide/xoa/{{ $sl->id }}" class="btn btn-danger">Xóa</a>
                            </th>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endsection
