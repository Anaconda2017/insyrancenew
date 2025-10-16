<!DOCTYPE html>
<html lang="en">

<head>
<!-- Meta Tags
    ============================================= -->
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1.0, shrink-to-fit=no">
<meta name="description" content="">
<meta name="author" content="Digital Bond">
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<!-- Your Title Page
    ============================================= -->
<title>@yield('title')</title>
<!-- Favicon Icons
     ============================================= -->
<link rel="shortcut icon" href="{{ asset('frontend/images/Logo-onBlack.png') }}">
<!-- Bootstrap Links
     ============================================= -->
<!-- Bootstrap CSS  -->
<link
    href="https://fonts.googleapis.com/css2?family=Teko:wght@300;400;500;600;700&amp;display=swap"
    rel="stylesheet"
/>
{{-- <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Heebo:400,500,700%7cRajdhani:400,500,600,700&display=swap"> --}}
<!-- Plugins
     ============================================= -->
<!-- Owl Carousal -->
<link href="{{ asset('frontend/css/bootstrap.css') }}" rel="stylesheet">
<link href="{{ asset('frontend/css/fontawesome-all.css') }}" rel="stylesheet">
<link href="{{ asset('frontend/css/owl.css') }}" rel="stylesheet">
<link href="{{ asset('frontend/css/flaticon.css') }}" rel="stylesheet">
<link href="{{ asset('frontend/css/animate.css') }}" rel="stylesheet">
<link href="{{ asset('frontend/css/jquery-ui.css') }}" rel="stylesheet">
<link href="{{ asset('frontend/css/jquery.fancybox.min.css') }}" rel="stylesheet">
<link href="{{ asset('frontend/css/hover.css') }}" rel="stylesheet">
<link href="{{ asset('frontend/css/jarallax.css') }}" rel="stylesheet">
<link href="{{ asset('frontend/css/custom-animate.css') }}" rel="stylesheet">
<link href="{{ asset('frontend/css/style.css') }}" rel="stylesheet">
<link href="{{ asset('frontend/css/style.css') }}" rel="stylesheet">
<link href="{{ asset('frontend/css/responsive.css') }}" rel="stylesheet">
<link href="{{ asset('frontend/css/colors/color-default.css') }}" rel="stylesheet" id="jssDefault">

@if(app()->getLocale() == 'ar')
    <link href="{{ asset('frontend/css/rtl.css') }}" rel="stylesheet">
@endif

</head>
<body class="body-dark">
    @yield('digitalbond')

    <!-- Core JS Libraries -->
    <script src="{{ asset('frontend/js/jquery.js') }}" type="text/javascript"></script>
    <script src="{{ asset('frontend/js/popper.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('frontend/js/bootstrap.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('frontend/js/TweenMax.js') }}" type="text/javascript"></script>
    <script src="{{ asset('frontend/js/jquery-ui.js') }}" type="text/javascript"></script>
    <script src="{{ asset('frontend/js/jquery.fancybox.js') }}" type="text/javascript"></script>
    <script src="{{ asset('frontend/js/owl.js') }}" type="text/javascript"></script>
    <script src="{{ asset('frontend/js/mixitup.js') }}" type="text/javascript"></script>
    <script src="{{ asset('frontend/js/appear.js') }}" type="text/javascript"></script>
    <script src="{{ asset('frontend/js/wow.js') }}" type="text/javascript"></script>
    <script src="{{ asset('frontend/js/jQuery.style.switcher.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('frontend/js/jquery.easing.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('frontend/js/jarallax.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('frontend/js/custom-script.js') }}" type="text/javascript"></script>
    {{-- <script src="{{ asset('frontend/js/lang.js') }}" type="text/javascript"></script>
    <script src="{{ asset('frontend/js/color-switcher.js') }}" type="text/javascript"></script> --}}


    @yield('scripts')
</body>
</html>