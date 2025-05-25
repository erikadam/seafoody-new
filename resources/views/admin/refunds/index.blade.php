@extends('layouts.admin')

@section('content')
<div class="container py-4">
  <h4 class="fw-bold mb-4">📄 Daftar Permintaan Refund</h4>

  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif
  @if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
  @endif

  <div class="table-responsive">
    <table class="table table-bordered table-striped align-middle">
      <thead class="table-light">
        <tr>
          <th>#</th>
          <th>Produk</th>
          <th>Pembeli</th>
          <th>Penjual</th>
          <th>Alasan</th>
          <th>Bank</th>
          <th>No. Rekening</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse($items as $item)
          <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $item->product->name }}</td>
            <td>{{ $item->order->user->name ?? '-' }}</td>
            <td>{{ $item->product->seller->name ?? '-' }}</td>
            <td>{{ $item->refund_reason ?? '-' }}</td>
            <td>{{ $item->bank_name ?? '-' }}</td>
            <td>{{ $item->bank_account ?? '-' }}</td>
            <td>
              <form method="POST" action="{{ route('admin.refund.approve', $item->id) }}">
                @csrf
                <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Setujui permintaan refund ini?')">Setujui</button>
              </form>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="8" class="text-center text-muted">Tidak ada permintaan refund.</td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
@endsection
