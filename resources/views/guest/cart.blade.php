
@extends('layouts.guest')

@section('content')
<div class="container mt-5 pt-5">
    <h2 class="mb-4 text-center">Keranjang Belanja</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(count($cart) > 0 && count($products) > 0)
        <form action="{{ route('cart.update') }}" method="POST">
            @csrf
            @php
                $groupedProducts = [];
                foreach ($products as $product) {
                    $groupedProducts[$product->user_id][] = $product;
                }
            @endphp

            @foreach($groupedProducts as $sellerId => $sellerProducts)
                <div class="card mb-4">
                    <div class="card-header bg-light">
                        <strong>Toko: {{ $sellerProducts[0]->user->name ?? 'Toko #' . $sellerId }}</strong>
                    </div>
                    <div class="card-body p-0">
                        <table class="table mb-0">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Nama Produk</th>
                                    <th>Harga</th>
                                    <th>Jumlah</th>
                                    <th>Subtotal</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $subtotal = 0; @endphp
                                @foreach($sellerProducts as $product)
                                    @php
                                        $quantity = $cart[$product->id];
                                        $productSubtotal = $product->price * $quantity;
                                        $subtotal += $productSubtotal;
                                    @endphp
                                    <tr>
                                        <td>{{ $product->name }}</td>
                                        <td>Rp{{ number_format($product->price) }}</td>
                                        <td>
                                            <input type="number" name="quantities[{{ $product->id }}]" class="form-control form-control-sm" min="1" value="{{ $quantity }}">
                                        </td>
                                        <td>Rp{{ number_format($productSubtotal) }}</td>
                                        <td>
                                            <a href="{{ route('cart.remove', $product->id) }}" class="btn btn-danger btn-sm">Hapus</a>
                                        </td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td colspan="3" class="text-right"><strong>Subtotal Toko</strong></td>
                                    <td colspan="2"><strong>Rp{{ number_format($subtotal) }}</strong></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            @endforeach

            <div class="text-center mt-4">
                <a href="{{ route('cart.clear') }}" class="btn btn-warning mr-2">Kosongkan Keranjang</a>
                <a href="{{ route('guest.checkout') }}" class="btn btn-primary mr-2">Lanjut ke Checkout</a>
                <button type="submit" class="btn btn-success">Update Jumlah</button>
            </div>
        </form>
    @else
        <div class="alert alert-info text-center">Keranjang belanja kosong.</div>
    @endif
</div>
@endsection
