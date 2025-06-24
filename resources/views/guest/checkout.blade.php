
@extends('layouts.guest')

@section('content')

<style>
.text-orange {
    color: #f75f36;
}
</style>

<div class="container py-5 mt-5">
    <h1 class="mb-4">Checkout</h1>


    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @elseif (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form action="{{ route('guest.checkout.process') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <!-- Left: Info Pemesan -->
            <div class="col-md-6 mb-4">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-light">
                        <strong>Informasi Pemesan</strong>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
    <label for="name" class="form-label">Nama Lengkap</label>
    <input type="text" name="buyer_name" readonly class="form-control-plaintext" id="name"
           value="{{ old('name', auth()->check() ? auth()->user()->name : '') }}"
           class="form-control rounded" required>
</div>
<div class="mb-3">
    <label for="email" class="form-label">Alamat Email</label>
    <input type="email" name="buyer_email" readonly class="form-control-plaintext" id="email"
           value="{{ old('email', auth()->check() ? auth()->user()->email : '') }}"
           class="form-control rounded" required>
</div>

                        <div class="mb-3">
                            <label for="phone" class="form-label">Nomor WhatsApp</label>
                            <input type="text" name="buyer_phone" id="phone"
                                   value="{{ old('phone') }}"
                                   class="form-control rounded" placeholder="08xxxxxxxxxx" required>
                        </div>
                        <div class="mb-3">
                            <label for="address" class="form-label">Alamat Lengkap</label>
                            <textarea name="buyer_address" id="address"
                                      class="form-control rounded" rows="3"
                                      required>{{ old('name', auth()->user()->store_address) }}
                                    </textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Metode Pembayaran</label><br>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio"
                                       name="payment_method" id="cash" value="cash" checked>
                                <label class="form-check-label" for="cash">Bayar di Tempat (COD)</label>
</div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio"
                                       name="payment_method" id="transfer" value="transfer">
                                <label class="form-check-label" for="transfer">Transfer Bank</label>
                            </div>
                        </div>
                        <div class="mb-3 d-none" id="proof-container">
                            <label for="payment_proof" class="form-label">Upload Bukti Transfer</label>
                            <input type="file" name="payment_proof" id="payment_proof" class="form-control rounded">

                        </div>
                    </div>
                </div>
            </div>

            <!-- Right: Ringkasan Produk -->
            <div class="col-md-6 mb-4">
                @foreach ($groupedCart as $sellerName => $items)
                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-header bg-light">
                            <strong>Toko: {{ $sellerName }}</strong>
                        </div>
                        <div class="card-body p-0">
                            <ul class="list-group list-group-flush">
                                @foreach ($items as $item)

                                    <li class="list-group-item d-flex justify-content-between align-items-start">
                                        <div class="me-auto">
                                            <div class="fw-bold">{{ $item['product']['name'] }}</div>
                                            Jumlah: {{ $item['quantity'] }}
                                        </div>
                                        <span class="text-orange">
                                            Rp{{ number_format($item['product']['price'] * $item['quantity'], 0, ',', '.') }}
                                        </span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endforeach

                <div class="card shadow-sm border-0">
                    <div class="card-body text-end">
                        <h5>Total Belanja:
                            <strong class="text-orange">@php $grandTotal = 0; @endphp
@foreach ($groupedCart as $items)
  @foreach ($items as $item)
    @php $grandTotal += $item['product']['price'] * $item['quantity']; @endphp
  @endforeach
@endforeach
<strong class="text-orange">Rp{{ number_format($grandTotal, 0, ',', '.') }}</strong></strong>
                        </h5>
                        <button type="submit" class="btn btn-lg btn-success mt-3">Konfirmasi Pesanan</button>
                    </div>
                </div>
            </div>
        </div>
    </form>


</div>


<script>
document.addEventListener('DOMContentLoaded', function () {
  const radios = document.querySelectorAll('input[name="payment_method"]');
  const proofContainer = document.getElementById('proof-container');

  function toggleProofField() {
    const selected = document.querySelector('input[name="payment_method"]:checked');
    if (!selected) return;
    proofContainer.classList.toggle('d-none', selected.value !== 'transfer');
  }

  radios.forEach(radio => radio.addEventListener('change', toggleProofField));
  toggleProofField(); // Initial run
});
</script>
<script>
    setTimeout(() => {
        const alert = document.querySelector('.fixed.top-5');
        if (alert) alert.remove();
    }, 4000); // 4 detik
</script>


@endsection
