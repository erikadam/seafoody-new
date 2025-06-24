@extends('layouts.customer')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h4 text-primary">Produk Saya</h2>
        <a href="{{ url('customer/products/create') }}" class="btn btn-outline-primary">
            <i class="fa fa-plus"></i> Tambah Produk
        </a>
    </div>
    <div class="card shadow-sm">
        <div class="card-body p-0">
            @if($products->count())
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Nama</th>
                        <th>Harga</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $product)
                    <tr>
                        <td>{{ $product->name }}</td>
                        <td>Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                        <td><span class="badge bg-secondary">{{ ucfirst($product->status) }}</span></td>
                        <td>
                            <a href="{{ url('customer/products/edit/'.$product->id) }}" class="btn btn-sm btn-outline-warning">Edit</a>
                            <a href="{{ url('customer/products/show/'.$product->id) }}" class="btn btn-sm btn-outline-info">Lihat</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <div class="p-3 text-muted">Belum ada produk.</div>
            @endif
        </div>
    </div>
</div>
@endsection
