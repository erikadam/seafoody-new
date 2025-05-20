
@extends('layouts.customer')

@section('content')
<div class="container-fluid py-4">
    {{-- [GPT] Header dashboard --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h4 text-primary">Dashboard Toko Anda</h2>
        <a href="{{ url('/') }}" class="btn btn-outline-primary">
            <i class="fa fa-home"></i> Kembali ke Home
        </a>
    </div>

    {{-- [GPT] Informasi Toko --}}
    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-white fw-bold border-bottom">
            <i class="fa fa-store"></i> Informasi Toko
        </div>
        <div class="card-body">
            <p><strong>Nama:</strong> {{ Auth::user()->store_name ?? Auth::user()->name }}</p>
            <p><strong>Email:</strong> {{ Auth::user()->email }}</p>
        </div>
    </div>

    {{-- [GPT] Tabel Pesanan Masuk --}}
    <div class="card shadow-sm">
        <div class="card-header bg-white fw-bold border-bottom">
            <i class="fa fa-box"></i> Pesanan Masuk
        </div>
        <div class="card-body p-0">
            @if($orderItems->count() > 0)
                <table class="table table-striped mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Produk</th>
                            <th>Pembeli</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orderItems as $item)
                            <tr>
                                <td>{{ $item->product->name }}</td>
                                <td>{{ $item->order->user->name }}</td>
                                <td>
                                    <span class="badge bg-secondary">{{ ucfirst($item->order->status) }}</span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="p-3 text-muted">Belum ada pesanan masuk.</div>
            @endif
        </div>
    </div>
</div>
@endsection
