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
        Sửa Sản Phẩm
    </header>
    <div class="panel-body">
        <div class=" form">
            <form class="cmxform form-horizontal " id="commentForm" method="POST"
                action="admin/sanpham/chinhsua/{{ $sanpham->id }}" novalidate="novalidate" enctype="multipart/form-data">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="form-group ">
                    <label for="cname" class="control-label col-lg-3">Tên Sản Phẩm</label>
                    <div class="col-lg-6">
                        <input class=" form-control" value="{{ $sanpham->TenSanPham }}" id="cname" name="TenSanPham"
                            type="text">
                    </div>
                </div>
                <div class="form-group ">
                    <label for="ccomment" class="control-label col-lg-3">Mô Tả Sản Phẩm</label>
                    <div class="col-lg-6">
                        <textarea rows="5" class="form-control ckeditor" id="ccomment" name="MoTa" required="">{{ $sanpham->MoTa }}</textarea>
                    </div>
                </div>
                <div class="form-group ">
                    <label for="ccomment" class="control-label col-lg-3">Trạng Thái:</label>
                    <div class="col-lg-6">
                        <input @if ($sanpham->TrangThai === 1) {{ 'checked' }} @endif type="radio" name="TrangThai"
                            id="" value="1">Còn Hàng
                        <input @if ($sanpham->TrangThai === 0) {{ 'checked' }} @endif type="radio" name="TrangThai"
                            value="0">Hết Hàng

                    </div>
                </div>
                <div class="form-group ">
                    <label for="cname" class="control-label col-lg-3">Giá</label>
                    <div class="col-lg-6">
                        <input value="{{ $sanpham->Gia }}" class="form-control" id="cname" name="Gia" type="number"
                            min="100000">
                    </div>
                </div>
                <div class="form-group">
                    <label for="cname" class="control-label col-lg-3">Hình Ảnh</label>
                    <div class="col-lg-6" id="sanpham">
                        <img src="upload/sanpham/{{ $sanpham->Hinh }}" alt="" id="imgsanpham">
                        <input class=" form-control" id="fileanhsanpham" name="Hinh" type="file">
                    </div>
                </div>
                <div class="form-group ">
                    <label for="cname" class="control-label col-lg-3">Danh Mục Sản Phẩm:</label>
                    <div class="col-lg-6">
                        <select class="form-control" name="idDanhMuc">
                            @foreach ($danhmuc as $dm)
                                <option @if ($dm->id === $sanpham->idDanhMuc) elected @endif value="{{ $dm->id }}">
                                    {{ $dm->TenDanhMuc }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-lg-offset-3 col-lg-6">
                        <button class="btn btn-primary" type="submit">Sửa</button>
                        <button class="btn btn-default" type="button">Hủy</button>
                    </div>
                </div>
            </form>
        </div>

    </div>
@endsection
@section('script')
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
                        $("#sanpham").prepend(`<img id='imgsanpham' src=${event.target.result}>`);
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
