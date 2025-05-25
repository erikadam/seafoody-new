@extends('layouts.guest')

@section('title', 'Beranda')

@section('content')

  <!-- Main Banner -->
  <div class="main-banner" id="top">
  <video autoplay muted loop id="bg-video">
    <source src="{{ asset('assets/images/video.mp4') }}" type="video/mp4" />
  </video>
  <div class="video-overlay header-text">
    <div class="caption">
      @guest
        <h6>PESAN BAHAN MAKANAN DAN MAKANAN SEGAR SEKARANG</h6>
        <h2>LOGIN UNTUK MULAI <em>BELANJA</em></h2>
        <div class="main-button">
          <a href="{{ route('login') }}">Login</a>
        </div>
      @else
        @if(Auth::user()->role === 'user' && !Auth::user()->requested_seller)
          <h6>JOIN MENJADI AKUN TOKO</h6>
          <h2>ANDA BISA <em>UPGRADE</em> AKUN</h2>
          <div class="main-button">
            <a href="{{ route('profile.edit') }}">Ajukan</a>
          </div>
        @elseif(Auth::user()->role === 'user' && Auth::user()->requested_seller && !Auth::user()->is_approved)
          <h6>PENGAJUAN SEDANG DIPROSES</h6>
          <h2>TERIMA KASIH TELAH <em>MENGAJUKAN</em></h2>
        @elseif(Auth::user()->role === 'customer' && Auth::user()->is_approved)
          <h6>PASARKAN BAHAN MAUPUN MAKANAN SEGAR ANDA</h6>
          <h2>SELAMAT DATANG <em>{{ Auth::user()->store_name }}</em></h2>
          <div class="main-button">
            <a href="{{ route('customer.dashboard') }}">Halaman Toko</a>

          </div>
          @if(session('error'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    {{ session('error') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
</div>
@endif
        @endif
      @endguest
    </div>
  </div>
</div>
    </div>
  </div>




<section class="category-banner">
    <div class="container">
      <!-- Judul Section -->
      <div class="row">
        <div class="col-lg-6 offset-lg-3">
          <div class="section-heading">
            <h2>PILIH <em>JENIS</em> PRODUK</h2>
            <img src="{{ asset('assets/images/line-dec.png') }}" alt="">
            <p>Produk-produk unggulan yang telah disetujui admin.</p>
          </div>
        </div>
      </div>
        <div class="row g-4">
            <!-- Masakan -->
            <div class="col-md-6">
                <a href="{{ route('guest.products.index', ['category' => 'makanan']) }}" class="d-block position-relative" style="height: 300px;">
                    <div class="position-absolute top-50 start-50 translate-middle">
                        <div class="px-3 py-1 text-white rounded" style="background-color: rgba(247, 95, 54, 0.85);">
                            <h2 class="text-white m-0 hover-lift-title">Masakan</h2>
                        </div>
                    </div>
                    <img src="{{ asset('assets/images/banner-masakan.jpg') }}" class="w-100 h-100 object-fit-cover rounded" alt="Masakan">

                </a>
            </div>
            <!-- Bahan -->
            <div class="col-md-6">
                <a href="{{ route('guest.products.index', ['category' => 'bahan']) }}" class="d-block position-relative" style="height: 300px;">
                    <div class="position-absolute top-50 start-50 translate-middle">
                        <div class="px-3 py-1 text-white rounded" style="background-color: rgba(247, 95, 54, 0.85);">
                            <h2 class="text-white m-0 hover-lift-title">Bahan</h2>
                        </div>
                    </div>
                    <img src="{{ asset('assets/images/banner-bahan.jpg') }}" class="w-100 h-100 object-fit-cover rounded" alt="Bahan">
                </a>
            </div>
        </div>
    </div>
</section>

<style>
.hover-lift-title {
    transition: transform 0.3s ease;
}
a:hover .hover-lift-title {
    transform: translateY(-5px);
}
</style>


<style>
    .category-box {
  position: relative !important;
  overflow: hidden !important;
  z-index: 0;
}
.hover-lift-title {
    transition: transform 0.3s ease, text-shadow 0.3s ease;
}
.category-box:hover .hover-lift-title {
    transform: translateY(-5px);
    text-shadow: 0 2px 8px rgba(0, 0, 0, 0.6);
}
</style>


<style>

.category-overlay-dark {
    background: rgba(0, 0, 0, 0.4);
    transition: background 0.3s ease;
}
.hover-lift-title {
    transition: transform 0.3s ease, text-shadow 0.3s ease;
    margin: 0;
}
.category-box:hover .hover-lift-title {
    transform: translateY(-10px);
    text-shadow: 2px 2px 10px rgba(0, 0, 0, 0.8);
}
.category-caption-box {
  position: absolute;
  bottom: 20px;
  left: 50%;
  transform: translateX(-50%);
}

</style>


<style>
.hover-lift {
    transition: transform 0.3s ease-in-out;
}
.category-photo-banner:hover .hover-lift {
    transform: translate(-50%, -60%);
}

</style>


<style>
    .category-box img {
  transition: transform 0.3s ease;
}
.category-box:hover img {
  transform: scale(1.05);
}

.category-box:hover .overlay {
    opacity: ;
}
</style>
  <!-- Produk Section -->
  <section class="section" id="trainers">
    <div class="container">
      <!-- Judul Section -->
      <div class="row">
        <div class="col-lg-6 offset-lg-3">
          <div class="section-heading">
            <h2>OUR <em>FOODS</em></h2>
            <img src="{{ asset('assets/images/line-dec.png') }}" alt="">
            <p>Produk-produk unggulan yang telah disetujui admin.</p>
          </div>
        </div>
      </div>

      <!-- Produk Cards -->
      <div class="row">
        @forelse($products as $product)
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="trainer-item">
                <a href="{{ route('guest.products.show', $product->id) }}" style="text-decoration: none; color: inherit;">
                    <div class="image-thumb mb-3">
                        <img src="{{ asset('uploads/product/' . $product->image) }}" alt="{{ $product->name }}">
                    </div>
                </a>
                <div class="card-body d-flex flex-column px-0">
                    <h6 class="text-muted small mb-1">Penjual: {{ $product->seller->name ?? 'Tidak diketahui' }}</h6>
                    <h5 class="fw-semibold text-dark mb-1">{{ $product->name }}</h5>
                    <p class="text-muted small mb-2">{{ Str::limit($product->description, 60) }}</p>
                    <div class="fw-semibold fs-5 mb-3" style="color: #f75f36;">
                            Rp{{ number_format($product->price, 0, ',', '.') }}
                    </div>


                    @if($product->seller && $product->seller->is_suspended)
                    <div class="alert alert-warning">
                        <strong>⚠️ Akun Bermasalah.</strong>
                    </div>
                    @endif

                    <form action="{{ route('guest.cart.add') }}" method="POST" class="mt-auto">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <input type="hidden" name="quantity" value="1">
                        <button type="submit" class="btn btn-primary btn-block">Add to Cart</button>
                    </form>
                </div>
            </div>
        </div>
        @empty
        <p class="text-center">Produk belum tersedia.</p>
        @endforelse
    </div>
  </section>


<!-- [GPT] Cleaned & Centered Category Banner -->




@endsection
