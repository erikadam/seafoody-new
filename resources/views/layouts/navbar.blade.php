<!-- Navbar Section -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
      <a class="navbar-brand" href="{{ route('guest.home') }}">Seafoody</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarContent">
        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link" href="{{ route('guest.home') }}">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('guest.products.index') }}">Produk</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('checkout.form') }}">Checkout</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
