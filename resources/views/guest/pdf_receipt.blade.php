<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Nota Pembelian</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; }
        .title { font-size: 18px; font-weight: bold; }
        .info, .items { width: 100%; margin-bottom: 20px; }
        .info td { padding: 4px 0; }
        .items th, .items td { border: 1px solid #000; padding: 6px; text-align: left; }
        .items { border-collapse: collapse; }
        .right { text-align: right; }
    </style>
</head>
<body>
    <div class="header">
        <div class="title">Nota Pembelian</div>
        <div>Toko: {{ $sellerName }}</div>
    </div>

    <table class="info">
        <tr>
            <td><strong>Pembeli:</strong> {{ $orderItem->order->buyer_name }}</td>
            <td><strong>Telepon:</strong> {{ $orderItem->order->buyer_phone }}</td>
        </tr>
        <tr>
            <td><strong>Alamat:</strong> {{ $orderItem->order->buyer_address }}</td>
            <td><strong>Metode Pembayaran:</strong> {{ ucfirst($orderItem->order->payment_method) }}</td>
        </tr>
        <tr>
            <td colspan="2"><strong>Tanggal:</strong> {{ $orderItem->updated_at->format('d M Y') }}</td>
        </tr>
    </table>

    <table class="items">
        <thead>
            <tr>
                <th>Produk</th>
                <th>Jumlah</th>
                <th>Harga Satuan</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $orderItem->product->name }}</td>
                <td>{{ $orderItem->quantity }}</td>
                <td>Rp{{ number_format($orderItem->price, 0, ',', '.') }}</td>
                <td>Rp{{ number_format($orderItem->price * $orderItem->quantity, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    <p class="right"><strong>Total Bayar:</strong> Rp{{ number_format($orderItem->price * $orderItem->quantity, 0, ',', '.') }}</p>
</body>
</html>
