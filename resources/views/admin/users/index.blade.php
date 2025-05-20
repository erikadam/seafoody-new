
@extends('layouts.admin')

@section('content')
<div class="container">
    <h2 class="mb-4">Permintaan Akses Penjual</h2>

    @if (session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @elseif (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if($users->isEmpty())
        <div class="alert alert-info">Tidak ada permintaan yang menunggu persetujuan.</div>
    @else
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Email</th>
                <th>Status Verifikasi</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
        @foreach ($users as $user)
            @if($user->requested_seller && !$user->is_approved)
            <tr>
                <td>{{ $user->store_name ?? $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>
                    @if ($user->email_verified_at)
                        <span class="badge bg-success">Terverifikasi</span>
                    @else
                        <span class="badge bg-warning text-dark">Belum Verifikasi</span>
                    @endif
                </td>
                <td>
                    <form method="POST" action="{{ route('admin.users.approve', $user->id) }}">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-success">Setujui</button>
                    </form>
                </td>
            </tr>
            @endif
        @endforeach
        </tbody>
    </table>
    @endif
</div>
@endsection
