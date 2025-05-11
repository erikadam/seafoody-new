@extends('layouts.app')

@section('content')
  <h2>Daftar Produk</h2>

  @if($products->count())
    <div class="row">
      @foreach($products as $product)
        <div class="col-md-4 mb-4">
          <div class="card h-100">
            @if($product->image)
            <img src="{{ asset('uploads/product/' . $product->image) }}" alt="{{ $product->name }}">
            @endif
            <div class="card-body">
              <h5 class="card-title">{{ $product->name }}</h5>
              <p class="card-text">{{ $product->description }}</p>
              <p class="fw-bold">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
            </div>
          </div>
        </div>
      @endforeach
    </div>

    <div class="d-flex justify-content-center">
      {{ $products->links() }}
    </div>
  @else
    <p>Tidak ada produk yang tersedia.</p>
  @endif
@endsection
