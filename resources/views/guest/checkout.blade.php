
@extends('layouts.guest')

@section('content')
<div class="container mt-5 mb-5">
    <h2 class="mb-4 text-center">Formulir Checkout</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Oops!</strong> Ada masalah dengan input Anda.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('guest.checkout.submit') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-md-6">
                <h5>Informasi Pembeli</h5>
                <div class="form-group">
                    <label>Nama Lengkap</label>
                    <input type="text" name="buyer_name" class="form-control" required value="{{ old('buyer_name') }}">
                </div>
                <div class="form-group">
                    <label>Nomor Telepon</label>
                    <input type="text" name="buyer_phone" class="form-control" required value="{{ old('buyer_phone') }}">
                </div>
                <div class="form-group">
                    <label>Alamat Pengiriman</label>
                    <textarea name="buyer_address" class="form-control" required>{{ old('buyer_address') }}</textarea>
                </div>
                <div class="form-group">
                    <label>Metode Pembayaran</label>
                    <select name="payment_method" class="form-control" required>
                        <option value="cash">Bayar di Tempat</option>
                        <option value="transfer">Transfer Bank</option>
                    </select>
                </div>
                <div class="form-group" id="transfer-proof-group" style="display: none;">
                    <label>Bukti Transfer (jika transfer)</label>
                    <input type="file" name="transfer_proof" class="form-control-file">
                </div>
            </div>

            <div class="col-md-6">
                <h5>Ringkasan Pesanan</h5>
                @php
                    $cart = session('cart', []);
                    $groupedProducts = [];
                    foreach ($products as $product) {
                        $groupedProducts[$product->user_id][] = $product;
                    }
                @endphp

                @foreach($groupedProducts as $sellerId => $sellerProducts)
                    <div class="card mb-3">
                        <div class="card-header bg-light">
                            <strong>Toko: {{ $sellerProducts[0]->user->name ?? 'Toko #' . $sellerId }}</strong>
                        </div>
                        <div class="card-body p-0">
                            <table class="table mb-0">
                                <thead>
                                    <tr>
                                        <th>Produk</th>
                                        <th>Jumlah</th>
                                        <th>Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $subtotal = 0; @endphp
                                    @foreach($sellerProducts as $product)
                                        @php
                                            $quantity = $cart[$product->id];
                                            $sub = $product->price * $quantity;
                                            $subtotal += $sub;
                                        @endphp
                                        <tr>
                                            <td>{{ $product->name }}</td>
                                            <td>{{ $quantity }}</td>
                                            <td>Rp{{ number_format($sub) }}</td>
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <td colspan="2" class="text-right"><strong>Subtotal</strong></td>
                                        <td><strong>Rp{{ number_format($subtotal) }}</strong></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="text-center mt-4">
            <button type="submit" class="btn btn-success">Kirim Pesanan</button>
        </div>

    </form>
</div>

<script>
    const paymentSelect = document.querySelector('[name="payment_method"]');
    const transferGroup = document.getElementById('transfer-proof-group');

    paymentSelect.addEventListener('change', function () {
        transferGroup.style.display = this.value === 'transfer' ? 'block' : 'none';
    });
</script>
@endsection
