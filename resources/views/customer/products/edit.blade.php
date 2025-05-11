@extends('layouts.customer')

@section('content')
  <div class="container">
    <h2>Edit Produk</h2>

    @if(session('success'))
      <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('customer.products.update', $product->id) }}" enctype="multipart/form-data">
      @csrf
      @method('PUT')

      <div class="mb-3">
        <label for="name" class="form-label">Nama Produk</label>
        <input type="text" name="name" class="form-control" value="{{ $product->name }}" required>
      </div>

      <div class="mb-3">
        <label for="description" class="form-label">Deskripsi</label>
        <textarea name="description" class="form-control" required>{{ $product->description }}</textarea>
      </div>

      <div class="mb-3">
        <label for="price" class="form-label">Harga</label>
        <input type="number" name="price" class="form-control" value="{{ $product->price }}" required>
      </div>

      <div class="mb-3">
        <label for="category" class="form-label">Kategori</label>
        <select name="category" class="form-control" required>
          <option value="">Pilih Kategori</option>
          <option value="Bahan" {{ $product->category == 'Bahan' ? 'selected' : '' }}>Bahan</option>
          <option value="Makanan" {{ $product->category == 'Makanan' ? 'selected' : '' }}>Makanan</option>
        </select>
      </div>

      <div class="mb-3">
        <label for="stock" class="form-label">Stok</label>
        <input type="number" name="stock" class="form-control" min="0" value="{{ $product->stock }}" required>
      </div>

      <div class="mb-3">
        <label for="image" class="form-label">Gambar Produk (opsional)</label><br>
        @if($product->image)
          <img src="{{ asset('uploads/product/' . $product->image) }}" alt="Gambar Produk" width="100" class="mb-2"><br>
        @endif
        <input type="file" name="image" class="form-control">
      </div>

      <button type="submit" class="btn btn-success">Simpan Perubahan</button>
      <a href="{{ url('/customer/products/my-product') }}" class="btn btn-secondary">Kembali</a>

    </form>
  </div>
@endsection
