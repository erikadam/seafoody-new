<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>{{ $title ?? config('app.name', 'Admin Panel') }}</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  {{-- Modernize Template CSS --}}
  <link rel="stylesheet" href="{{ asset('assets/css/styles.min.css') }}">
  {{ $head ?? '' }}
</head>
<body>
  <!-- Main Wrapper -->
  <div class="page-wrapper" id="main-wrapper">
    @include('layouts.sidebar')

    <div class="body-wrapper">
      @include('layouts.header')

      <div class="container-fluid">
        {{ $slot }}
      </div>
    </div>
  </div>

  {{-- Modernize JS --}}
  <script src="{{ asset('assets/libs/jquery/dist/jquery.min.js') }}"></script>
  <script src="{{ asset('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('assets/js/sidebarmenu.js') }}"></script>
  <script src="{{ asset('assets/js/app.min.js') }}"></script>
  <script src="{{ asset('assets/libs/simplebar/dist/simplebar.js') }}"></script>

  {{ $scripts ?? '' }}
</body>
</html>
