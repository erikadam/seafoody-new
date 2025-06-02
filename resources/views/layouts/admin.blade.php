<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"> <!-- [GPT] Font Awesome icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"> <!-- [GPT] Bootstrap -->
  <style>
    body {
      background-color: #f8f9fa;
    }
    .sidebar {
      min-height: 100vh;
      background-color: #343a40;
      color: white;
      padding-top: 20px;
    }
    .sidebar a {
      color: white;
      text-decoration: none;
      display: block;
      padding: 10px 20px;
    }
    .sidebar a:hover {
      background-color: #495057;
    }
    .content {
      padding: 20px;
    }
    .sidebar .logo {
      font-size: 1.5rem;
      font-weight: bold;
      text-align: center;
      padding-bottom: 1rem;
      border-bottom: 1px solid #6c757d;
    }
  </style>
</head>
<body>
<div class="d-flex">
  <!-- Sidebar -->
  <div class="sidebar p-3">
    <div class="logo mb-4">
      <i class="fas fa-user-shield me-2"></i>Admin Panel
    </div>
    <a href="{{ route('admin.dashboard') }}">
      <i class="fas fa-tachometer-alt me-2"></i> Dashboard
    </a>
    <a href="{{ route('admin.users.index') }}">
      <i class="fas fa-users me-2"></i> Manajemen User
    </a>
    <a href="{{ route('admin.products.pending') }}">
      <i class="fas fa-box-open me-2"></i> Persetujuan Produk
    </a>
    <a href="{{ route('admin.refunds') }}">
      <i class="fas fa-undo-alt me-2"></i> Refund Transaksi
    </a>
    <a href="{{ route('admin.transfers.index') }}">
      <i class="fas fa-money-check-alt me-2"></i> Validasi Transfer
    </a>
    <a href="{{ route('admin.reports.pdf') }}">
      <i class="fas fa-file-pdf me-2"></i> Laporan PDF
    </a>
    <a href="{{ route('admin.reports.excel') }}">
      <i class="fas fa-file-excel me-2"></i> Laporan Excel
    </a>
    <form method="POST" action="{{ route('logout') }}">
      @csrf
      <button type="submit" class="btn btn-outline-light w-100 mt-4">
        <i class="fas fa-sign-out-alt me-2"></i> Logout
      </button>
    </form>
  </div>

  <!-- Main Content -->
  <div class="content flex-grow-1">
    @yield('content')
  </div>
</div>
</body>
</html>
