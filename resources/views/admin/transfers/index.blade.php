@extends('layouts.admin')

@section('content')
<div class="container">
    <h2 class="mb-4">Validasi Transfer Pembayaran</h2>

    @if (session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    @if ($order_items->isEmpty())
        <div class="alert alert-info">Tidak ada transfer yang menunggu konfirmasi.</div>
    @else
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Produk</th>
                <th>Pembeli</th>
                <th>Status</th>
                <th>Bukti Transfer</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
        @foreach ($order_items as $item)
        <tr>
            <td>{{ $item->product->name }}</td>
            <td>{{ $item->order->user->name }}</td>
            <td>
                <span class="badge
                    @if($item->status === 'received_by_buyer') bg-success
                    @elseif($item->status === 'delivering') bg-info
                    @elseif($item->status === 'accepted_by_admin') bg-primary
                    @else bg-warning @endif">
                    {{ ucfirst(str_replace('_', ' ', $item->status)) }}
                </span>
            </td>
            <td>
                @if($item->order->payment_proof)
                    <a href="{{ asset('storage/' . $item->order->payment_proof) }}" target="_blank" class="badge bg-primary">Lihat Bukti Pembeli</a>
                @else
                    <span class="text-muted">Belum upload</span>
                @endif
                @if ($item->status === 'received_by_buyer' && $item->admin_delivery_proof)
                    <br>
                    <a href="{{ asset('storage/' . $item->admin_delivery_proof) }}" target="_blank" class="badge bg-success mt-2">Lihat Bukti Admin</a>
                @endif
            </td>
            <td>
                {{-- Approve/reject --}}
                @if ($item->status === 'waiting_admin_confirmation')
                    <form action="{{ route('admin.transfers.approve', $item->id) }}" method="POST" class="mb-2 d-inline">
                        @csrf
                        <button type="submit" class="btn btn-success btn-sm">Approve Transfer</button>
                    </form>
                    <form action="{{ route('admin.transfers.reject', $item->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Tolak transfer ini?')">Tolak</button>
                    </form>
                @endif

                {{-- Antar ke pembeli --}}
                @if ($item->status === 'shipped_by_admin')
                    <form action="{{ route('admin.order.startDelivery', $item->id) }}" method="POST" class="mt-2 d-inline">
                        @csrf
                        <button type="submit" class="btn btn-info btn-sm">Antar ke Pembeli</button>
                    </form>
                @endif
               {{-- Status delivering --}}
                @if ($item->status === 'delivering')
                    <form action="{{ route('admin.order.completeDelivery', $item->id) }}" method="POST" enctype="multipart/form-data" style="display:inline;">
                        @csrf
                        <input type="file" name="admin_delivery_proof" class="form-control mb-2" required>
                        <button type="submit" class="btn btn-success btn-sm">Serahkan ke Pembeli</button>
                    </form>
                @endif

            </td>
        </tr>
        @endforeach
        </tbody>
    </table>
    @endif
</div>
@endsection
