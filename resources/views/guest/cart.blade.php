
@extends('layouts.guest')

@section('content')
<div class="container mt-5 py-5">
    <h1 class="mb-4">Keranjang Belanja</h1>

    @if($cartItems->isEmpty())
        <div class="alert alert-info">Keranjang belanja kosong.</div>
    @else
        @php $grandTotal = 0; @endphp
        @foreach ($groupedCart as $name => $items)
            <div class="card mb-5 border border-dark-subtle shadow-sm">
                <div class="card-header bg-light">
                    <strong>Toko: {{ $name }}</strong>
                </div>
                <div class="card-body p-0">
                    <table class="table table-bordered align-middle mb-0 cart-table">
                        <thead class="table-light">
                            <tr>
                                <th>Produk</th>
                                <th>Harga</th>
                                <th>Jumlah</th>
                                <th>Subtotal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $subtotal = 0; @endphp
                            @foreach ($items as $item)
                                @php
                                    $product = $item->product;
                                    $quantity = $item->quantity;
                                    $subtotal += $product->price * $quantity;
                                @endphp
                                <tr data-price="{{ $product->price }}">
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="{{ asset('uploads/product/' . $product->image) }}"
                                                 alt="{{ $product->name }}"
                                                 class="me-2 rounded"
                                                 style="width: 80px; height: 60px; object-fit: cover;">
                                        </div>
                                    </td>
                                    <td>{{ $product->name }}</td>
                                    <td>Rp{{ number_format($product->price, 0, ',', '.') }}</td>
                                    <td>
                                        <form action="{{ route('guest.cart.update') }}" method="POST" class="d-flex update-form">
                                            @csrf
                                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                                            <input type="number" name="quantity" value="{{ $quantity }}"
                                                   min="1" max="{{ $product->stock }}"
                                                   class="form-control form-control-sm w-50 me-2 quantity-input">
                                            <button type="submit" class="btn btn-sm btn-primary">Perbarui</button>
                                        </form>
                                    </td>
                                    <td class="subtotal-cell">Rp{{ number_format($product->price * $quantity, 0, ',', '.') }}</td>
                                    <td>
                                        <form action="{{ route('guest.cart.remove') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                                            <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3" class="text-end"><strong>Total Toko:</strong></td>
                                <td colspan="2"><strong class="total-shop">Rp{{ number_format($subtotal, 0, ',', '.') }}</strong></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            @php $grandTotal += $subtotal; @endphp
        @endforeach

        <div class="card border border-dark-subtle shadow-sm">
            <div class="card-body text-end">
                <h5 class="mb-3">Total Seluruh Toko: <span id="grand-total">Rp{{ number_format($grandTotal, 0, ',', '.') }}</span></h5>
                <a href="{{ route('guest.checkout.form') }}" class="btn btn-success btn-lg">Lanjut ke Checkout</a>
            </div>
        </div>
    @endif
</div>

<script>
document.querySelectorAll('.quantity-input').forEach(function(input) {
    input.addEventListener('input', function () {
        let tr = input.closest('tr');
        let price = parseInt(tr.getAttribute('data-price'));
        let qty = parseInt(input.value);
        if (qty < 1) qty = 1;

        // Update subtotal for this row
        let subtotal = price * qty;
        tr.querySelector('.subtotal-cell').textContent = 'Rp' + subtotal.toLocaleString('id-ID');

        // Update grand total
        let grand = 0;
        document.querySelectorAll('.subtotal-cell').forEach(function(cell) {
            let val = cell.textContent.replace(/[Rp.,]/g, '');
            grand += parseInt(val) || 0;
        });
        document.getElementById('grand-total').textContent = 'Rp' + grand.toLocaleString('id-ID');
    });
});
</script>
@endsection
