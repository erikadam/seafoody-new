@extends('layouts.guest')

@section('content')
<div class="container mt-5 mb-5">
    <h2 class="mb-4 text-center">Detail Pesanan</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @elseif(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card">
        <div class="card-header bg-light">
            <strong>Toko: {{ $order->product->user->name ?? 'Toko Tidak Diketahui' }}</strong>
        </div>
        <div class="card-body">
            <p><strong>Nama Pembeli:</strong> {{ $order->buyer_name }}</p>
            <p><strong>Alamat:</strong> {{ $order->buyer_address }}</p>
            <p><strong>Nomor Telepon:</strong> {{ $order->buyer_phone }}</p>
            <hr>
            <h5>Produk Dipesan</h5>
            <ul class="list-group mb-3">
                <li class="list-group-item">
                    <div class="d-flex justify-content-between">
                        <span>{{ $order->product->name }} (x1)</span>
                        <span>Rp{{ number_format($order->product->price) }}</span>
                    </div>
                </li>
            </ul>
            <p><strong>Total:</strong> Rp{{ number_format($order->product->price) }}</p>
            <p><strong>Status Pesanan:</strong> {{ strtoupper(str_replace('_', ' ', $order->status)) }}</p>

            <div class="mt-4">
                @if(in_array($order->status, ['in_process_by_customer', 'waiting_admin_confirmation']))
                    <form method="POST" action="{{ route('guest.order.cancel', $order->token) }}">
                        @csrf
                        @method('PATCH')
                        <button class="btn btn-danger">Batalkan Pesanan</button>
                    </form>
                @elseif($order->status === 'shipped_by_customer')
                    <form method="POST" action="{{ route('guest.order.confirm', $order->token) }}">
                        @csrf
                        @method('PATCH')
                        <button class="btn btn-success">Konfirmasi Pesanan Diterima</button>
                    </form>
                @elseif(in_array($order->status, ['received_by_buyer', 'completed']))
                    <a href="{{ route('guest.order.pdf.final', $order->token) }}" class="btn btn-primary">
                        Unduh Nota PDF
                    </a>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
