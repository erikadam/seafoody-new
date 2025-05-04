<h2>Riwayat Pesanan untuk: {{ $request->email }}</h2>

@if ($orders->isEmpty())
    <p>Tidak ada pesanan ditemukan untuk email tersebut.</p>
@else
    <table border="1" cellpadding="6">
        <thead>
            <tr>
                <th>Produk</th>
                <th>Status</th>
                <th>Alamat</th>
                <th>No. HP</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($orders as $order)
            <tr>
                <td>{{ $order->product->name ?? '-' }}</td>
                <td>{{ ucfirst($order->status) }}</td>
                <td>{{ $order->address }}</td>
                <td>{{ $order->buyer_phone }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
@endif

<a href="{{ route('orders.track.form') }}">Kembali</a>
@foreach ($orders as $order)
<tr>
    <td>{{ $order->product->name ?? '-' }}</td>
    <td>
        {{ ucfirst($order->status) }}
        @if ($order->cancel_requested)
            <br><small>Permintaan pembatalan sedang diproses</small>
        @elseif ($order->cancel_approved === false)
            <br><small>Pembatalan ditolak</small>
        @elseif ($order->cancel_approved === true)
            <br><small>Pesanan dibatalkan</small>
        @elseif ($order->status === 'approved')
            <form method="POST" action="{{ route('orders.requestCancel', $order->id) }}">
                @csrf
                <button type="submit">Ajukan Pembatalan</button>
            </form>
        @endif
    </td>
    <td>{{ $order->address }}</td>
    <td>{{ $order->buyer_phone }}</td>
</tr>
@endforeach
