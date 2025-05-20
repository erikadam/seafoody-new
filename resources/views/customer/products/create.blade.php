@extends('layouts.customer')

@section('content')
<div class="container py-4">
    {{-- [GPT] Form tambah produk --}}
    <h2 class="h4 mb-4 text-primary">Tambah Produk Baru</h2>

    {{-- [GPT] Tampilkan error validasi --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- [GPT] Form --}}
    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Nama Produk</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Deskripsi</label>
            <textarea name="description" class="form-control" rows="3" required></textarea>
        </div>

        <div class="mb-3">
            <label for="price" class="form-label">Harga</label>
            <input type="number" name="price" class="form-control" required>
        </div>

        {{-- [GPT] Tambahan kategori dan stok --}}
        <div class="mb-3">
            <label for="category" class="form-label">Kategori</label>
            <select name="category" class="form-select" required>
            <option value="">-- Pilih Kategori --</option>
            <option value="bahan">Bahan</option>
            <option value="makanan">Makanan</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="stock" class="form-label">Stok</label>
            <input type="number" name="stock" class="form-control" min="0" required>
        </div>

        <div class="mb-3">
            <label for="image" class="form-label">Gambar Produk</label>
            <input type="file" name="image" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>
@endsection
