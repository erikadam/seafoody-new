@extends('layouts.guest')

@section('content')
<div class="container py-5 mt-4">
  @if(session('order'))
    <div class="row justify-content-center">
      <div class="col-md-11">
        <div class="card shadow rounded-4">
          <div class="card-header bg-primary text-white rounded-top-4">
            <h4 class="mb-0">📦 Detail Pesanan Anda</h4>
          </div>
          <div class="card-body">
            <div class="row mb-3">
              <div class="col-md-6">
                <p><strong>Nama:</strong> {{ session('order')->buyer_name }}</p>
                <p><strong>Telepon:</strong> {{ session('order')->buyer_phone }}</p>
                <p><strong>Alamat:</strong> {{ session('order')->buyer_address }}</p>
              </div>
              <div class="col-md-6">
                <p><strong>Metode Pembayaran:</strong>
                  <span class="badge bg-success text-uppercase">{{ session('order')->payment_method }}</span></p>
                <p><strong>Token:</strong>
                  <span class="text-primary fw-semibold">{{ session('order')->token }}</span></p>
              </div>
            </div>

            <hr>
            <h5 class="mb-3">🛍️ Daftar Produk per Toko</h5>

            @php
              $items = collect(session('order')->orderItems ?? []);
              $grouped = $items->groupBy(fn($item) => $item->seller->name ?? 'Toko Tidak Dikenal');
              $total = 0;
              $itemCount = 0;
              $doneCount = 0;
            @endphp

            @foreach($grouped as $seller => $items)
              <div class="mb-4 border p-3 rounded">
                <h6 class="fw-bold text-secondary mb-3">Toko: {{ $seller }}</h6>
                <table class="table table-bordered">
                  <thead class="table-light">
                    <tr>
                      <th>Produk</th>
                      <th>Jumlah</th>
                      <th>Harga Satuan</th>
                      <th>Subtotal</th>
                      <th>Status</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($items as $item)
                      @php
                        $subtotal = $item->price * $item->quantity;
                        $total += $subtotal;
                        $itemCount++;
                        if ($item->status === 'done') $doneCount++;

                        $statusText = match($item->status) {
                          'waiting_admin_confirmation' => 'Bukti sedang ditinjau. Hubungi Admin di Telp. 08927823628',
                          'waiting_seller_confirmation' => 'Menunggu Konfirmasi Penjual',
                          'in_process_by_customer' => 'Pesanan dikirim. Harap siapkan Rp ' . number_format($subtotal, 0, ',', '.'),
                          'shipping_by_customer' => 'Sedang dikirim ke alamat Anda',
                          'done' => 'Pesanan Selesai',
                          'rejected_by_admin' => 'Bukti Transfer Ditolak Admin',
                          'cancelled' => 'Pesanan Dibatalkan',
                          default => 'Status Tidak Diketahui'
                        };
                      @endphp
                      <tr>
                        <td>{{ $item->product->name ?? '-' }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                        <td>Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
                        <td>{{ $statusText }}</td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            @endforeach

            <div class="text-end fw-bold mt-4">
              Total Semua: <span class="text-success">Rp {{ number_format($total, 0, ',', '.') }}</span>
            </div>

            <div class="text-end mt-3">
              @if($itemCount > 0 && $doneCount === $itemCount)
                <a href="{{ route('guest.download.pdf', session('order')->token) }}" class="btn btn-outline-primary">
                  📄 Unduh Nota PDF
                </a>
              @else
                <small class="text-muted">🔒 PDF hanya muncul jika semua produk telah selesai.</small>
              @endif
            </div>
          </div>
        </div>

        <div class="alert alert-info mt-4 shadow-sm rounded-4">
          Terima kasih telah berbelanja. Pantau status tiap pesanan Anda dari masing-masing toko. 📦
        </div>
      </div>
    </div>
  @else
    <script>window.location.href = "/";</script>
  @endif
</div>
@endsection
