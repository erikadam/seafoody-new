@extends('layouts.admin')

@section('content')
<div class="container py-4">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card shadow rounded-4">
        <div class="card-header bg-primary text-white rounded-top-4">
          <h5 class="mb-0">Upload Bukti Refund</h5>
        </div>
        <div class="card-body">
          @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
          @endif

          <p><strong>Produk:</strong> {{ $item->product->name }}</p>
          <p><strong>Pembeli:</strong> {{ $item->order->user->name ?? '-' }}</p>
          <p><strong>Metode Pembayaran:</strong> {{ $item->order->payment_method }}</p>

          <form method="POST" action="{{ route('admin.refund.process', $item->id) }}" enctype="multipart/form-data">
            @csrf

            @if($item->order->payment_method === 'transfer')
              <div class="mb-3">
                <label for="admin_transfer_proof" class="form-label">Upload Bukti Transfer</label>
                <input type="file" name="admin_transfer_proof" id="admin_transfer_proof" class="form-control" required accept="image/*">
              </div>
            @else
              <div class="alert alert-info">Refund COD tidak memerlukan bukti transfer.</div>
            @endif

            <div class="text-end">
              <button type="submit" class="btn btn-success">Proses Refund</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
