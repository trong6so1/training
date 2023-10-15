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
                    <li class="active">Đăng Nhập</li>
                </ol>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <div class="login-form">
                        <!--login form-->
                        <h2>Đăng Nhập</h2>
                        <form action="dangnhap" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="text" placeholder="Name" name="email"
                                @if (session('email')) value="{{ session('email') }}" @endif />
                            <input type="password" placeholder="Nhập Mật Khẩu" name="password"
                                @if (session('matkhau')) value="{{ session('matkhau') }}" @endif />
                            <span><input type="checkbox" />Nhớ Tài Khoản</span>
                            <span style="float: right"><a href="quenmatkhau">Quên Mật Khẩu?</a></span>
                            <h5>Bạn chưa có tài khoản:<a href="dangki">Đăng ký?</a></h5>
                            <button type="submit" class="btn btn-default">Đăng Nhập</button>
                        </form>
                    </div>
                    <!--/login form-->
                </div>
                {{-- <div class="col-sm-1">
                <h2 class="or">OR</h2>
            </div>
            <div class="col-sm-4">
                <div class="signup-form"><!--sign up form-->
                    <h2>Đăng Kí</h2>
                    <form action="dangki" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="text" placeholder="Tên Người Dùng" name="tennguoidung"/>
                        <input type="email" placeholder="Địa Chỉ Email" name="email"/>
                        <input type="text" name="sodienthoai" placeholder="Số Điện Thoại">
                        <input type="text" name="diachi" placeholder="Địa chỉ">
                        <input type="password" placeholder="Password" name="password"/>
                        <input type="password" name="nhaplaipassword" placeholder="Nhập lại mật khẩu">
                        <button type="submit" class="btn btn-default">Signup</button>
                    </form>
                </div><!--/sign up form-->
            </div> --}}
            </div>
        </div>
    </section>
    <!--/form-->
@endsection
