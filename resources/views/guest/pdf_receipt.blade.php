<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Nota Pesanan Diterima</title>
  <style>
    body { font-family: sans-serif; font-size: 12px; color: #222; }
    table { width: 100%; border-collapse: collapse; margin-top: 20px; }
    th, td { border: 1px solid #ccc; padding: 6px 8px; text-align: left; }
    th { background: #f0f0f0; }
    h2, h4 { margin: 0; padding: 0; }
    .header { margin-bottom: 20px; }
    .status-box {
      padding: 8px;
      border: 2px dashed green;
      background: #eaffea;
      text-align: center;
      font-weight: bold;
      margin-top: 10px;
      color: #2b662b;
    }
    .info { margin-bottom: 10px; }
  </style>
</head>
<body>
  <div class="header">
    <h2>Nota Pesanan (Telah Diterima)</h2>
    <p><strong>ID Pesanan:</strong> #{{ $order->id }} &nbsp; | &nbsp; <strong>Tanggal Cetak:</strong> {{ now()->format('d M Y H:i') }}</p>
  </div>

  <div class="status-box">✅ PESANAN TELAH DITERIMA OLEH PEMBELI</div>

  <div class="info">
    <h4>Detail Pembeli</h4>
    <p><strong>Nama:</strong> {{ $order->buyer_name }}</p>
    <p><strong>No. HP:</strong> {{ $order->buyer_phone }}</p>
    <p><strong>Alamat:</strong> {{ $order->buyer_address }}</p>
    <p><strong>Metode Pembayaran:</strong> {{ ucfirst($order->payment_method) }}</p>
    <p><strong>Status Pesanan:</strong> {{ ucwords(str_replace('_', ' ', $order->status)) }}</p>
  </div>

  <table>
    <thead>
      <tr>
        <th>Produk</th>
        <th>Total Harga</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>{{ $order->product_list }}</td>
        <td>Rp{{ number_format($order->total_price, 0, ',', '.') }}</td>
      </tr>
    </tbody>
  </table>

  <p style="margin-top: 30px; text-align: center;">Terima kasih telah berbelanja di toko kami.</p>
</body>
</html>
