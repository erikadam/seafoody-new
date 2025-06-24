@extends('layouts.guest')
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title> Seafoody - @yield('title', 'Home')</title>
  <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/font-awesome.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
</head>
<body>

  <!-- Preloader -->

  <!-- Header -->
@include('partials.navbar')
@section('content')
<div class="container py-4 mt-5">
    @forelse ($orders as $order)
        <div class="card mb-4 shadow-sm mt-5">
            <div class="card-header bg-light">
                <strong>Kode Pesanan:</strong> {{ $order->token }} <br>
                <small class="text-muted">Tanggal: {{ $order->created_at->format('d M Y') }}</small>
            </div>
            <div class="card-body p-0">
                <ul class="list-group list-group-flush">
                    @foreach ($order->orderItems as $item)
                        <li class="list-group-item">
                            <div class="d-flex justify-content-between">
                                <div class="d-flex">
                                    <a href="{{ route('guest.products.show', $item->product->id) }}">
                                        <img src="{{ asset('uploads/product/' . $item->product->image) }}"
                                            class="me-3 rounded"
                                            style="width: 80px; height: 80px; object-fit: cover;"
                                            alt="{{ $item->product->name }}">
                                    </a>
                                    <div>
                                        <div><strong>{{ $item->product->name }}</strong></div>
                                        <div class="text-muted small">Toko: {{ $item->product->user->store_name ?? '-' }}</div>
                                        <div class="small">
                                            Status:
                                            <span class="badge bg-{{
                                                $item->status === 'received_by_buyer' ? 'success' :
                                                ($item->status === 'shipped_by_customer' ? 'info' :
                                                ($item->status === 'cancelled_by_buyer' ? 'danger' : 'secondary'))
                                            }}">
                                                {{ ucwords(str_replace('_', ' ', $item->status)) }}
                                            </span>
                                        </div>
                                        <div class="mt-2">
                                            @if($item->status === 'received_by_buyer')
                                            <form method="GET" action="{{ route('refund.form', $item->id) }}">
                                                <button type="submit" class="btn btn-sm btn-warning">Ajukan Refund</button>
                                            </form>
                                            @endif
                                            @if($item->status === 'shipped_by_customer')
                                            <form method="POST" action="{{ route('order.confirm', $item->id) }}">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-success mt-2">Terima Pesanan</button>
                                            </form>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="text-end">
                                    <div class="text-muted small">Qty: {{ $item->quantity }}</div>
                                    <div class="text-muted small">Rp {{ number_format($item->price) }}</div>
                                </div>
                            </div>

                            @if ($item->status === 'received_by_buyer' && !$item->refund_requested)
                                <div id="refund-{{ $item->id }}" class="mt-3 p-3 border rounded bg-light d-none">
                                    @include('guest.refund-form', ['item' => $item])
                                </div>
                            @elseif($item->status === 'refunded' && $item->admin_transfer_proof)
                                @if ($item->admin_transfer_proof)
    <a href="{{ asset('storage/' . $item->admin_transfer_proof) }}" target="_blank" class="btn btn-outline-primary btn-sm">
        Lihat Bukti Transfer
    </a>
@else
    <span class="text-muted">Belum ada bukti transfer</span>
@endif
                            @endif

                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    @empty
        <p class="text-muted">Belum ada pesanan.</p>
    @endforelse
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const buttons = document.querySelectorAll('.toggle-refund');
        buttons.forEach(btn => {
            btn.addEventListener('click', function () {
                const target = document.getElementById(this.dataset.target);
                if (target) target.classList.toggle('d-none');
            });
        });
    });
</script>
  <!-- Scripts -->
  <script src="{{ asset('assets/js/jquery-2.1.0.min.js') }}"></script>
  <script src="{{ asset('assets/js/popper.js') }}"></script>
  <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
  <script src="{{ asset('assets/js/scrollreveal.min.js') }}"></script>
  <script src="{{ asset('assets/js/waypoints.min.js') }}"></script>
  <script src="{{ asset('assets/js/jquery.counterup.min.js') }}"></script>
  <script src="{{ asset('assets/js/imgfix.min.js') }}"></script>
  <script src="{{ asset('assets/js/mixitup.js') }}"></script>
  <script src="{{ asset('assets/js/accordions.js') }}"></script>
  <script src="{{ asset('assets/js/custom.js') }}"></script>
  @endsection
</body>
@if(session('success'))
  <div id="toast-alert" style="
    position: fixed;
    top: 70px;
    right: 20px;
    background-color: #38c172;
    color: white;
    padding: 10px 20px;
    border-radius: 6px;
    z-index: 9999;
    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    font-size: 14px;
  ">
    {{ session('success') }}
  </div>

  <script>
    setTimeout(() => {
      const toast = document.getElementById('toast-alert');
      if (toast) toast.style.display = 'none';
    }, 3000);
  </script>
@endif

</html>
