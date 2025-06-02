@extends('layouts.customer')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/font-awesome.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
@endpush

@section('content')
<div class="container py-4">
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <div class="text-center mb-4">
                @if(Auth::user()->store_logo)
                    <img src="{{ asset('storage/store_logo/' . Auth::user()->store_logo) }}" alt="Logo Toko"
                         class="rounded-circle shadow-sm mb-2" style="width: 90px; height: 90px; object-fit: cover;">
                @else
                    <img src="{{ asset('assets/images/default-logo.png') }}" alt="Logo Default"
                         class="rounded-circle shadow-sm mb-2" style="width: 90px; height: 90px; object-fit: cover;">
                @endif
                <h4 class="mt-2">{{ Auth::user()->store_name ?? Auth::user()->name }}</h4>
                <p class="text-muted">{{ Auth::user()->email }}</p>
            </div>

            <div class="row g-3">
                <div class="col-md-6">
                    <label class="text-muted"><i class="fa fa-info-circle me-2"></i>Deskripsi Toko</label>
                    <div>{{ Auth::user()->store_description ?? '-' }}</div>
                </div>
                <div class="col-md-6">
                    <label class="text-muted"><i class="fa fa-map-marker me-2"></i>Alamat Toko</label>
                    <div>{{ Auth::user()->store_address ?? '-' }}</div>
                </div>
            </div>

            <div class="text-end mt-4">
                <a href="{{ url('customer/profile/edit') }}" class="btn btn-primary">
                    <i class="fa fa-edit me-1"></i> Edit Profil
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
