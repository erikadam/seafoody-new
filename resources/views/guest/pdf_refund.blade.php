<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Dokumentasi Refund</title>
  <style>
    body { font-family: sans-serif; font-size: 14px; }
    .title { font-size: 20px; font-weight: bold; margin-bottom: 10px; }
    table { width: 100%; border-collapse: collapse; margin-top: 15px; }
    th, td { border: 1px solid #000; padding: 8px; text-align: left; }
    th { background: #eee; }
  </style>
</head>
<body>
  <div class="title">DOKUMENTASI REFUND</div>
  <p><strong>Produk:</strong> {{ $orderItem->product->name }}</p>
  <p><strong>Jumlah:</strong> {{ $orderItem->quantity }}</p>
  <p><strong>Total:</strong> Rp {{ number_format($orderItem->price * $orderItem->quantity, 0, ',', '.') }}</p>
  <p><strong>Status:</strong> Refund Disetujui</p>
  <p><strong>Penjual:</strong> {{ $sellerName }}</p>
</body>
</html>
