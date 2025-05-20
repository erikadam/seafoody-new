@extends('layouts.customer')

@section('content')
<div class="container py-4">
    <h2 class="text-2xl font-bold mb-4">Manajemen Pesanan</h2>

    @if($orderItems->count() > 0)
        <table class="table-auto w-full text-left bg-white shadow rounded-lg">
            <thead class="bg-gray-100 text-sm">
                <tr>
                    <th class="px-4 py-2 border-b">Produk</th>
                    <th class="px-4 py-2 border-b">Qty</th>
                    <th class="px-4 py-2 border-b">Harga</th>
                    <th class="px-4 py-2 border-b">Pembeli</th>
                    <th class="px-4 py-2 border-b">Metode</th>
                    <th class="px-4 py-2 border-b">Status</th>
                    <th class="px-4 py-2 border-b">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orderItems as $item)
                    <tr class="border-t hover:bg-gray-50">
                        <td class="px-4 py-2">{{ $item->product->name }}</td>
                        <td class="px-4 py-2">{{ $item->quantity }}</td>
                        <td class="px-4 py-2">Rp{{ number_format($item->price, 0, ',', '.') }}</td>
                        <td class="px-4 py-2">
                            {{ $item->order->buyer_name }}<br>
                            <small>{{ $item->order->buyer_phone }}</small>
                        </td>
                        <td class="px-4 py-2 capitalize">{{ $item->order->payment_method }}</td>
                        <td class="px-4 py-2 capitalize">{{ str_replace('_', ' ', $item->status) }}</td>
                        <td class="px-4 py-2">
                            @if($item->status === 'accepted_by_admin')
                                <form action="{{ route('customer.orders.updateStatus', $item->id) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="status" value="in_process_by_customer">
                                    <button class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-sm">Siapkan</button>
                                </form>
                            @elseif($item->status === 'in_process_by_customer')
                                <form action="{{ route('customer.orders.updateStatus', $item->id) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="status" value="shipped_by_customer">
                                    <button class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded text-sm">Kirim</button>
                                </form>
                            @elseif($item->status === 'shipped_by_customer')
                                <span class="text-gray-500 text-sm">Menunggu Konfirmasi Pembeli</span>
                            @elseif($item->status === 'completed')
                                <span class="text-green-600 font-semibold text-sm">Selesai</span>
                            @elseif($item->status === 'waiting_admin_confirmation')
                                <span class="text-yellow-600 text-sm">Menunggu Admin</span>
                            @else
                                <span class="text-red-500 text-sm">Status: {{ $item->status }}</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p class="text-gray-600">Belum ada pesanan yang dapat ditampilkan.</p>
    @endif
</div>
@endsection
