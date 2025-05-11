@extends('layouts.customer')

@section('content')
<div class="container">
  <h1 class="mb-4">Dashboard Customer</h1>

  <div class="alert alert-info">
    Selamat datang, {{ Auth::user()->name }}!
  </div>

  <a href="{{ route('customer.products.create') }}" class="btn btn-primary mb-4">+ Tambah Produk</a>

  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  <div class="card">
    <div class="card-header">Produk Saya</div>
    <div class="card-body">
      @if($products->count())
        <table class="table table-bordered">
          <thead>
            <tr>
              <th>Nama</th>
              <th>Kategori</th>
              <th>Stok</th>
              <th>Harga</th>
              <th>Status</th>
              <th>Gambar</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            @foreach($products as $product)
              <tr>
                <td>{{ $product->name }}</td>
                <td>{{ $product->category }}</td>
                <td>
                  {{ $product->stock }}
                  @if($product->stock == 0)
                    <span class="badge bg-danger">Stok Habis</span>
                  @endif
                </td>
                <td>Rp {{ number_format($product->price) }}</td>
                <td>
                  @if($product->stock == 0 || $product->status == 'nonaktif')
                    <span class="badge bg-secondary">Nonaktif</span>
                  @elseif($product->status == 'approved')
                    <span class="badge bg-success">Aktif</span>
                  @else
                    <span class="badge bg-warning text-dark">Menunggu Persetujuan</span>
                  @endif
                </td>
                <td>
                  @if($product->image)
                    <img src="{{ asset('uploads/product/' . $product->image) }}" alt="{{ $product->name }}" width="60">
                  @else
                    Tidak ada
                  @endif
                </td>
                <td>
                  <a href="{{ route('customer.products.edit', $product->id) }}" class="btn btn-sm btn-warning">Edit</a>
                  <form action="{{ route('customer.products.destroy', $product->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                  </form>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      @else
        <p>Belum ada produk yang diunggah.</p>
      @endif
    </div>
  </div>
</div>
@endsection
