<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>{{ $title ?? config('app.name', 'Admin Panel') }}</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Unified CSS from guest layout -->
  <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/css/font-awesome.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">

  <style>
    .admin-wrapper {
      min-height: 100vh;
      display: flex;
      flex-direction: row;
    }
    .sidebar {
      width: 240px;
      background-color: #f8f9fa;
      padding: 20px;
      height: 100vh;
      position: sticky;
      top: 0;
    }
    .main-content {
      flex-grow: 1;
      padding: 30px;
      background-color: #fff;
    }
    .nav-link.active {
      font-weight: bold;
      color: #0d6efd;
    }
  </style>

  @yield('head')
</head>
<body>

<div class="admin-wrapper">
  {{-- Sidebar --}}
  <aside class="sidebar">
    <h4 class="mb-4">Admin Panel</h4>
    <nav class="nav flex-column">
      <a class="nav-link {{ request()->is('admin/dashboard') ? 'active' : '' }}" href="{{ url('admin/dashboard') }}">Dashboard</a>
      <a class="nav-link {{ request()->is('admin/users') ? 'active' : '' }}" href="{{ route('admin.users.index') }}">Approval User</a>
      <li class="nav-item"><a class="nav-link" href="{{ url('admin/users/management') }}"><i class="fa fa-users me-2"></i> Manajemen User</a></li>
      @php
    $pendingCount = \App\Models\Product::where('status', 'pending')->count();
@endphp
<a class="nav-link {{ request()->is('admin/products*') ? 'active' : '' }}" href="{{ route('admin.products.pending') }}">
    Approval Produk
    @if ($pendingCount > 0)
        <span class="badge bg-danger">{{ $pendingCount }}</span>
    @endif
</a>

      <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="btn btn-sm btn-danger mt-3">Logout</button>
      </form>
    </nav>
  </aside>

  {{-- Main Content --}}
  <main class="main-content">
    @yield('content')
  </main>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
