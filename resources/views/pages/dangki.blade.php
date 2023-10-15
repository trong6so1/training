@extends('layout.main')
@section('content')
    <section id="form">
        <!--form-->
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
        <div class="container">
            <div class="breadcrumbs">
                <ol class="breadcrumb">
                    <li><a href="trangchu">Trang Chủ</a></li>
                    <li class="active">Đăng Ký</li>
                </ol>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <div class="signup-form">
                        <!--sign up form-->
                        <h2>Đăng Kí Tài Khoản</h2>
                        <form action="dangki" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="text" placeholder="Nhập Tên Người Dùng" name="tennguoidung" />
                            <input type="email" placeholder="Nhập Email" name="email" />
                            <input type="text" name="sodienthoai" placeholder="Số Điện Thoại">
                            <input type="file" name="anhdaidien" id="fileanhsanpham" placeholder="Chọn Ảnh Đại Diện">
                            <input type="password" placeholder="Nhập Mật Khẩu" name="matkhau" />
                            <input type="password" name="nhaplaimatkhau" placeholder="Nhập lại mật khẩu">
                            <button type="submit" class="btn btn-default">Đăng Ký</button>
                        </form>
                    </div>
                    <!--/sign up form-->
                </div>
            </div>
        </div>
    </section>
    <!--/form-->
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
                        $("#fileanhsanpham").before(
                            `<img id='imgsanpham' src=${event.target.result} width='50px' height = '50px'>`
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
