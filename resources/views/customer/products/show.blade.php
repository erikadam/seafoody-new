@extends('layouts.customer')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm border-0">
        <div class="row g-0">
            <div class="col-md-5">
                @if($product->image)
                <img src="{{ asset('uploads/product/' . $product->image) }}" class="img-fluid rounded-start w-100 h-100 object-fit-cover" alt="{{ $product->name }}">
                @else
                <div class="d-flex align-items-center justify-content-center h-100 bg-light text-muted">
                    <span class="p-4">Tidak ada gambar</span>
                </div>
                @endif
            </div>
            <div class="col-md-7">
                <div class="card-body">
                    <h2 class="card-title text-primary">{{ $product->name }}</h2>
                    <p class="text-muted mb-2">Kategori : {{ ucfirst($product->category) }}</p>
                    <h4 class="text-success fw-bold mb-3">Rp {{ number_format($product->price, 0, ',', '.') }}</h4>
                    <p class="card-text mb-4">{{ $product->description }}</p>
                    <p class="text-muted small">Stok: {{ $product->stock }}</p>
                    <span class="badge bg-secondary">{{ ucfirst($product->status) }}</span>
                    <div class="mt-4">
                        <a href="{{ url('customer/products/my-product') }}" class="btn btn-outline-secondary">Kembali</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
