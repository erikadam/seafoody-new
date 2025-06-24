@extends('layouts.customer')

@section('content')
<div class="container py-4">

    <h2 class="h4 mb-4 text-primary">Edit Produk</h2>
    <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf @method('PUT')
        <div class="mb-3">
            <label for="name" class="form-label">Nama Produk</label>
            <input type="text" name="name" class="form-control" value="{{ $product->name }}" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Deskripsi</label>
            <textarea name="description" class="form-control" rows="3" required>{{ $product->description }}</textarea>
        </div>
        <div class="mb-3">
            <label for="price" class="form-label">Harga</label>
            <input type="number" name="price" class="form-control" value="{{ $product->price }}" required>
        </div>
        <div class="mb-3">
            <label for="image" class="form-label">Gambar Produk (kosongkan jika tidak ingin mengganti)</label>
            <input type="file" name="image" class="form-control">
        </div>
        <button type="submit" class="btn btn-warning">Update</button>
    </form>
</div>
@endsection
