@extends('layouts.customer')

@section('content')
<div class="container py-4">
    {{-- [GPT] Form edit profil --}}
    <h2 class="h4 mb-4 text-primary">Edit Profil Toko</h2>

    <form action="{{ url('customer/profile/update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="store_name" class="form-label">Nama Toko</label>
            <input type="text" name="store_name" class="form-control" value="{{ Auth::user()->store_name }}">
        </div>
        <div class="mb-3">
            <label for="store_description" class="form-label">Deskripsi Toko</label>
            <textarea name="store_description" class="form-control">{{ Auth::user()->store_description }}</textarea>
        </div>
        <div class="mb-3">
            <label for="store_address" class="form-label">Alamat Toko</label>
            <textarea name="store_address" class="form-control">{{ Auth::user()->store_address }}</textarea>
        </div>
        <div class="mb-3">
            <label for="store_logo" class="form-label">Logo Toko</label>
            <input type="file" name="store_logo" class="form-control">
        </div>
        <button type="submit" class="btn btn-warning">Simpan Perubahan</button>
    </form>
</div>
@endsection
