@extends('layouts.guest')

@section('content')
<div class="container py-4">
    <h2 class="text-2xl font-bold mb-6">Katalog Produk</h2>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if($products->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($products as $product)
                <div class="bg-white shadow rounded-lg overflow-hidden flex flex-col">
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="h-48 object-cover w-full">
                    <div class="p-4 flex-1 flex flex-col justify-between">
                        <div>
                            <h3 class="font-semibold text-lg mb-1">{{ $product->name }}</h3>
                            @if($product->seller->is_suspended)
            <div class="alert alert-warning mt-2">
                  <strong>⚠️ Akun ini dinonaktifkan. Pesanan tidak bisa diproses</strong>
             </div>
            @endif
                            <p class="text-gray-700 mb-2">Rp{{ number_format($product->price, 0, ',', '.') }}</p>
                            <p class="text-sm text-gray-500">Stok: {{ $product->stock }}</p>
                        </div>

                        @if($product->stock > 0)
                            <form action="{{ route('guest.cart.add') }}" method="POST" class="mt-4">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <input type="hidden" name="quantity" value="1">
                                <button class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 rounded text-sm">Tambah ke Keranjang</button>
                            </form>
                        @else
                            <p class="mt-4 text-red-500 text-sm font-semibold">Stok Habis</p>
                        @endif
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-md p-4">
                    <h3 class="text-lg font-semibold mb-2">{{ $product->name }}</h3>
                    <p class="text-sm text-gray-700 mb-2">Rp{{ number_format($product->price) }}</p>
                    @if (auth()->check() && $product->user_id === $userId)
                        <span class="text-sm text-red-500">Produk milik Anda</span>
                    @else
                        <a href="{{ route('cart.add', $product->id) }}" class="btn btn-primary">Beli</a>
                    @endif
                </div>
            @endforeach
        </div>
    @else
        <p class="text-gray-600">Tidak ada produk tersedia saat ini.</p>
    @endif
</div>
@endsection
