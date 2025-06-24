@extends('layouts.customer')

@section('content')
<div class="container mt-4">
    <h4 class="mb-4">Daftar Pesanan Masuk ke Toko Anda</h4>

    @if (session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @elseif (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <table class="table table-bordered table-striped align-middle text-sm mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Produk</th>
                        <th>Jumlah</th>
                        <th>Pembeli</th>
                        <th>Status</th>
                        <th>Metode Bayar</th>
                        <th class="text-center">Aksi</th>
                        <th>Bukti Penyerahan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($order_items as $item)
                        <tr>
                            <td>{{ $item->product->name }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>{{ $item->order->user->name }}</td>
                            <td>
                                <span class="badge
                                    @if($item->status === 'received_by_buyer') bg-success
                                    @elseif($item->status === 'in_process_by_customer') bg-warning
                                    @elseif($item->status === 'accepted_by_admin') bg-primary
                                    @elseif($item->status === 'shipped_by_admin') bg-info
                                    @elseif($item->status === 'delivering') bg-info
                                    @else bg-secondary @endif">
                                    {{ ucfirst(str_replace('_', ' ', $item->status)) }}
                                </span>
                            </td>
                            <td><strong>{{ strtoupper($item->order->payment_method) }}</strong></td>
                            <td class="text-center">
                                {{-- Tombol aksi penjual --}}
                                @if ($item->order->payment_method === 'transfer')
                                    {{-- Siapkan --}}
                                    @if ($item->status === 'accepted_by_admin')
                                        <form action="{{ route('customer.order.prepare', $item->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-warning btn-sm">Siapkan</button>
                                        </form>
                                    @endif
                                    {{-- Serahkan ke Admin --}}
                                    @if ($item->status === 'in_process_by_customer')
                                        <form action="{{ route('customer.order.handover', $item->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-info btn-sm">Serahkan ke Admin</button>
                                        </form>
                                    @endif
                                @endif
@if ($item->status === 'in_process_by_customer')
    @if ($item->order->payment_method === 'cash' || $item->order->payment_method === 'cod')
        <form action="{{ route('customer.order.handoverBuyerCOD', $item->id) }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-success btn-sm">Serahkan ke Pembeli</button>
        </form>
    @endif

@endif
{{-- Tombol Setujui Refund --}}
@if ($item->status === 'return_requested')
    <form action="{{ route('refund.approve', $item->id) }}" method="POST" class="mt-2">
        @csrf
        <button type="submit" class="btn btn-danger btn-sm">
            @if ($item->order->payment_method === 'transfer')
                Setujui Refund (Transfer)
            @else
                Selesaikan Refund COD
            @endif
        </button>
    </form>
@endif
                                {{-- Status info --}}
                                @if ($item->status === 'shipped_by_customer')
                                    <span class="text-muted">Menunggu Konfirmasi Pembeli</span>
                                @elseif ($item->status === 'shipped_by_admin')
                                    <span class="text-info">Menunggu pengantaran admin</span>
                                @elseif ($item->status === 'delivering')
                                    <span class="text-info">Dalam Pengantaran Admin</span>
                                @elseif ($item->status === 'received_by_buyer')
                                    <span class="text-success">Pesanan Selesai</span>
                                @endif
                            </td>
                            <td>
                                @if ($item->admin_delivery_proof)
                                    <a href="{{ asset('storage/' . $item->admin_delivery_proof) }}" target="_blank" class="badge bg-success">Lihat Bukti</a>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted">Belum ada pesanan</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
