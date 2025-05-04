@extends('layouts.guest')

@section('content')
<section class="hero-area">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="hero-slider">
          <div class="slider-item">
            <div class="container">
              <div class="row">
                <div class="col-md-8">
                  <div class="content">
                    <h1 class="mt-3 mb-5">Selamat Datang di Toko Kami</h1>
                    <p class="mb-5">Temukan produk terbaik dari para penjual lokal.</p>
                    <a href="#" class="btn btn-main">Lihat Produk</a>
                  </div>
                </div>
                <div class="col-md-4">
                  <img src="{{ asset('guest/images/slider/slider-img.png') }}" alt="Image" class="img-fluid">
                </div>
              </div>
            </div>
          </div>
          <!-- Tambahkan slider-item lain jika perlu -->
        </div>
      </div>
    </div>
  </div>
</section>
@endsection
