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
    <header class="panel-heading">
        Thêm Bài Viết
    </header>
    <div class="panel-body">
        <div class=" form">
            <form class="cmxform form-horizontal " id="commentForm" method="POST" action="admin/baiviet/them"
                enctype="multipart/form-data">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="form-group ">
                    <label for="cname" class="control-label col-lg-3">Tiêu Đề Bài Viết</label>
                    <div class="col-lg-9">
                        <input class=" form-control" name="tenbaiviet" type="text">
                    </div>
                </div>
                <div class="form-group ">
                    <label for="cname" class="control-label col-lg-3">Ảnh Bài Viết</label>
                    <div class="col-lg-9" id="sanpham">
                        <input class=" form-control" id="fileanhsanpham" name="anhbaiviet" type="file">
                    </div>
                </div>
                <div class="form-group ">
                    <label for="cname" class="control-label col-lg-3">Tóm Tắt Bài Viết</label>
                    <div class="col-lg-9">
                        <textarea name="tomtat" class="form-control" id="editor" cols="66" rows="10"></textarea>
                    </div>
                </div>
                <div class="form-group ">
                    <label for="cname" class="control-label col-lg-3">Nội Dung Bài Viết</label>
                    <div class="col-lg-9">
                        <textarea name="noidung" class="form-control" id="editor1" cols="66" rows="10"></textarea>
                    </div>
                </div>
                <div class="form-group ">
                    <label for="cname" class="control-label col-lg-3">Thể Loại</label>
                    <div class="col-lg-9">
                        <select name="matheloai" class="form-control">
                            <option value={{ null }}>--Chọn Thể Loại--</option>
                            @foreach ($theloai as $tl)
                                <option value="{{ $tl->id }}">{{ $tl->tentheloai }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group ">
                    <label for="cname" class="control-label col-lg-3">Trạng Thái Bài Viết:</label>
                    <div class="col-lg-9">
                        <label>
                            <input type="radio" name="hienthi" value=0>Ẩn
                        </label>
                        <label>
                            <input type="radio" name="hienthi" value=1>Hiện
                        </label>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-lg-offset-3 col-lg-9">
                        <button class="btn btn-primary" type="submit">Thêm</button>
                        <button class="btn btn-default" type="button">Hủy</button>
                    </div>
                </div>
            </form>
        </div>

    </div>
@endsection
@section('script')
    <script>
        CKEDITOR.replace('editor', {
            filebrowserBrowseUrl: 'ckfinder/ckfinder.html',
            filebrowserImageBrowseUrl: 'ckfinder/ckfinder.html?type=Images',
            filebrowserFlashBrowseUrl: 'ckfinder/ckfinder.html?type=Flash',
            filebrowserUploadUrl: 'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
            filebrowserImageUploadUrl: 'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
            filebrowserFlashUploadUrl: 'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash'
        });
    </script>
    <script>
        CKEDITOR.replace('editor1', {
            filebrowserBrowseUrl: 'ckfinder/ckfinder.html',
            filebrowserImageBrowseUrl: 'ckfinder/ckfinder.html?type=Images',
            filebrowserFlashBrowseUrl: 'ckfinder/ckfinder.html?type=Flash',
            filebrowserUploadUrl: 'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
            filebrowserImageUploadUrl: 'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
            filebrowserFlashUploadUrl: 'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash'
        });
    </script>
    <script>
        $(document).ready(function() {
            $("#fileanhsanpham").change(function() {
                if ($("#fileanhsanpham").val() != "") {
                    var input = document.getElementById("fileanhsanpham");
                    var fReader = new FileReader();
                    fReader.readAsDataURL(input.files[0]);
                    fReader.onloadend = function(event) {
                        if ($("#imgsanpham")) {
                            $("#imgsanpham").remove();
                        }
                        $("#sanpham").prepend(
                            `<img id='imgsanpham' src=${event.target.result} width='800' height = '500'>`
                            );
                    }
                } else {
                    if ($("#imgsanpham")) {
                        $("#imgsanpham").remove();
                    }
                }
            });
        });
    </script>
@endsection
