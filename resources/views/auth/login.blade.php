
@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login | E-Commerce</title>
  <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/font-awesome.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
</head>
<body class="bg-light">
  <div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="col-md-4 bg-white p-4 shadow rounded">
      <h4 class="text-center mb-4">Login</h4>
      @if ($errors->any())
  <div class="alert alert-danger">
    @foreach ($errors->all() as $error)
      <p class="mb-0">{{ $error }}</p>
    @endforeach
  </div>
@endif
      <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="form-group mb-3">
          <label for="email">Email</label>
          <input type="email" name="email" class="form-control" required autofocus>
        </div>
        <div class="form-group mb-4">
          <label for="password">Password</label>
          <input type="password" name="password" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary w-100">Login</button>
      </form>
      <div class="text-center mt-3">
        <a href="{{ route('register') }}">Belum punya akun? Daftar</a>

    </div>
    <div class="text-center mt-6">
        <a href="/">Kembali ke Beranda</a>
  </div>
  </div>
</body>
</html>
