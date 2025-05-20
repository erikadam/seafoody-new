<header class="header-area header-sticky">
    <div class="container">
      <div class="row">
        <div class="col-12">
          <nav class="main-nav">
            <!-- ***** Logo Start ***** -->
            <a href="/" class="logo">Seafoody</a>
            <!-- ***** Logo End ***** -->
            <!-- ***** Menu Start ***** -->
            <ul class="nav">
              <li><a href="/" class="{{ request()->is('/') ? 'active' : '' }}">Beranda</a></li>
              <li><a href="/product" class="{{ request()->is('product') ? 'active' : '' }}">Produk</a></li>

@guest
  <li><a href="{{ route('login') }}">Masuk</a></li>
  <li><a href="{{ route('register') }}">Daftar</a></li>
@endguest

@auth
  <li class="dropdown">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
      <img src="{{ Auth::user()->avatar ?? '/images/default-avatar.png' }}" width="24" class="rounded-circle">
      {{ Auth::user()->name }}
    </a>
    <ul class="dropdown-menu">
      <li><a href="{{ route('profile.edit') }}">Edit Profil</a></li>
      <li>
        <form method="POST" action="{{ route('logout') }}">
          @csrf
          <button type="submit" class="dropdown-item">Logout</button>
        </form>
      </li>
    </ul>
  </li>
@endauth

                <a href="{{ route('guest.cart.index') }}" class="nav-link">
                  🛒 Keranjang
                  @php
                    $cartCount = is_array(session('cart')) ? count(session('cart')) : 0;
                  @endphp
                  @if($cartCount > 0)
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                      {{ $cartCount }}
                    </span>
                  @endif
                </a>
            </ul>
            <a class="menu-trigger"><span>Menu</span></a>
            <!-- ***** Menu End ***** -->
          </nav>
        </div>
      </div>
    </div>
  </header>
