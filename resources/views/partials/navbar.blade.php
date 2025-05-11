<header class="header-area header-sticky">
    <div class="container">
      <nav class="main-nav">
        <a href="{{ url('/') }}" class="logo">Sea<em>foody</em></a>
        <ul class="nav">
          <li><a href="{{ url('/') }}" class="{{ request()->is('/') ? 'active' : '' }}">Beranda</a></li>
          <li><a href="{{ route('guest.products.index') }}" class="{{ request()->routeIs('guest.products.index') ? 'active' : '' }}">Produk</a></li>
          <li><a href="{{ url('/login') }}">Masuk</a></li>
        </ul>
        <a class="menu-trigger"><span>Menu</span></a>
      </nav>
    </div>
  </header>
