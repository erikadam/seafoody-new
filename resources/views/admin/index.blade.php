@extends('layouts.admin')

@section('content')
<div class="container py-4">
    <h2 class="text-2xl font-bold mb-4">Approval Transfer Pembayaran</h2>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if($orderItems->count() > 0)
        <div class="overflow-x-auto">
            <table class="table-auto w-full text-left bg-white shadow rounded-lg">
                <thead class="bg-gray-100 text-sm">
                    <tr>
                        <th class="px-4 py-2 border-b">Produk</th>
                        <th class="px-4 py-2 border-b">Pembeli</th>
                        <th class="px-4 py-2 border-b">Toko</th>
                        <th class="px-4 py-2 border-b">Bukti Transfer</th>
                        <th class="px-4 py-2 border-b">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orderItems as $item)
                        <tr class="border-t">
                            <td class="px-4 py-2">{{ $item->product->name }}</td>
                            <td class="px-4 py-2">
                                {{ $item->order->buyer_name }}<br>
                                <small>{{ $item->order->buyer_phone }}</small>
                            </td>
                            <td class="px-4 py-2">{{ $item->seller->name }}</td>
                            <td class="px-4 py-2">
                                @if($item->order->transfer_proof)
                                    <a href="{{ asset('storage/' . $item->order->transfer_proof) }}" target="_blank" class="text-blue-600 underline">Lihat Bukti</a>
                                @else
                                    <span class="text-gray-500">-</span>
                                @endif
                            </td>
                            <td class="px-4 py-2">
                                <form action="{{ route('admin.transfers.approve', $item->id) }}" method="POST" enctype="multipart/form-data" class="mb-2">
                                    @csrf
                                    <label class="block text-sm font-medium mb-1">Upload Bukti ke Seller</label>
                                    <input type="file" name="admin_transfer_proof" accept="image/*" class="form-input mb-2 text-sm" required>
                                    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded text-sm">Setujui</button>
                                </form>
                                <form action="{{ route('admin.transfers.reject', $item->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-sm">Tolak</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <p class="text-gray-600">Tidak ada pesanan yang menunggu approval saat ini.</p>
    @endif
</div>
@endsection
