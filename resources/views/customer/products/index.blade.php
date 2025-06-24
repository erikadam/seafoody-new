@extends('layouts.customer')

@section('content')
<div class="container-fluid py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h4 text-primary">Daftar Produk</h2>
    </div>

    @if($products->count())
        <div class="row">
            @foreach($products as $product)
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm border-0">
                        @if($product->image)
                        <img src="{{ asset('uploads/product/' . $product->image) }}" class="card-img-top rounded-top" alt="{{ $product->name }}">
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">{{ $product->name }}</h5>
                            <p class="card-text text-muted small">{{ Str::limit($product->description, 100) }}</p>
                            <p class="fw-bold text-success">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>


        <div class="d-flex justify-content-center mt-4">
            {{ $products->links() }}
        </div>
    @else
        <div class="alert alert-warning">Tidak ada produk yang tersedia.</div>
    @endif
</div>
@endsection
