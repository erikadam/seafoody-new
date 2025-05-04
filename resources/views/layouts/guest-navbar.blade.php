<!-- resources/views/layouts/guest-navbar.blade.php -->
<nav class="navbar navbar-expand-lg navigation" id="navbar">
    <div class="container">
      <a class="navbar-brand" href="{{ url('/') }}">
        <img src="{{ asset('theme/images/logo.png') }}" alt="Logo" class="img-fluid">
      </a>

      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarmain"
        aria-controls="navbarmain" aria-expanded="false" aria-label="Toggle navigation">
        <span class="ti-menu"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarmain">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item active">
            <a class="nav-link" href="{{ url('/') }}">Beranda</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Produk</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Tentang Kami</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Kontak</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('login') }}">Masuk</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
