<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>{{ $title ?? config('app.name', 'Customer Panel') }}</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  {{-- [GPT] Tambahan styling modern --}}
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

  <style>
    body {
      min-height: 100vh;
      display: flex;
    }
    .sidebar {
      width: 240px;
      background: #f8f9fa;
      height: 100vh;
      position: fixed;
      border-right: 1px solid #dee2e6;
    }
    .main-content {
      margin-left: 240px;
      padding: 24px;
      flex: 1;
      background-color: #fdfdfd;
    }
    .sidebar .nav-link {
      color: #333;
      padding: 10px 0;
      transition: 0.2s;
    }
    .sidebar .nav-link:hover {
      color: #0d6efd;
    }
    .sidebar .nav-link.active {
      font-weight: bold;
      color: #0d6efd;
    }
  </style>

  @yield('head')
</head>
<body>

  {{-- [GPT] Sidebar --}}
  <div class="sidebar p-3">
    <h4 class="mb-4">Toko: {{ Auth::user()->store_name ?? Auth::user()->name }}</h4>
    <nav class="nav flex-column">
      <a class="nav-link {{ request()->is('customer/dashboard') ? 'active' : '' }}" href="{{ url('customer/dashboard') }}">
        <i class="fa fa-chart-line me-2"></i> Dashboard
      </a>
      <a class="nav-link {{ request()->is('customer/products/create') ? 'active' : '' }}" href="{{ url('customer/products/create') }}">
        <i class="fa fa-upload me-2"></i> Tambah Produk
      </a>
      <a class="nav-link {{ request()->is('customer/products/my-product') ? 'active' : '' }}" href="{{ url('customer/products/my-product') }}">
        <i class="fa fa-box-open me-2"></i> Produk Saya
      </a>
      <a class="nav-link {{ request()->is('customer/profile') ? 'active' : '' }}" href="{{ url('customer/profile') }}">
        <i class="fa fa-user me-2"></i> Profil
      </a>
      <a class="nav-link" href="{{ route('logout') }}"
         onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
        <i class="fa fa-sign-out-alt me-2"></i> Logout
      </a>
    </nav>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
  </div>

  {{-- [GPT] Area konten utama --}}
  <div class="main-content">
    @yield('content')
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  @yield('scripts')
</body>
</html>
