@extends('layouts.guest')

@section('content')
<div class="container py-5 mt-4">
  <h4 class="mb-4 fw-bold text-primary">📦 Riwayat Pesanan Anda</h4>


@php
function statusLabel($status) {
    return match($status) {
        'waiting_admin_confirmation' => 'Menunggu Konfirmasi Admin',
        'accepted_by_admin' => 'Diterima Admin',
        'rejected_by_admin' => 'Ditolak Admin',
        'in_process_by_customer' => 'Diproses Penjual',
        'shipped_by_customer' => 'Dikirim Penjual',
        'received_by_buyer' => 'Diterima Pembeli',
        'return_requested' => 'Refund Diajukan',
        'return_approved' => 'Refund Diterima',
        'refunded' => 'Refund Selesai',
        'cancelled_by_buyer' => 'Dibatalkan',
        default => ucfirst(str_replace('_', ' ', $status)),
    };
}
@endphp


  @forelse($orders as $order)
    @php
      $groupedItems = optional($order->orderItems)->groupBy(fn($item) => $item->product->seller->name ?? 'Toko Tidak Diketahui');
    @endphp

    @foreach(($groupedItems ?? collect()) as $sellerName => $items)
      <div class="card mb-4 shadow rounded-4">
        <div class="card-header bg-primary text-white rounded-top-4">
          <div class="d-flex justify-content-between">
            <span><strong>Toko:</strong> {{ $sellerName }}</span>
            <span><strong>Token:</strong> {{ $order->token }}</span>
          </div>
        </div>
        <div class="card-body">
          <table class="table table-sm table-bordered">
            <thead class="table-light">
              <tr>
                <th>Produk</th>
                <th>Harga</th>
                <th>Status</th>
                <th>Aksi</th>
              </tr>
            </thead>


    <tbody>
      @foreach($items as $item)
        <tr>
          <td>{{ $item->product->name }}</td>
          <td>Rp{{ number_format($item->price, 0, ',', '.') }}</td>
          <td>
            <span class="badge bg-secondary">{{ statusLabel($item->status) }}</span>
          </td>
          <td>
            @if($item->status === 'shipped_by_customer')
              <form method="POST" action="{{ route('order.received', $item->id) }}">
                @csrf
                <button type="submit" class="btn btn-sm btn-success">Diterima</button>
              </form>
            @elseif($item->status === 'received_by_buyer')
              <form method="GET" action="{{ route('refund.form', $item->id) }}">
                <button type="submit" class="btn btn-sm btn-warning">Ajukan Refund</button>
              </form>
            @elseif($item->status === 'return_approved' && $item->refund_proof)
              <a href="{{ asset('storage/' . $item->refund_proof) }}" target="_blank" class="btn btn-sm btn-info">Lihat Bukti Refund</a>
            @elseif($item->status === 'cancelled_by_buyer')
              <span class="text-danger">Dibatalkan</span>
            @elseif($item->status === 'refunded')
              <span class="text-success">Refund Selesai</span>
            @else
              <span class="text-muted">-</span>
            @endif
          </td>
          <td>
            Rp{{ number_format($item->price, 0, ',', '.') }}
          </td>
        </tr>
      @endforeach
    </tbody>


          </table>
        </div>
      </div>
    @endforeach
    <div class="card mb-4 shadow rounded-4">
      <div class="card-header bg-primary text-white rounded-top-4">
        <div class="d-flex justify-content-between">
          <span><strong>Token:</strong> {{ $order->token }}</span>
          <span><strong>Status:</strong>
            <span class="badge bg-light text-dark text-uppercase">{{ ucwords(str_replace('_', ' ', $order->status)) }}</span>
          </span>
        </div>
      </div>
      <div class="card-body">
        <div class="row mb-3">
          <div class="col-md-6">
            <p><strong>Nama:</strong> {{ $order->buyer_name }}</p>
            <p><strong>Telepon:</strong> {{ $order->buyer_phone }}</p>
            <p><strong>Alamat:</strong> {{ $order->buyer_address }}</p>
          </div>
          <div class="col-md-6">
            <p><strong>Metode Pembayaran:</strong>
              <span class="badge bg-success text-uppercase">{{ $order->payment_method }}</span></p>
            <p><strong>Total:</strong> Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
          </div>
        </div>

        @php
          $grouped = $order->items->groupBy(fn($item) => $item->product->seller->name ?? 'Toko Tidak Dikenal');
        @endphp

        @foreach($grouped as $seller => $items)
          <div class="mb-4 border p-3 rounded-3 shadow-sm">
            <h6 class="fw-bold text-secondary mb-3">Toko: {{ $seller }}</h6>
            <table class="table table-sm table-bordered align-middle">
              <thead class="table-light">
                <tr>
                  <th>Produk</th>
                  <th>Jumlah</th>
                  <th>Harga</th>
                  <th>Status</th>
                  <th>Subtotal</th>
                </tr>
              </thead>


    <tbody>
      @foreach($items as $item)
        <tr>
          <td>{{ $item->product->name }}</td>
          <td>Rp{{ number_format($item->price, 0, ',', '.') }}</td>
          <td>
            <span class="badge bg-secondary">{{ statusLabel($item->status) }}</span>
          </td>
          <td>
            @if($item->status === 'shipped_by_customer')
              <form method="POST" action="{{ route('order.received', $item->id) }}">
                @csrf
                <button type="submit" class="btn btn-sm btn-success">Diterima</button>
              </form>
            @elseif($item->status === 'received_by_buyer')
              <form method="POST" action="{{ route('refund.request', $item->id) }}" enctype="multipart/form-data">
                @csrf
                <button type="submit" class="btn btn-sm btn-warning">Ajukan Refund</button>
              </form>
            @elseif($item->status === 'return_approved' && $item->refund_proof)
              <a href="{{ asset('storage/' . $item->refund_proof) }}" target="_blank" class="btn btn-sm btn-info">Lihat Bukti Refund</a>
            @elseif($item->status === 'cancelled_by_buyer')
              <span class="text-danger">Dibatalkan</span>
            @elseif($item->status === 'refunded')
              <span class="text-success">Refund Selesai</span>
            @else
              <span class="text-muted">-</span>
            @endif
          </td>
          <td>
            Rp{{ number_format($item->price, 0, ',', '.') }}
          </td>
        </tr>
      @endforeach
    </tbody>
            </table>
          </div>
        @if($item->status === 'shipped_by_customer')
          <form method="POST" action="{{ route('buyer.order.receive', $item->id) }}" class="d-inline">
            @csrf
            <button type="submit" class="btn btn-sm btn-success mt-1"
              onclick="return confirm('Konfirmasi bahwa pesanan sudah diterima?')">Sudah Diterima</button>
          </form>
        @endif
    @endforeach
      </div>
      @if(in_array($item->status, ['received_by_buyer', 'cancelled_by_buyer', 'refunded']))
  <a href="{{ route('buyer.order.print', $item->id) }}" class="btn btn-sm btn-outline-secondary mt-1">
    Unduh Nota Bukti
  </a>
@endif

    </div>
  @empty
    <div class="alert alert-info rounded-3">Anda belum memiliki pesanan.</div>
  @endforelse
</div>
@endsection
