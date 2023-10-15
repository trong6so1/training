<!DOCTYPE html>
<html lang="en">

<head>
    <base href="{{ asset('') }}">
    @yield('seo')
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="">
    <meta name="robots" content="INDEX,FOLLOW" />
    <link rel="shortcut icon" href="front-end/images/home/logo.png">
    <link rel="canonical" href="{{ url()->current() }}" />
    <link rel="icon" type="image/x-icon" href="front-end/images/home/logo.png" />
    <title>Shop Đồ Uống</title>
    <link href="front-end/css/bootstrap.min.css" rel="stylesheet">
    <link href="front-end/css/font-awesome.min.css" rel="stylesheet">
    <link href="front-end/css/prettyPhoto.css" rel="stylesheet">
    <link href="front-end/css/price-range.css" rel="stylesheet">
    <link href="front-end/css/animate.css" rel="stylesheet">
    <link href="front-end/css/main.css" rel="stylesheet">
    <link href="front-end/css/responsive.css" rel="stylesheet">
    <!--[if lt IE 9]>
    <script src="front-end/js/html5shiv.js"></script>
    <script src="front-end/js/respond.min.js"></script>
    <![endif]-->

    <link rel="apple-touch-icon-precomposed" sizes="144x144"
        href="front-end/images/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114"
        href="front-end/images/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72"
        href="front-end/images/ico/apple-touch-icon-72-precomposed.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <link rel="apple-touch-icon-precomposed" href="front-end/images/ico/apple-touch-icon-57-precomposed.png">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="sweetalert2.all.min.js"></script>

</head>
<!--/head-->

<body>
    @include('layout.header')

    @yield('content')
    <!-- Messenger Plugin chat Code -->
    <div id="fb-root"></div>

    <!-- Your Plugin chat code -->
    <div id="fb-customer-chat" class="fb-customerchat">
    </div>

    <script>
        var chatbox = document.getElementById('fb-customer-chat');
        chatbox.setAttribute("page_id", "106909755249501");
        chatbox.setAttribute("attribution", "biz_inbox");
    </script>

    <!-- Your SDK code -->
    <script>
        window.fbAsyncInit = function() {
            FB.init({
                xfbml: true,
                version: 'v15.0'
            });
        };

        (function(d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s);
            js.id = id;
            js.src = 'https://connect.facebook.net/vi_VN/sdk/xfbml.customerchat.js';
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
    </script>
    @include('layout.footer')


    @yield('script')
    <script src="front-end/js/jquery.js"></script>
    <script src="front-end/js/bootstrap.min.js"></script>
    {{-- <script src="front-end/js/jquery.scrollUp.min.js"></script> --}}
    <script src="front-end/js/price-range.js"></script>
    <script src="front-end/js/jquery.prettyPhoto.js"></script>
    <script src="front-end/js/main.js"></script>
    <div id="fb-root"></div>
    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v15.0"
        nonce="HoPWizld"></script>
    <div id="fb-root"></div>
    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v15.0"
        nonce="XDRL64MG"></script>
    <!-- Messenger Plugin chat Code -->
</body>

</html>
