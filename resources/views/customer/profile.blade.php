@extends('layouts.app')

@section('content')
<div class="container">
    <h4>Profil Penjual</h4>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('customer.profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label>Nama Toko</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}">
        </div>

        <div class="mb-3">
            <label>Logo Toko</label><br>
            @if($user->store_logo)
                <img src="{{ asset('storage/' . $user->store_logo) }}" width="120" class="mb-2">
            @endif
            <input type="file" name="store_logo" class="form-control">
        </div>
        <div class="mb-3">
            <label>Alamat Toko</label>
            <input type="text" name="store_address" class="form-control" value="{{ old('store_address', $user->store_address) }}">
        </div>

        <div class="mb-3">
            <label>Deskripsi Toko</label>
            <textarea name="store_description" class="form-control" rows="4">{{ old('store_description', $user->store_description) }}</textarea>
        </div>

        <button class="btn btn-primary">Simpan</button>
    </form>
</div>
@endsection
