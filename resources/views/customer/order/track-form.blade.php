<h2>Cek Riwayat Pesanan</h2>
<form method="POST" action="{{ route('orders.track') }}">
    @csrf
    <label>Email Pemesan:</label><br>
    <input type="email" name="email" required><br><br>
    <button type="submit">Lihat Pesanan</button>
</form>
