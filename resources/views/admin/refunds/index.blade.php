@extends('layouts.admin')

@section('content')
<div class="container py-4">
    <h2 class="mb-4">Daftar Permintaan Refund</h2>

    <table class="table table-bordered">
        <thead class="table-dark">
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
            @foreach($refunds as $key => $item)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $item->product->name }}</td>
                <td>{{ $item->order->user->name ?? '-' }}</td>
                <td>{{ $item->product->user->store_name ?? '-' }}</td>
                <td>{{ $item->refund_reason }}</td>
                <td>{{ $item->refund_bank_name ?? '-' }}</td>
                <td>{{ $item->refund_account_number ?? '-' }}</td>
                <td>
                    @if(optional($item->order)->payment_method === 'transfer')
                        <!-- Tombol buka modal upload -->
                        <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#uploadModal{{ $item->id }}">
                            Setujui
                        </button>

                        <!-- Modal Upload Bukti Transfer -->
                        <div class="modal fade" id="uploadModal{{ $item->id }}" tabindex="-1" aria-labelledby="uploadModalLabel{{ $item->id }}" aria-hidden="true">
                          <div class="modal-dialog">
                            <form action="{{ route('admin.refund.upload', $item->id) }}" method="POST" enctype="multipart/form-data">
                              @csrf
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title" id="uploadModalLabel{{ $item->id }}">Upload Bukti Refund</h5>
                                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                  <div class="mb-3">
                                    <label class="form-label">Upload Bukti Transfer</label>
                                    <input type="file" name="admin_transfer_proof" class="form-control" required accept="image/*">
                                  </div>
                                </div>
                                <div class="modal-footer">
                                  <button type="submit" class="btn btn-primary">Upload & Setujui</button>
                                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                </div>
                              </div>
                            </form>
                          </div>
                        </div>
                    @else
                        <span class="text-muted">Menunggu aksi dari penjual</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    </table>
</div>
@endsection
