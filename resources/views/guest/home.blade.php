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
        <h6>LOREM IPSUM DOLOR SIT AMET</h6>
        <h2>BEST <em>FOOD STORE</em> IN TOWN</h2>
        <div class="main-button">
          <a href="#contact">Contact Us</a>
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
          <!-- Produk Cards -->
          <div class="row">
            @forelse($products as $product)
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="trainer-item">

                  <!-- Klik seluruh isi ini akan masuk ke halaman show -->
                  <a href="{{ route('guest.products.show', $product->id) }}" style="text-decoration: none; color: inherit;">
                    <div class="image-thumb">
                      <img src="{{ asset('uploads/product/' . $product->image) }}" alt="{{ $product->name }}">
                    </div>
                    <div class="down-content">
                      <span>Rp{{ number_format($product->price) }}</span>
                      <h4>{{ $product->name }}</h4>
                      <p>{{ Str::limit($product->description, 40) }}</p>
                    </div>
                  </a>

                  <!-- Tombol Add to Cart -->
                  <div class="text-center mt-2">
                    <a href="{{ route('cart.add', $product->id) }}" class="btn btn-sm btn-primary">
                      Tambahkan ke Keranjang
                    </a>
                  </div>

                </div>
              </div>

            @empty
              <div class="col-12 text-center">
                <p>Belum ada produk yang tersedia.</p>
              </div>
            @endforelse
          </div>

          <!-- Tombol Lihat Semua -->
          <div class="text-center mt-4">
            <div class="main-button">
              <a href="{{ route('guest.products.index') }}">View Our Products</a>
            </div>
          </div>

        </div>
      </section>

    @endsection
