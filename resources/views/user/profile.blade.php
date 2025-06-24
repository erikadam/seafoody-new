
@extends('layouts.app')

@section('content')
<div class="container mt-5 py-5" style="max-width: 720px">
    {{-- Avatar dan Profil --}}
    <div class="text-center mb-4">
        <div style="display: flex; justify-content: center; align-items: center; margin-top: 20px;">
  <div style="width: 150px; height: 150px; overflow: hidden; border-radius: 50%; border: 2px solid #ccc; box-shadow: 0 0 8px rgba(0,0,0,0.15);">
    <img src="{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : '/images/default-avatar.png' }}"
         alt="Avatar"
         style="width: 100%; height: 100%; object-fit: cover;">
  </div>
</div>
        <h4 class="fw-semibold">{{ Auth::user()->name }}</h4>
        <button onclick="toggleEditProfile()" class="btn btn-sm btn-outline-secondary mt-2" type="button">
            <i class="fa fa-pen"></i> Edit Profil
        </button>
<div id="editProfileForm" class="mt-4 d-none">
    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="mb-3 text-start">
            <label for="name" class="form-label">Nama Lengkap</label>
            <input type="text" class="form-control" name="name" value="{{ Auth::user()->name }}" required>
        </div>
        <div class="mb-3 text-start">
            <label for="avatar" class="form-label">Foto Profil</label>
            <input type="file" class="form-control" name="avatar">
        </div>
        <button type="submit" class="btn btn-success w-100">Simpan Perubahan</button>
    </form>
</div>

    </div>

    {{-- Email dan Verifikasi --}}
    <div class="mb-4 text-center">
        <strong>Email:</strong> <span class="fw-bold text-dark">{{ Auth::user()->email }}</span>
        @if(!Auth::user()->hasVerifiedEmail())
            <form method="POST" action="{{ route('verification.send') }}" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-warning btn-sm ms-2">Verifikasi</button>
                <div id="editProfileForm" class="mt-4 d-none">
                 <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                 @csrf
                    @method('PUT')
                 <div class="mb-3 text-start">
                    <label for="name" class="form-label">Nama Lengkap</label>
                    <input type="text" class="form-control" name="name" value="{{ Auth::user()->name }}" required>
                </div>
                    <div class="mb-3 text-start">
                    <label for="avatar" class="form-label">Foto Profil</label>
                    <input type="file" class="form-control" name="avatar">
                </div>
            <button type="submit" class="btn btn-success w-100">Simpan Perubahan</button>
        </form>
        </div>
            </form>
            <div class="text-danger small mt-1">Email anda belum diverifikasi</div>
        @endif
    </div>

    {{-- Upgrade Toko --}}
    @if(Auth::user()->role === 'user')
        @if(!Auth::user()->requested_seller)
            <div class="text-center mb-3">
                <button class="btn btn-warning fw-bold px-4 py-2" onclick="toggleUpgradeForm()">Upgrade Toko Anda</button>
<div id="editProfileForm" class="mt-4 d-none">
    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="mb-3 text-start">
            <label for="name" class="form-label">Nama Lengkap</label>
            <input type="text" class="form-control" name="name" value="{{ Auth::user()->name }}" required>
        </div>
        <div class="mb-3 text-start">
            <label for="avatar" class="form-label">Foto Profil</label>
            <input type="file" class="form-control" name="avatar">
        </div>
        <button type="submit" class="btn btn-success w-100">Simpan Perubahan</button>
    </form>
</div>

            </div>
        @endif

        {{-- Status Upgrade --}}
        @if(Auth::user()->requested_seller && !Auth::user()->is_approved && Auth::user()->status !== 'rejected')
            <div class="alert alert-warning text-center">Permintaan upgrade sedang ditinjau admin.</div>
        @elseif(Auth::user()->requested_seller && Auth::user()->is_approved && Auth::user()->role === 'customer')
            <div class="alert alert-success text-center">Permintaan upgrade disetujui. Anda sekarang adalah Akun Toko.</div>
        @elseif(Auth::user()->requested_seller && !Auth::user()->is_approved && Auth::user()->status === 'rejected')
            <div class="alert alert-danger text-center">Admin tidak menyetujui pengajuan Anda. Hubungi admin di <strong>admin@toko.com</strong>.</div>
        @endif

        {{-- Form Upgrade (disembunyikan) --}}
        <div id="upgradeForm" class="d-none mt-4 border rounded p-4 bg-light">
            <h5 class="mb-3">Form Pengajuan Akun Toko</h5>
            <form method="POST" action="{{ route('profile.request_seller') }}">
                @csrf
                <div class="mb-3">
                    <label>Nama Toko</label>
                    <input type="text" name="store_name" class="form-control" required placeholder="Contoh: Toko Baju Erika">
                </div>
                <div class="mb-3">
                    <label>Deskripsi Toko</label>
                    <textarea name="store_description" class="form-control" required></textarea>
                </div>
                <div class="mb-3">
                    <label>Alamat Toko</label>
                    <input type="text" name="store_address" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Ajukan Sekarang</button>
<div id="editProfileForm" class="mt-4 d-none">
    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
        @csrf

        <div class="mb-3 text-start">
            <label for="name" class="form-label">Nama Lengkap</label>
            <input type="text" class="form-control" name="name" value="{{ Auth::user()->name }}" required>
        </div>
        <div class="mb-3 text-start">
            <label for="avatar" class="form-label">Foto Profil</label>
            <input type="file" class="form-control" name="avatar">
        </div>
        <button type="submit" class="btn btn-success w-100">Simpan Perubahan</button>
    </form>
</div>

            </form>
        </div>
    @endif

    {{-- Ubah Password --}}
    <div class="mt-5">
        <h5 class="mb-3">Ubah Password</h5>
        <form method="POST" action="{{ route('profile.update_password') }}">
            @csrf
            <div class="mb-3">
                <input type="password" name="password" class="form-control" placeholder="Password Baru" required>
            </div>
            <div class="mb-3">
                <input type="password" name="password_confirmation" class="form-control" placeholder="Konfirmasi Password" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Perbarui Password</button>
<div id="editProfileForm" class="mt-4 d-none">
    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="mb-3 text-start">
            <label for="name" class="form-label">Nama Lengkap</label>
            <input type="text" class="form-control" name="name" value="{{ Auth::user()->name }}" required>
        </div>
        <div class="mb-3 text-start">
            <label for="avatar" class="form-label">Foto Profil</label>
            <input type="file" class="form-control" name="avatar">
        </div>
        <button type="submit" class="btn btn-success w-100">Simpan Perubahan</button>
    </form>
</div>

        </form>
    </div>

</div>

<script>
function toggleUpgradeForm() {
    document.getElementById('upgradeForm').classList.toggle('d-none');
}

function toggleEditProfile() {
    document.getElementById('editProfileForm').classList.toggle('d-none');
}
</script>

@endsection
