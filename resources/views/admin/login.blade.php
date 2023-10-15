<!--A Design by W3layouts
Author: W3layout
Author URL: http://w3layouts.com
License: Creative Commons Attribution 3.0 Unported
License URL: http://creativecommons.org/licenses/by/3.0/
-->
<!DOCTYPE html>

<head>
    <base href="{{ asset('') }}">
    <title>Đăng Nhập vào admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="keywords"
        content="Visitors Responsive web template, Bootstrap Web Templates, Flat Web Templates, Android Compatible web template, 
Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyEricsson, Motorola web design" />
    <script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
    <!-- bootstrap-css -->
    <link rel="stylesheet" href="back-end/css/bootstrap.min.css">
    <!-- //bootstrap-css -->
    <!-- Custom CSS -->
    <link href="back-end/css/style.css" rel='stylesheet' type='text/css' />
    <link href="back-end/css/style-responsive.css" rel="stylesheet" />
    <!-- font CSS -->
    <link
        href='//fonts.googleapis.com/css?family=Roboto:400,100,100italic,300,300italic,400italic,500,500italic,700,700italic,900,900italic'
        rel='stylesheet' type='text/css'>
    <!-- font-awesome icons -->
    <link rel="stylesheet" href="back-end/css/font.css" type="text/css" />
    <link href="back-end/css/font-awesome.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- //font-awesome icons -->
    <script src="backend/js/jquery2.0.3.min.js"></script>
    <link rel="shortcut icon" href="back-end/images/logo.jpg">
    <link rel="icon" type="image/x-icon" href="back-end/images/logo.jpg" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="sweetalert2.all.min.js"></script>
</head>

<body>
    <div class="log-w3">
        <div class="w3layouts-main">
            <h2>Đăng Nhập</h2>
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
            <form action="admin/login" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="email" class="ggg" name="email" placeholder="E-MAIL">
                <input type="password" class="ggg" name="password" placeholder="PASSWORD">
                {{-- <span><input type="checkbox" />Remember Me</span> --}}
                <h6><a href="admin/quenmatkhau">Quên Mật Khẩu?</a></h6>
                <div class="clearfix"></div>
                <input type="submit" value="Đăng Nhập" name="login">
            </form>
        </div>
    </div>
    <script src="backend/js/bootstrap.js"></script>
    <script src="backend/js/jquery.dcjqaccordion.2.7.js"></script>
    <script src="backend/js/scripts.js"></script>
    <script src="backend/js/jquery.slimscroll.js"></script>
    <script src="backend/js/jquery.nicescroll.js"></script>
    <!--[if lte IE 8]><script language="javascript" type="text/javascript" src="backend/js/flot-chart/excanvas.min.js"></script><![endif]-->
    <script src="backend/js/jquery.scrollTo.js"></script>
</body>

</html>
