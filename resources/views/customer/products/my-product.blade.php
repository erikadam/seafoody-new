@extends('layouts.customer')

@section('content')
<div class="container">
  <h1 class="mb-4">Dashboard Customer</h1>

  <div class="alert alert-info">
    Selamat datang, {{ Auth::user()->name }}!
  </div>

  <a href="{{ route('customer.products.create') }}" class="btn btn-primary mb-4">+ Tambah Produk</a>

  <div class="card">
    <div class="card-header">Produk Saya</div>
    <div class="card-body">
      @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
      @endif

      @if($products->count())
        <table class="table table-bordered">
          <thead>
            <tr>
              <th>Nama</th>
              <th>Deskripsi</th>
              <th>Harga</th>
              <th>Status</th>
              <th>Gambar</th>
            </tr>
          </thead>
          <tbody>
            @foreach($products as $product)
              <tr>
                <td>{{ $product->name }}</td>
                <td>{{ $product->description }}</td>
                <td>Rp {{ number_format($product->price) }}</td>
                <td>{{ $product->status ?? 'Menunggu Persetujuan' }}</td>
                <td>
                  @if($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" width="80">
                  @else
                    Tidak ada
                  @endif
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
