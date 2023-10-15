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
                <div class="col-sm-4">
                    <div class="signup-form">
                        <!--sign up form-->
                        <h2>Đặt Lại Mật Khẩu</h2>
                        <form action="datlaimatkhau/{{ $id }}" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="password" placeholder="Nhập Mật Khẩu Mới" name="matkhau" />
                            <button type="submit" class="btn btn-default">Đổi</button>
                        </form>
                    </div>
                    <!--/sign up form-->
                </div>
            </div>
        </div>
    </section>
    <!--/form-->
@endsection
