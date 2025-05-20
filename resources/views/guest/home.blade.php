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
          <h2>TERIMA KASIH TELAH MENGAJUKAN</h2>
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
        <div class="col-lg-3 col-md-6 mb-4">
          <div class="trainer-item">
            <a href="{{ route('guest.products.show', $product->id) }}" style="text-decoration: none; color: inherit;">
              <div class="image-thumb">
                <img src="{{ asset('uploads/product/' . $product->image) }}" alt="{{ $product->name }}">
              </div>
              <div class="down-content">

                <span>Rp{{ number_format($product->price) }}</span>
                @if($product->seller)
                <p class="mb-3">Penjual: <strong>{{ $product->seller->name ?? 'Tidak diketahui' }}</strong></p>
                @endif
                <h4>{{ $product->name }}</h4>
                <p>{{ Str::limit($product->description, 40) }}</p>
              </div>
            </a>

            {{-- Tombol Add to Cart --}}
             @if($product->seller->is_suspended)
            <div class="alert alert-warning">
                  <strong>⚠️Akun Bermasalah.</strong>
             </div>
            @endif
            <form action="{{ route('guest.cart.add') }}" method="POST" class="mt-2">
              @csrf
              <input type="hidden" name="product_id" value="{{ $product->id }}">
              <input type="hidden" name="quantity" value="1">

              <button type="submit" class="btn btn-primary btn-block">Add to Cart</button>
            </form>
          </div>
        </div>
        @empty
        <p class="text-center">Produk belum tersedia.</p>
        @endforelse
      </div>
    </div>
  </section>
@endsection
