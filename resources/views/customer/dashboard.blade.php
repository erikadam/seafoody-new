
@extends('layouts.customer')

@section('content')
<div class="container mt-4">
  <h3>Dashboard Penjual</h3>

  <!-- Profil Toko -->
  <div class="card mb-4">
    <div class="card-header">Profil Toko</div>
    <div class="card-body">
      <p><strong>Nama:</strong> {{ Auth::user()->name }}</p>
      <p><strong>Deskripsi:</strong> {{ Auth::user()->store_description ?? '-' }}</p>
      <p><strong>Alamat:</strong> {{ Auth::user()->store_address ?? '-' }}</p>
      <p><strong>No. HP:</strong> {{ Auth::user()->phone ?? '-' }}</p>
      <a href="{{ route('customer.profile.edit') }}" class="btn btn-sm btn-outline-primary">Edit Profil</a>
    </div>
  </div>

  <!-- Pesanan Masuk -->
  <div class="card">
    <div class="card-header">Pesanan Masuk</div>
    <div class="card-body p-0">
      @if($orders->count())
        <table class="table table-bordered mb-0">
          <thead>
            <tr>
              <th>Produk</th>
              <th>Pembeli</th>
              <th>HP</th>
              <th>Status</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            @foreach($orders as $order)
              <tr>
                <td>{{ $order->product->name ?? 'Produk Tidak Tersedia' }}</td>
                <td>{{ $order->buyer_name }}</td>
                <td>{{ $order->buyer_phone }}</td>
                <td><span class="badge bg-secondary">{{ $order->status }}</span></td>
                <td>
                  @if($order->status === 'in_process_by_customer')
                    <form action="{{ route('customer.order.prepare', $order->id) }}" method="POST">
                      @csrf @method('PATCH')
                      <button class="btn btn-sm btn-warning">Siapkan</button>
                    </form>
                  @elseif($order->status === 'shipped_by_customer')
                    <span class="badge bg-success">Dikirim</span>
                  @elseif($order->status === 'completed')
                    <span class="badge bg-info">Selesai</span>
                  @else
                    <span class="badge bg-light">{{ ucfirst(str_replace('_', ' ', $order->status)) }}</span>
                  @endif
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      @else
        <div class="p-3">Belum ada pesanan masuk.</div>
      @endif
    </div>
  </div>
</div>
@endsection
