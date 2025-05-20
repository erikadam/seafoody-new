@extends('layouts.customer')

@section('content')
<div class="container py-4">
    {{-- [GPT] Informasi Profil --}}
    <h2 class="h4 mb-4 text-primary">Profil Toko</h2>

    <div class="card shadow-sm">
        <div class="card-body">
            <p><strong>Nama Toko:</strong> {{ Auth::user()->store_name ?? Auth::user()->name }}</p>
            <p><strong>Email:</strong> {{ Auth::user()->email }}</p>
            <p><strong>Deskripsi:</strong> {{ Auth::user()->store_description ?? '-' }}</p>
            <p><strong>Alamat:</strong> {{ Auth::user()->store_address ?? '-' }}</p>
        </div>
    </div>

    <a href="{{ url('customer/profile/edit') }}" class="btn btn-outline-primary mt-3">Edit Profil</a>
</div>
@endsection
