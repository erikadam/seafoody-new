
@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="alert alert-info">
        Sebelum melanjutkan, silakan verifikasi email Anda dengan mengklik link yang telah kami kirim ke kotak masuk Anda.
        Jika Anda tidak menerima email tersebut,
        Anda bisa meminta pengiriman ulang dengan menekan tombol di bawah ini.
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="alert alert-success">
            Link verifikasi baru telah dikirim ke email Anda.
        </div>
    @endif

    <form method="POST" action="{{ route('verification.send') }}">
        @csrf
        <button type="submit" class="btn btn-primary">Kirim Ulang Link Verifikasi</button>
    </form>
</div>
@endsection
