
@extends('layouts.guest')

@section('content')

<style>
.trainer-item {
    background-color: #fff;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 8px 20px rgba(0,0,0,0.1);
    transition: all 0.3s ease-in-out;
    height: 100%;
    display: flex;
    flex-direction: column;
}
.trainer-item:hover {
    transform: translateY(-5px);
    box-shadow: 0 12px 30px rgba(0,0,0,0.15);
}
.image-thumb img {
    width: 100%;
    height: 200px;
    object-fit: cover;
    border-radius: 8px;
}
</style>

@php
    $categoryBanner = match($activeCategory) {
        'makanan' => 'assets/images/banner-masakan.jpg',
        'bahan' => 'assets/images/banner-bahan.jpg',
        default => 'assets/images/banner-default.jpg'
    };
@endphp
@if(isset($activeCategory))
<section class="section section-bg" id="call-to-action" style="background-image: url('{{ asset($categoryBanner) }}')">
  <div class="container">
    <div class="row">
      <div class="col-lg-10 offset-lg-1">
        <div class="cta-content">
          <br><br>
          <h2>Judul <em>Kategori</em></h2>
          <p>Deskripsi singkat kategori akan Anda isi nanti.</p>
        </div>
      </div>
    </div>
  </div>
</section>
@else
<section class="section section-bg" id="call-to-action" style="background-image: url('{{ asset('assets/images/banner-masakan.jpg') }}')">
  <div class="container">
    <div class="row">
      <div class="col-lg-10 offset-lg-1">
        <div class="cta-content">
          <br><br>
          <h2>Semua <em>Kategori</em></h2>
          <p>Deskripsi singkat kategori akan Anda isi nanti.</p>
        </div>
      </div>
    </div>
  </div>
</section>
 @endif
<div class="container py-4">
    @if(isset($activeCategory))
        <h4 class="mb-4"style="color: #f75f36;"><em>Menampilkan Kategori: </em><strong>{{ ucfirst($activeCategory) }}</strong></em></h4>
    @else
        <h4 class="mb-4">Semua Produk</h4>
    @endif

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

    <div class="d-flex justify-content-center mt-4">
        {{ $products->links() }}
    </div>
</div>
@endsection
