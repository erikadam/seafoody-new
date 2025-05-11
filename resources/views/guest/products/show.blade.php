@extends('layouts.guest')

@section('title', 'Detail Produk')

@section('content')

<!-- Banner -->
<section class="section section-bg" style="padding-top: 120px; background-image: url('{{ asset('uploads/product/' . $product->image) }}'); background-size: cover;">

  <div class="container">
    <div class="row justify-content-center text-center">
      <div class="col-lg-10">
        <div class="cta-content py-5">
          <h2>
            <del>Rp{{ number_format($product->price + 10000) }}</del>
            <em class="text-danger">Rp{{ number_format($product->price) }}</em>
          </h2>
          <p class="text-white">{{ $product->name }}</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Detail Produk -->
<section class="section my-5">
  <div class="container">
    <div class="row">
      <!-- Gambar Produk -->
      <div class="col-md-6 mb-4">
        <div class="card border-0 shadow-sm">
          <img class="card-img-top img-fluid" src="{{ asset('uploads/product/' . $product->image) }}" alt="{{ $product->name }}">
        </div>
      </div>

      <!-- Deskripsi Produk & Aksi -->
      <div class="col-md-6">
        <h4>{{ $product->name }}</h4>
        <p class="text-muted">{{ $product->description }}</p>
        <h5 class="mt-4 text-success">Rp{{ number_format($product->price) }}</h5>

        <form action="{{ route('cart.add', $product->id) }}" method="GET" class="mt-3">
          <div class="form-group">
            <label for="qty">Jumlah</label>
            <input type="number" name="qty" id="qty" class="form-control" min="1" value="1">
          </div>
          <button type="submit" class="btn btn-danger btn-block mt-3">
            🛒 Tambahkan ke Keranjang
          </button>
        </form>
        <div class="mt-4">
            <h6 class="text-muted">Deskripsi Produk</h6>
            <p class="text-dark" style="line-height: 1.8;">
              {{ $product->description }}
            </p>
          </div>
      </div>
    </div>
  </div>
</section>

@endsection
