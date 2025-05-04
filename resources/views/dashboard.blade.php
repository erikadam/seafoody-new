<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Akun Belum Disetujui</title>
  <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/font-awesome.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
</head>
<body class="bg-light">
  <div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="col-md-6 bg-white p-5 shadow rounded text-center">
      <h4 class="text-danger mb-3">Akun Belum Disetujui</h4>
      <p class="mb-4">Akun Anda sedang dalam proses persetujuan oleh admin. Silakan tunggu hingga akun Anda disetujui sebelum bisa login.</p>
      <a href="{{ route('logout') }}" class="btn btn-primary">Kembali ke Login</a>
    </div>
  </div>
</body>
</html>
