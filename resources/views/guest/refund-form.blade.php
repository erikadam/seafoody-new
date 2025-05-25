@extends('layouts.guest')

@section('content')
<div class="container py-5 mt-4">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card shadow rounded-4">
        <div class="card-header bg-warning text-dark rounded-top-4">
          <h5 class="mb-0 fw-bold">Ajukan Refund</h5>
        </div>
        <div class="card-body">
          <form method="POST" action="{{ route('refund.submit', $item->id) }}">
            @csrf

            <div class="mb-3">
              <label class="form-label">Produk</label>
              <input type="text" class="form-control" value="{{ $item->product->name }}" disabled>
            </div>

            <div class="mb-3">
              <label for="reason" class="form-label">Alasan Refund</label>
              <textarea name="reason" id="reason" rows="3" class="form-control" required>{{ old('reason') }}</textarea>
            </div>

            <div class="mb-3">
              <label for="bank_name" class="form-label">Nama Bank</label>
              <input type="text" name="bank_name" id="bank_name" class="form-control" required value="{{ old('bank_name') }}">
            </div>

            <div class="mb-3">
              <label for="bank_account" class="form-label">Nomor Rekening</label>
              <input type="text" name="bank_account" id="bank_account" class="form-control" required value="{{ old('bank_account') }}">
            </div>

            <div class="text-end">
              <button type="submit" class="btn btn-warning px-4">Kirim Permintaan</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
