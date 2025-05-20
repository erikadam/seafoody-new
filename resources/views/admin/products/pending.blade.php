
@extends('layouts.admin')

@section('content')
<div class="container">
    <h2 class="mb-4">Produk Menunggu Persetujuan</h2>

    @if (session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    @if($products->isEmpty())
        <div class="alert alert-info">Tidak ada produk yang menunggu persetujuan.</div>
    @else
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nama Produk</th>
                <th>Penjual</th>
                <th>Status</th>
                <th>Harga</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
        @foreach ($products as $product)
            <tr>
                <td>{{ $product->name }}</td>
                <td>{{ $product->seller->store_name ?? $product->seller->name }}</td>
                <td>{{ $product->status }}</td>
                <td>Rp{{ number_format($product->price, 0, ',', '.') }}</td>
                <td>
                    <form action="{{ route('admin.products.approve', $product->id) }}" method="POST" style="display:inline-block;">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-success">Setujui</button>
                    </form>
                    <form action="{{ route('admin.products.reject', $product->id) }}" method="POST" style="display:inline-block;">
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
