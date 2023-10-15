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
                Danh Sách Bài Viết
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-striped b-t b-light">
                <thead>
                    <tr>
                        <th></th>
                        <th>Tiêu Đề Bài Viết</th>
                        <th>Tóm Tắt Bài Viết</th>
                        <th>Nội Dung Bài Viết</th>
                        <th>Thể Loại</th>
                        <th>Trạng Thái</th>
                        <th>Ngày Đăng</th>
                        <th>Chức Năng</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($baiviet as $bv)
                        <tr>
                            <th>
                                <img width="300px" height="300px" src="upload/anhbaiviet/{{ $bv->anhbaiviet }}" class="imgad"
                                    alt="">
                            </th>
                            <th>{{ $bv->tenbaiviet }}</th>
                            <th class="noidung1">{!! $bv->tomtat !!}</th>
                            <th class="noidung2">{!! $bv->noidung !!}</th>
                            <th>{{ $bv->TheLoaiBaiViet->tentheloai }}</th>
                            <th><a href="admin/baiviet/suahienthi/{{ $bv->id }}">
                                    @if ($bv->hienthi == 1)
                                        {{ 'Hiện' }}
                                    @else
                                        {{ 'Ẩn' }}
                                    @endif
                                </a>
                            </th>
                            <th>{{ $bv->ngaydang }}</th>
                            <th>
                                <a href="admin/baiviet/sua/{{ $bv->id }}" class="btn btn-warning">Sửa</a>
                                <a onclick="return confirm('Bạn có thật sự muốn xóa bài viết này không?')"
                                    href="admin/baiviet/xoa/{{ $bv->id }}"class="btn btn-danger">Xóa</a>
                            </th>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endsection
