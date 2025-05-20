@extends('layouts.guest')

@section('content')
<div class="page-heading header-text">
  <div class="container">
    <h1>Checkout</h1>
  </div>
</div>

<div class="container py-5">
  <div class="row">
    {{-- Ringkasan Produk --}}
    <div class="col-lg-6">
      <h4 class="mb-3">Ringkasan Pesanan</h4>

      @php $grandTotal = 0; @endphp

      @foreach ($groupedCart as $sellerName => $items)
        <div class="mb-4 border rounded p-3">
          <h6 class="mb-2">Toko: <strong>{{ $sellerName }}</strong></h6>
          <ul class="list-unstyled">
            @foreach ($items as $item)
              @php
                $subtotal = $item->product->price * $item->quantity;
                $grandTotal += $subtotal;
              @endphp
              <li class="d-flex align-items-center justify-content-between border-bottom py-2">
                <div class="d-flex align-items-center">
                  <img src="{{ asset('uploads/product/' . $item->product->image) }}" alt="{{ $item->product->name }}"
                    class="rounded" style="width: 60px; height: 60px; object-fit: cover; margin-right: 15px;">
                  <div>
                    <div class="fw-bold">{{ $item->product->name }}</div>
                    <small class="text-muted">Qty: {{ $item->quantity }}</small>
                  </div>
                </div>
                <div class="text-end fw-semibold">Rp{{ number_format($subtotal, 0, ',', '.') }}</div>
              </li>
            @endforeach
          </ul>
        </div>
      @endforeach

      <div class="text-end mt-4">
        <h5>Total: <span class="text-primary">Rp{{ number_format($grandTotal, 0, ',', '.') }}</span></h5>
      </div>
    </div>

    {{-- Form Pembeli --}}
    <div class="col-lg-6">
      <h4 class="mb-3">Informasi Pemesan</h4>
      <form action="{{ route('guest.checkout.process') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-group mb-3">
          <label>Nama Lengkap</label>
          <input type="text" name="buyer_name" class="form-control" required>
        </div>

        <div class="form-group mb-3">
          <label>Nomor WhatsApp</label>
          <input type="text" name="buyer_phone" class="form-control" required>
        </div>

        <div class="form-group mb-3">
          <label>Alamat Lengkap</label>
          <textarea name="buyer_address" rows="3" class="form-control" placeholder="RT/RW, Kelurahan, Kecamatan, Kabupaten" required></textarea>
        </div>

        <div class="form-group mb-3">
          <label>Metode Pembayaran</label><br>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="payment_method" value="cash" checked>
            <label class="form-check-label">COD</label>
          </div>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="payment_method" value="transfer">
            <label class="form-check-label">Transfer Bank</label>
          </div>
        </div>

        <div id="transfer-proof-section" class="form-group mb-3 d-none">
          <div class="alert alert-warning small">
            💳 Silakan transfer ke <strong>A.n Rosa - 9999999 (Bank Mandiri)</strong>, lalu upload bukti transfer di bawah ini.
          </div>
          <label>Upload Bukti Transfer</label>
          <input type="file" name="transfer_proof" class="form-control">
        </div>

        <div class="text-end mt-4">
          <button type="submitOrder" class="btn btn-primary px-4">Proses Checkout</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    const radios = document.querySelectorAll('input[name="payment_method"]');
    const proofSection = document.getElementById('transfer-proof-section');

    function toggleProof() {
      if (document.querySelector('input[name="payment_method"]:checked').value === 'transfer') {
        proofSection.classList.remove('d-none');
      } else {
        proofSection.classList.add('d-none');
      }
    }

    radios.forEach(r => r.addEventListener('change', toggleProof));
    toggleProof(); // on page load
  });
</script>
@endsection
