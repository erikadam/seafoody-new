@extends('layouts.admin')

@section('content')
<div class="container py-4">
    <h2 class="h4 text-primary mb-4">Manajemen Akun Pengguna</h2>

    <ul class="nav nav-tabs" id="userTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="users-tab" data-bs-toggle="tab" data-bs-target="#users" type="button" role="tab">User</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="requested-tab" data-bs-toggle="tab" data-bs-target="#requested" type="button" role="tab">Pengajuan Upgrade</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="customers-tab" data-bs-toggle="tab" data-bs-target="#customers" type="button" role="tab">Customer</button>
        </li>
    </ul>

    <div class="tab-content pt-3">
        <div class="tab-pane fade show active" id="users" role="tabpanel">
            <table class="table table-bordered">
                <thead class="table-light">
                    <tr><th>Nama</th><th>Email</th><th>Status</th><th>Aksi</th></tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
    <tr>
        <td>{{ $user->name }}</td>
        <td>{{ $user->email }}</td>
        <td>
            @if ($user->is_suspended)
                <span class="badge bg-warning">Disuspend dari Customer</span>
            @else
                <span class="badge bg-secondary">User Baru</span>
            @endif
        </td>
        <td>
            @if ($user->is_suspended)
                <button class="btn btn-sm btn-outline-success" onclick="showUnsuspendModal({{ $user->id }})">
                    Aktifkan Kembali
                </button>
            @endif
            <button class="btn btn-sm btn-outline-danger" onclick="showDeleteModal({{ $user->id }})">Hapus</button>
        </td>
    </tr>
@endforeach
                </tbody>
            </table>
        </div>

        <div class="tab-pane fade" id="requested" role="tabpanel">
            <table class="table table-bordered">
                <thead class="table-light">
                    <tr><th>Nama</th><th>Email</th><th>Status</th><th>Aksi</th></tr>
                </thead>
                <tbody>
                    @foreach($requested as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td><span class="badge bg-info">Menunggu Persetujuan</span></td>
                            <td>
                                <button class="btn btn-sm btn-outline-success" onclick="showApproveModal({{ $user->id }})">Setujui</button>
                                <button class="btn btn-sm btn-outline-danger" onclick="showSuspendModal({{ $user->id }})">Suspend</button>
                                <button class="btn btn-sm btn-outline-danger" onclick="showDeleteModal({{ $user->id }})">Hapus</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="tab-pane fade" id="customers" role="tabpanel">
            @foreach($customers as $customer)
                <div class="card mb-3 shadow-sm">
                    <div class="card-header bg-light d-flex justify-content-between align-items-center">
                        <div>
                            <strong>{{ $customer->store_name ?? $customer->name }}</strong><br>
                            <small class="text-muted">{{ $customer->email }}</small>
                        </div>
                        <div>
                            <span class="badge {{ $customer->is_suspended ? 'bg-danger' : 'bg-success' }}">
                                {{ $customer->is_suspended ? 'Nonaktif' : 'Aktif' }}
                            </span>
                            @if($customer->is_suspended)
                                <button class="btn btn-sm btn-outline-success" onclick="showUnsuspendModal({{ $customer->id }})">Aktifkan</button>
                            @else
                                <button class="btn btn-sm btn-outline-warning" onclick="showSuspendModal({{ $customer->id }})">Suspend</button>
                            @endif
                            <button class="btn btn-sm btn-outline-danger" onclick="showDeleteModal({{ $customer->id }})">Hapus</button>
                        </div>
                    </div>
                    <div class="card-body">
                        <h6 class="text-muted">Produk:</h6>
                        <ul class="mb-0">
                            @forelse($customer->products as $product)
                                <li>{{ $product->name }} - <span class="text-muted">Rp {{ number_format($product->price) }}</span></li>
                            @empty
                                <li><em>Belum ada produk</em></li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    @include('admin.users.modals')
</div>
@endsection
