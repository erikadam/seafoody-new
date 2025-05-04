<h2>Pesanan Masuk</h2>

@if (session('success'))
    <p style="color:green">{{ session('success') }}</p>
@endif

<table border="1" cellpadding="6">
    <thead>
        <tr>
            <th>Produk</th>
            <th>Nama Pembeli</th>
            <th>Email</th>
            <th>No HP</th>
            <th>Alamat</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($orders as $order)
        <tr>
            <td>{{ $order->product->name }}</td>
            <td>{{ $order->buyer_name }}</td>
            <td>{{ $order->buyer_email }}</td>
            <td>{{ $order->buyer_phone }}</td>
            <td>{{ $order->address }}</td>
            <td>{{ ucfirst($order->status) }}</td>
            <td>
                @if ($order->status === 'pending')
                <form action="{{ route('orders.approve', $order->id) }}" method="POST" style="display:inline">
                    @csrf
                    <button type="submit">Setujui</button>
                </form>
                <form action="{{ route('orders.reject', $order->id) }}" method="POST" style="display:inline">
                    @csrf
                    <button type="submit">Tolak</button>
                </form>
                @else
                <em>Tidak bisa diubah</em>
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
