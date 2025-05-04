<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Register | E-Commerce</title>
  <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/font-awesome.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
</head>
<body class="bg-light">
  <div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="col-md-6 bg-white p-4 shadow rounded">
      <h4 class="text-center mb-4">Register</h4>
      <form method="POST" action="{{ route('register') }}">
        @csrf
        <div class="form-row">
          <div class="form-group col-md-6">
            <label for="name">Nama Toko Anda</label>
            <input type="text" name="name" class="form-control" required autofocus>
          </div>
          <div class="form-group col-md-6">
            <label for="email">Email</label>
            <input type="email" name="email" class="form-control" required>
          </div>
        </div>
        <div class="form-group">
          <label for="password">Password</label>
          <input type="password" name="password" class="form-control" required>
        </div>
        <div class="form-group">
          <label for="password_confirmation">Konfirmasi Password</label>
          <input type="password" name="password_confirmation" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success w-100">Daftar</button>
      </form>
      <div class="text-center mt-3">
        <a href="{{ route('login') }}">Sudah punya akun? Login</a>
      </div>
      <div class="text-center mt-3 col-md-1">
        <a href="/">Kembali</a>
      </div>
    </div>
  </div>
</body>
</html>
