@extends('layouts.customer')

@section('content')
  <h2>Upload Produk</h2>

  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  <form method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data">
    @csrf

    <div class="mb-3">
      <label for="name" class="form-label">Nama Produk</label>
      <input type="text" name="name" class="form-control" required>
    </div>

    <div class="mb-3">
      <label for="description" class="form-label">Deskripsi</label>
      <textarea name="description" class="form-control"></textarea>
    </div>

    <div class="mb-3">
      <label for="price" class="form-label">Harga</label>
      <input type="number" name="price" class="form-control" required>
    </div>

    <div class="mb-3">
      <label for="image" class="form-label">Gambar Produk (opsional)</label>
      <input type="file" name="image" class="form-control">
    </div>

    <button type="submit" class="btn btn-primary">Kirim</button>
  </form>
@endsection
