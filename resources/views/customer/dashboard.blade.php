@extends('layouts.customer')

@section('content')
<h1 class="mb-4">Dashboard Customer</h1>
<a href="{{ route('customer.profile.edit') }}" class="btn btn-sm btn-primary">Edit Profil Toko</a>

<div class="card mb-4">
  <div class="card-header d-flex justify-content-between align-items-center">
    <span>Profil Toko Anda</span>
    <a href="{{ route('customer.profile.edit') }}" class="btn btn-sm btn-primary">Edit Profil</a>
  </div>

  <div class="card-body d-flex align-items-center">
    @if(Auth::user()->store_logo)
    <img src="{{ asset('storage/' . Auth::user()->store_logo) }}" alt="Logo Toko" style="max-height: 100px;">
@else
    <p>Belum ada logo toko.</p>
@endif

    <div class="ml-4">
      <h4>{{ Auth::user()->name }}</h4>
      <p><strong>Alamat:</strong> {{ Auth::user()->store_address ?? '-' }}</p>
      <p><strong>Deskripsi:</strong> {{ Auth::user()->store_description ?? '-' }}</p>
    </div>
  </div>
</div>

<div class="alert alert-info">
  Selamat datang kembali, {{ Auth::user()->name }}!
</div>
@endsection
