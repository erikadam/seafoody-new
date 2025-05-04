<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Guest Area - @yield('title', 'Beranda')</title>

  <!-- CSS dari Aviato -->
  <link rel="stylesheet" href="{{ asset('theme/plugins/bootstrap/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('theme/plugins/themify-icons/themify-icons.css') }}">
  <link rel="stylesheet" href="{{ asset('theme/plugins/slick-carousel/slick/slick.css') }}">
  <link rel="stylesheet" href="{{ asset('theme/plugins/slick-carousel/slick/slick-theme.css') }}">
  <link rel="stylesheet" href="{{ asset('theme/css/style.css') }}">
</head>
<body>

  {{-- Navbar --}}
  @include('layouts.guest-navbar')

  {{-- Konten --}}
  <div class="main-content mt-5">
    @yield('content')
  </div>

  {{-- Footer --}}
  @includeIf('layouts.guest-footer')

  <!-- JS dari Aviato -->
  <script src="{{ asset('theme/plugins/jquery/jquery.min.js') }}"></script>
  <script src="{{ asset('theme/plugins/bootstrap/js/bootstrap.min.js') }}"></script>
  <script src="{{ asset('theme/plugins/slick-carousel/slick/slick.min.js') }}"></script>
  <script src="{{ asset('theme/plugins/shuffle/shuffle.min.js') }}"></script>
  <script src="{{ asset('theme/js/script.js') }}"></script>
</body>
</html>
