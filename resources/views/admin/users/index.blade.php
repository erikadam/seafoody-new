@extends('layouts.admin')

@section('content')
<div class="container">
    <h1>Daftar User yang Belum Disetujui</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Email</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
        @forelse($users as $user)
            <tr>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>
                    <form method="POST" action="{{ route('admin.users.approve', $user) }}">
                        @csrf
                        <button type="submit" class="btn btn-success btn-sm">Setujui</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="3">Tidak ada user yang menunggu persetujuan.</td></tr>
        @endforelse
        </tbody>
    </table>
</div>
@endsection
