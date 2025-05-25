<header class="header-area header-sticky">
    <div class="container">
      <div class="row">
        <div class="col-12">
          <nav class="main-nav">
            <!-- ***** Logo Start ***** -->
            <a href="/" class="logo">Website<em> Seafoody</em> </a>
            <!-- ***** Logo End ***** -->
            <!-- ***** Menu Start ***** -->
            <ul class="nav">
              <li><a href="/" class="{{ request()->is('/') ? 'active' : '' }}">Beranda</a></li>
              <li><a href="/produk" class="{{ request()->is('product') ? 'active' : '' }}">Produk</a></li>
              @guest
                 <li>
    <a href="{{ route('login') }}" class="text-white">Masuk</a>
  </li>
@endguest



@auth
  <li class="dropdown" style="position: relative;">
    <a href="#" class="dropdown-toggle d-flex align-items-center px-3 py-1 rounded" data-toggle="dropdown"
       style="background-color: rgba(243, 85, 37, 0.85); color: white; border-radius: 6px;">
      <img src="{{ Auth::user()->avatar ?? '/images/default-avatar.png' }}" width="22" height="22" class="rounded-circle me-2">
      <span style="font-size: 14px;">{{ Auth::user()->name }}</span>
    </a>
    <ul class="dropdown-menu mt-1" style="background-color: rgba(243, 85, 37, 0.95); border-radius: 8px; min-width: 140px;">
  <li>
    <a href="{{ route('profile.edit') }}" class="dropdown-item text-white color:rgb(255, 0, 0)e;" style="font-size: 14px; ">
      Edit Profil
    </a>
  </li>
<li>
    <a href="/track-order" class="dropdown-item text-white color:rgb(255, 0, 0)e;" style="font-size: 14px; ">
      Riwayat Pesanan
    </a>
  </li>
  <li>
    <form method="POST" action="{{ route('logout') }}">
      @csrf
      <button type="submit" class="dropdown-item text-white, fa fa-sign-out-alt me-2" style="font-size: 14px;">Logout</button>
    </form>
  </li>
</ul>
  </li>
  <style>
    .dropdown-menu .dropdown-item:hover {
  background-color: #fff !important;
  color: #f35525 !important;
}
  </style>
@endauth


                <a href="{{ route('guest.cart.index') }}" class="nav-link position-relative">
  <i class="fas fa-shopping-cart"></i>
  @php
                    $cartCount = is_array(session('cart')) ? count(session('cart')) : 0;
                  @endphp
  @if($cartCount > 0)
    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
      {{ $cartCount }}
    </span>
  @endif
</a>
            <a class="menu-trigger"><span>Menu</span></a>
            <!-- ***** Menu End ***** -->
          </nav>
           </nav>
        </div>
      </div>
    </div>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  </header>
