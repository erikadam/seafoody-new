@extends('layouts.guest')

@section('content')
<div class="container mt-5 py-4">
    <div class="col-md-6 offset-md-3">

        <div class="card shadow-sm mb-4">
            <div class="card-body text-center">
                <img src="{{ asset('uploads/product/' . $item->product->image) }}"
                     alt="Foto Produk"
                     class="img-fluid rounded mb-3"
                     style="max-height: 200px; object-fit: cover;">
                <h5 class="mb-2">{{ $item->product->name }}</h5>
                <p class="mb-1"><strong>To:</strong> {{ $item->product->user->store_name ?? 'Toko Tidak Diketahui' }}</p>
                <p class="mb-1">Jumlah: {{ $item->quantity }}</p>
                <p class="mb-1">Harga : Rp{{ number_format($item->price, 0, ',', '.') }}</p>
                <p class="mb-1">Metode Pembayaran: {{ ucfirst($item->order->payment_method) }}</p>
                <p class="mb-0">Tanggal Order: {{ \Carbon\Carbon::parse($item->order->created_at)->format('d M Y H:i') }}</p>
            </div>
        </div>

        <div class="card shadow-sm">
            <div class="card-header bg-warning text-dark">
                <strong>Formulir Pengajuan Refund</strong>
            </div>
            <div class="card-body">
                <form action="{{ route('refund.submit', $item->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label for="refund_reason" class="form-label">Alasan Refund</label>
                        <textarea name="refund_reason" class="form-control" rows="3" required>{{ old('refund_reason') }}</textarea>
                    </div>

                    @if($item->order->payment_method === 'transfer')
                        <div class="mb-3">
                            <label for="refund_account_number" class="form-label">Nomor Rekening Refund</label>
                            <input type="text" name="refund_account_number" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="refund_bank_name" class="form-label">Nama Bank</label>
                            <input type="text" name="refund_bank_name" class="form-control" required>
                        </div>

                    @endif

                    <div class="d-flex justify-content-between">
                        <button type="submit" class="btn btn-danger">Ajukan Refund</button>
                        <a href="{{ url()->previous() }}" class="btn btn-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>
