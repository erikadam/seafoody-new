<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'Dashboard Customer')</title>
  <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/font-awesome.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"> <!-- [GPT] Font Awesome icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"> <!-- [GPT] Bootstrap -->
  <style>
    body {
      background-color: #f8f9fa;
    }
    .sidebar {
      width: 250px;
      background-color: #ffffff;
      border-right: 1px solid #dee2e6;
      min-height: 100vh;
      padding-top: 2rem;
    }
    .sidebar .nav-link {
      color: #333;
      padding: 10px 16px;
      display: flex;
      align-items: center;
      gap: 10px;
      border-radius: 4px;
      transition: 0.2s;
    }
    .sidebar .nav-link:hover,
    .sidebar .nav-link.active {
      background-color: #e9ecef;
      font-weight: 500;
    }
    .store-logo {
      width: 70px;
      height: 70px;
      object-fit: cover;
      border-radius: 50%;
      border: 2px solid #f1f1f1;
      box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
  </style>
  @stack('styles')
</head>
<body>
<div class="d-flex">

  <!-- Sidebar -->
  <aside class="sidebar">
    <div class="text-center mb-4">
      @if(Auth::user()->store_logo)
        <img src="{{ asset('storage/' . Auth::user()->store_logo) }}" class="store-logo mb-2" alt="Logo Toko">
      @else
        <img src="{{ asset('assets/images/default-logo.png') }}" class="store-logo mb-2" alt="Default Logo">
      @endif
      <h6 class="mb-0">{{ Auth::user()->store_name ?? 'Toko Anda' }}</h6>
      <small class="text-muted">{{ Auth::user()->email }}</small>
    </div>
     <li class="nav-item mb-2">
          <a class="nav-link" href="{{ url('customer/profile') }}">
            <i class="fa fa-user me-2"></i> Profil
          </a>
           <a class="nav-link text-danger" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
        <i class="fa fa-sign-out"></i> Logout
      </a>
        </li>
    <hr>
    <nav class="nav flex-column px-3">
      <a class="nav-link {{ request()->is('customer/dashboard') ? 'active' : '' }}" href="{{ url('customer/dashboard') }}">
        <i class="fa fa-home"></i> Dashboard
      </a>
      <a class="nav-link {{ request()->is('customer/products/create') ? 'active' : '' }}" href="{{ url('customer/products/create') }}">
        <i class="fa fa-plus"></i> Tambah Produk
      </a>
      <a class="nav-link {{ request()->is('customer/products/my-product') ? 'active' : '' }}" href="{{ url('customer/products/my-product') }}">
        <i class="fa fa-box"></i> Produk Saya
      </a>
      <a class="nav-link {{ request()->is('customer/orders') ? 'active' : '' }}" href="{{ url('customer/orders') }}">
        <i class="fa fa-box-open me-2"></i> Orders
      </a>
<div class="d-flex justify-content-between align-items-center mb-4">
        <a href="{{ url('/') }}" class="btn btn-outline-primary">
            <i class="fa fa-home"></i> Kembali ke Home
        </a>
    </div>

      <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
      </form>
    </nav>
  </aside>

  <!-- Content -->
  <main class="flex-grow-1 p-4">
    @yield('content')
  </main>

</div>

<script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
@stack('scripts')
</body>
</html>
