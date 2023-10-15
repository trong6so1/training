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
        Thông Tin Nhân Viên
    </header>
    <div class="panel-body">
        <div class=" form">
            <form class="cmxform form-horizontal " id="commentForm" method="POST"
                action="admin/admin/thongtin/{{ $nhanvien->id }}" enctype="multipart/form-data">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="form-group">
                    <label for="cname" class="control-label col-lg-3">Họ Tên</label>
                    <div class="col-lg-9">
                        <input class=" form-control" value="{{ $nhanvien->hoten }}" name="hoten" type="text">
                    </div>
                </div>
                <div class="form-group">
                    <label for="cname" class="control-label col-lg-3">Email</label>
                    <div class="col-lg-9">
                        <input class=" form-control" readonly value="{{ $nhanvien->email }}" name="email" type="text">
                    </div>
                </div>
                <div class="form-group">
                    <label for="cname" class="control-label col-lg-3">Số Điện Thoại</label>
                    <div class="col-lg-9">
                        <input class=" form-control" value="{{ $nhanvien->sodienthoai }}" name="sodienthoai" type="text">
                    </div>
                </div>
                <div class="form-group">
                    <label for="cname" class="control-label col-lg-3">Ảnh Đại Diện</label>
                    <div class="col-lg-9" id="sanpham">
                        @if (isset($nhanvien->anhdaidien))
                            <img id="imgsanpham" src="upload/anhadmin/{{ $nhanvien->anhdaidien }}" class="imganhdaidien"
                                alt="">
                        @endif
                        <input id="fileanhsanpham" class=" form-control" name="anhdaidien" type="file">
                    </div>
                </div>
                {{-- <div class="form-group">
                        <label for="cname" class="control-label col-lg-3">Chọn Chức Vụ</label>
                        <div class="col-lg-9">
                            <select name="machucvu" >
                                <option value="{{ null }}">--Chọn Chức Vụ</option>
                                @foreach ($chucvu as $cv)
                                    <option value="{{ $cv->id }}">{{ $cv->tenchucvu }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div> --}}
                <div class="form-group">
                    <div class="col-lg-offset-3 col-lg-9">
                        <button class="btn btn-primary" type="submit">Lưu</button>
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
                        $("#sanpham").prepend(
                            `<img id='imgsanpham' src=${event.target.result} width='20' height = '20'>`
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
