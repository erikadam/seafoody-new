
@extends('layouts.admin')

@section('content')
<div class="container">
    <h2 class="mb-4">Konfirmasi Transfer Pembayaran</h2>

    @if (session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    @if ($items->isEmpty())
        <div class="alert alert-info">Tidak ada transfer yang menunggu konfirmasi.</div>
    @else
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Produk</th>
                <th>Jumlah</th>
                <th>Bukti Transfer</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
        @foreach ($items as $item)
            <tr>
                <td>{{ $item->product->name ?? '-' }}</td>
                <td>{{ $item->quantity }}</td>
                <td>
                    @if ($item->admin_transfer_proof)
                        <img src="{{ asset('storage/' . $item->admin_transfer_proof) }}" alt="Bukti Transfer" width="100">
                    @else
                        <span class="text-muted">Belum ada</span>
                    @endif
                </td>
                <td>
                    <form action="{{ route('admin.transfers.approve', $item) }}" method="POST" enctype="multipart/form-data" style="margin-bottom: 8px;">
                        @csrf
                        <input type="file" name="admin_transfer_proof" required class="form-control mb-2">
                        <button type="submit" class="btn btn-sm btn-success">Setujui</button>
                    </form>
                    <form action="{{ route('admin.transfers.reject', $item) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-danger">Tolak</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    @endif
</div>
@endsection
