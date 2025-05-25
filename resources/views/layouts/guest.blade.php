<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title> Seafoody - @yield('title', 'Home')</title>
  <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/font-awesome.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
</head>
<body>

  <!-- Preloader -->
  <div id="js-preloader" class="js-preloader">
    <div class="preloader-inner">
      <span class="dot"></span>
      <div class="dots"><span></span><span></span><span></span></div>
    </div>
  </div>

  <!-- Header -->
  @include('partials.navbar')

  <!-- Main Content -->
  <main>
    @yield('content')

  </main>

  <!-- Footer -->
  @include('partials.footer')

  <!-- Scripts -->
  <script src="{{ asset('assets/js/jquery-2.1.0.min.js') }}"></script>
  <script src="{{ asset('assets/js/popper.js') }}"></script>
  <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
  <script src="{{ asset('assets/js/scrollreveal.min.js') }}"></script>
  <script src="{{ asset('assets/js/waypoints.min.js') }}"></script>
  <script src="{{ asset('assets/js/jquery.counterup.min.js') }}"></script>
  <script src="{{ asset('assets/js/imgfix.min.js') }}"></script>
  <script src="{{ asset('assets/js/mixitup.js') }}"></script>
  <script src="{{ asset('assets/js/accordions.js') }}"></script>
  <script src="{{ asset('assets/js/custom.js') }}"></script>
</body>
@if(session('success'))
  <div id="toast-alert" style="
    position: fixed;
    top: 70px;
    right: 20px;
    background-color: #38c172;
    color: white;
    padding: 10px 20px;
    border-radius: 6px;
    z-index: 9999;
    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    font-size: 14px;
  ">
    {{ session('success') }}
  </div>

  <script>
    setTimeout(() => {
      const toast = document.getElementById('toast-alert');
      if (toast) toast.style.display = 'none';
    }, 3000);
  </script>
@endif

</html>
