@extends('layouts.guest')

@section('content')
<section class="section" id="our-classes">
  <div class="container">
    <div class="row mb-5">
      <div class="col-lg-12 text-center">
        <div class="section-heading">
          <h2>PRODUK TERSEDIA</h2>
          <p>Produk-produk dari berbagai penjual lokal.</p>
        </div>
      </div>
    </div>

    <div class="row">
      @forelse($products as $product)
        <div class="col-lg-4 col-md-6 mb-4">
          <div class="trainer-item card h-100 shadow-sm border-0">
            <div class="image-thumb">
              <a href="{{ route('guest.products.show', $product->id) }}">
                <img src="{{ asset('uploads/product/' . $product->image) }}" class="card-img-top img-fluid" alt="{{ $product->name }}">
              </a>
            </div>
            <div class="down-content card-body">
              <h5 class="card-title mb-1">{{ $product->name }}</h5>
              <p class="card-text text-muted mb-1">Rp{{ number_format($product->price) }}</p>
              <p class="card-text">{{ Str::limit($product->description, 60, '...') }}</p>
              <a href="{{ route('guest.products.show', $product->id) }}" class="btn btn-sm btn-outline-primary mt-2">Lihat Detail</a>
            </div>
          </div>
        </div>
      @empty
        <div class="col-12 text-center">
          <p class="text-muted">Belum ada produk tersedia.</p>
        </div>
      @endforelse
    </div>
  </div>
</section>
@endsection
