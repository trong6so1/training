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
            <div class="row">
                <div class="col-sm-6 col-sm-offset-3">
                    <div class="quenmatkhau">
                        <!--sign up form-->
                        <h1>Thông Báo</h1>
                        <form action="login" method="GET" enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <p>Chúng tôi đã gửi email xác nhận đến tài khoản này vui
                                lòng truy cập email để lấy lại mật khẩu</p>
                            <button type="submit" class="btn btn-default">Quay Về</button>
                        </form>
                    </div>
                    <!--/sign up form-->
                </div>
            </div>
        </div>
    </section>
    <!--/form-->
@endsection
