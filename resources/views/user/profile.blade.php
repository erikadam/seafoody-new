
@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/font-awesome.css') }}">

<div class="container mt-5 py-5">


    @if(Auth::user()->requested_seller && !Auth::user()->is_approved)
        <div class="alert alert-warning mb-4">
            Akun Anda sedang <strong>ditinjau</strong> untuk menjadi <strong>Akun Toko</strong>. Mohon tunggu persetujuan admin.
        </div>
    @endif


    @if(session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif


@if(Auth::user()->role === 'user' && !Auth::user()->is_approved)
    <div class="my-4 border-top pt-3">
        @if(!Auth::user()->requested_seller)
            <form method="POST" action="{{ route('profile.request_seller') }}">
                @csrf
                <div class="mb-3">
                    <input type="text" name="store_name" class="form-control" required placeholder="Contoh: Toko Baju Erika">
                </div>
                <button type="submit" class="btn btn-outline-primary w-100">Ajukan Menjadi Akun Toko [Upgrade]</button>
            </form>
        @else
            <div class="alert alert-info text-center">Permintaan upgrade sedang diproses oleh admin.</div>
        @endif
    </div>
@endif

<div class="row">
        {{-- [GPT] Kiri: Avatar + Nama --}}
        <div class="col-md-6 d-flex align-items-start">
            <div class="position-relative me-3">
                <img src="{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : '/images/default-avatar.png' }}" width="120" height="120" class="rounded-circle border">
            </div>
            <div>
                <h4 class="mb-1">{{ Auth::user()->name }}</h4>
                <button onclick="toggleEditProfile()" class="btn btn-sm btn-outline-secondary">
                    <i class="fa fa-pencil"></i> Edit Profil
                </button>
            </div>
        </div>

        {{-- [GPT] Kanan: Form Edit Profil --}}
        <div class="col-md-6 d-none" id="edit-profile-form">
            <div class="card">
                <div class="card-header bg-light fw-bold">Edit Nama & Foto</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="avatar">Foto Profil</label>
                            <input type="file" name="avatar" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label for="name">Nama</label>
                            <input type="text" name="name" class="form-control" value="{{ Auth::user()->name }}">
                        </div>

                        <button type="submit" class="btn btn-success">Simpan</button>
                    </form>
                </div>
            </div>

    </div>
    </div>

    {{-- [GPT] Ajukan Menjadi Akun Toko --}}
    @if(Auth::user()->role === 'user')
        <div class="my-4 border-top pt-3">
            @if(!Auth::user()->requested_seller)

            @else
                <div class="alert alert-info text-center">Permintaan upgrade sedang diproses oleh admin.</div>
            @endif
        </div>
    @endif

    {{-- [GPT] Email --}}
    <div class="mb-3 mt-4">
        <label class="form-label">Email</label>
        <div class="d-flex align-items-center">
            <strong>{{ Auth::user()->email }}</strong>
            @if(Auth::user()->email_verified_at)
                <span class="badge bg-success ms-2">Terverifikasi</span>
                <a href="#edit-profile-form" class="btn btn-sm btn-outline-secondary ms-3">Edit</a>
            @else
                <form method="POST" action="{{ route('profile.send_verification') }}" class="ms-3">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-warning">Verifikasi</button>
                </form>
            @endif
        </div>
        @if(!Auth::user()->email_verified_at)
            <small class="text-danger">Email anda belum diverifikasi</small>
        @endif
    </div>

    {{-- [GPT] Password --}}
    <div class="card mt-4">
        <div class="card-header bg-light fw-bold">Ubah Password</div>
        <div class="card-body">
            <form method="POST" action="{{ route('profile.update_password') }}">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="password" class="form-label">Password Baru</label>
                    <input type="password" name="password" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-primary">Perbarui Password</button>
            </form>

    </div>
    </div>

    {{-- [GPT] Ajukan Menjadi Akun Toko --}}
    @if(Auth::user()->role === 'guest')
        <div class="my-4 border-top pt-3">
            @if(!Auth::user()->requested_seller)

            @else
                <div class="alert alert-info text-center">Permintaan upgrade sedang diproses oleh admin.</div>
            @endif
        </div>
    @endif

</div>

<script>
function toggleEditProfile() {
    document.getElementById('edit-profile-form').classList.toggle('d-none');
}
</script>
@endsection
