
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Transaksi</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #000; padding: 5px; text-align: left; }
        th { background-color: #f0f0f0; }
    </style>
</head>
<body>
    <h2>Laporan Transaksi</h2>
    <table>
        <thead>
            <tr>
                <th>Penjual</th>
                <th>Produk</th>
                <th>Jumlah</th>
                <th>Harga Satuan</th>
                <th>Total</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
        @foreach($items as $item)
            <tr>
                <td>{{ $item->product->user->name ?? '-' }}</td>
                <td>{{ $item->product->name ?? '-' }}</td>
                <td>{{ $item->quantity }}</td>
                <td>Rp{{ number_format($item->product->price ?? 0, 0, ',', '.') }}</td>
                <td>Rp{{ number_format(($item->quantity * ($item->product->price ?? 0)), 0, ',', '.') }}</td>
                <td>{{ $item->created_at->format('d-m-Y') }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</body>
</html>
