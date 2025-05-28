<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>{{ $title }}</title>
  <link rel="icon" type="image/png" href="{{ asset('assets/img/logo.png') }}" sizes="32x32">
  <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/img/logo.png') }}">
  <link rel="stylesheet" href="{{ asset('mobilekit/assets/css/style.css') }}">
  <link rel="manifest" href="{{ asset('mobilekit/__manifest.json') }}">

</head>
<body class="bg-white">

    @yield('auth')
    <!-- ///////////// Js Files ////////////////////  -->
    <!-- Jquery -->
    <script src="{{ asset('mobilekit/assets/js/lib/jquery-3.4.1.min.js') }}"></script>
    <!-- Bootstrap-->
    <script src="{{ asset('mobilekit/assets/js/lib/popper.min.js') }}"></script>
    <script src="{{ asset('mobilekit/assets/js/lib/bootstrap.min.js') }}"></script>
    <!-- Ionicons -->
    <script type="module" src="https://unpkg.com/ionicons@5.0.0/dist/ionicons/ionicons.js"></script>
    <!-- Owl Carousel -->
    <script src="{{ asset('mobilekit/assets/js/plugins/owl-carousel/owl.carousel.min.js') }}"></script>
    <!-- jQuery Circle Progress -->
    <script src="{{ asset('mobilekit/assets/js/plugins/jquery-circle-progress/circle-progress.min.js') }}"></script>
    <!-- Base Js File -->
    <script src="{{ asset('mobilekit/assets/js/base.js') }}"></script>


</body>

</html>