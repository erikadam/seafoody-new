@extends('layouts.customer')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/font-awesome.css') }}">
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
@endpush

@section('content')
<div class="container py-4">
    <h2 class="h4 mb-4 text-primary"><i class="fa fa-edit me-2"></i>Edit Profil Toko</h2>

    <form action="{{ route('customer.profile.update') }}" method="POST" enctype="multipart/form-data" class="card shadow-sm p-4">
        @csrf

        <div class="text-center mb-4">
            @if($user->store_logo)
                <img src="{{ asset('storage/' . $user->store_logo) }}" alt="Logo Toko"
                     class="rounded-circle shadow-sm" style="width: 90px; height: 90px; object-fit: cover;">
            @else
                <img src="{{ asset('assets/images/default-logo.png') }}" alt="Logo Default"
                     class="rounded-circle shadow-sm" style="width: 90px; height: 90px; object-fit: cover;">
            @endif
            <p class="mt-2 text-muted">Logo Toko Saat Ini</p>
        </div>
        <div class="mb-3">
            <label for="store_name" class="form-label"><i class="fa fa-store me-2 text-muted"></i>Nama Toko</label>
            <input type="text" name="store_name" class="form-control" value="{{ old('store_name', $user->store_name) }}">
        </div>

        <div class="mb-3">
            <label for="store_description" class="form-label"><i class="fa fa-info-circle me-2 text-muted"></i>Deskripsi Toko</label>
            <textarea name="store_description" class="form-control" rows="3">{{ old('store_description', $user->store_description) }}</textarea>
        </div>

        <div class="mb-3">
            <label for="store_address" class="form-label"><i class="fa fa-map-marker me-2 text-muted"></i>Alamat Toko</label>
            <textarea name="store_address" class="form-control" rows="2">{{ old('store_address', $user->store_address) }}</textarea>
        </div>

        <div class="mb-4">
            <label for="store_logo" class="form-label"><i class="fa fa-image me-2 text-muted"></i>Upload Logo Baru</label>
            <input type="file" name="store_logo" class="form-control">
            <small class="text-muted">Ukuran maksimal 2MB. Format: JPG, PNG.</small>
        </div>

        <div class="text-end">
            <button type="submit" class="btn btn-primary">
                <i class="fa fa-save me-1"></i> Simpan Perubahan
            </button>
        </div>
    </form>
</div>
@endsection
