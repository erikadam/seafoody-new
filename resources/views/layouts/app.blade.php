<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>{{ $title ?? config('app.name', 'Panel') }}</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
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
    }
    .main-content {
      margin-left: 240px;
      padding: 20px;
      flex: 1;
    }
    .sidebar .nav-link.active {
      font-weight: bold;
      color: #0d6efd;
    }
  </style>
  @yield('head')
</head>
<body>

  {{-- Sidebar --}}
  <div class="sidebar p-3">
    <h4 class="mb-4">Panel</h4>
    <nav class="nav flex-column">
      <a class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}" href="{{ url('/dashboard') }}">Dashboard</a>
      <a class="nav-link {{ request()->is('admin/users') ? 'active' : '' }}" href="{{ route('admin.users.index') }}">Approval User</a>
      <a class="nav-link {{ request()->is('admin/products*') ? 'active' : '' }}" href="{{ route('admin.products.pending') }}">Approval Produk</a>
      <a class="nav-link" href="{{ route('logout') }}"
         onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
    </nav>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
  </div>

  {{-- Main Content --}}
  <div class="main-content">
    @yield('content')
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  @yield('scripts')
</body>
</html>
