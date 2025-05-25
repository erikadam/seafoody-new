
@extends('layouts.guest')

@section('content')

<style>
.text-orange {
  color: #f75f36;
}
</style>

<div class="container py-5 mt-5">
    <div class="row align-items-center">
        <div class="col-md-6 mb-5">
            @if($product->image)
                <img src="{{ asset('uploads/product/' . $product->image) }}" class="img-fluid rounded" alt="{{ $product->name }}">
            @else
                <div class="bg-light text-center p-5">Tidak ada gambar</div>
            @endif
        </div>
        <div class="col-md-6 p-4 rounded shadow-sm bg-white">
            <h2 class="mb-3">{{ $product->name }}</h2>

            @if($product->seller && $product->seller->is_suspended)
                <div class="alert alert-warning mt-2">
                    <strong>⚠️ Akun ini dinonaktifkan. Pesanan tidak dapat diproses</strong>
                </div>
            @endif

            <p class="mb-2 text-orange fw-semibold fs-4">
                Harga: Rp{{ number_format($product->price, 0, ',', '.') }}
            </p>

            <h6 class="text-muted mt-4">Deskripsi Produk</h6>
            <p class="mb-2">{{ $product->description }}</p>

            <p class="mb-3">Stok:
                <span class="px-3 py-1 bg-light border border-success rounded-pill text-success small">
                    {{ $product->stock }}
                </span>
            </p>

            @if($product->seller)
                <p class="mb-3"><i class="bi bi-person"></i> Penjual:
                    <strong>{{ $product->seller->name ?? 'Tidak diketahui' }}</strong>
                </p>
            @endif

            <form method="POST" action="{{ route('guest.cart.add') }}">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <div class="form-group mb-3">
                    <label for="quantity">Jumlah</label>
                    <input type="number" name="quantity" id="quantity" value="1" min="1" max="{{ $product->stock }}" class="form-control w-50">
                </div>
                <button type="submit" class="btn btn-danger">Tambah ke Keranjang</button>
            </form>
        </div>
    </div>
</div>
@endsection
