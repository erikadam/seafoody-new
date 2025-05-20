
@extends('layouts.admin')

@section('content')
<div class="container">
    <h2 class="mb-4">Dashboard Admin</h2>

    @if (session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    <div class="row">
        <div class="col-md-4 mb-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Permintaan Penjual</h5>
                    <p class="card-text">{{ $pendingSellers }} pengguna</p>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-primary btn-sm">Lihat</a>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Produk Pending</h5>
                    <p class="card-text">{{ $pendingProducts }} produk</p>
                    <a href="{{ route('admin.products.pending') }}" class="btn btn-primary btn-sm">Lihat</a>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Transfer Masuk</h5>
                    <p class="card-text">{{ $pendingTransfers }} item</p>
                    <a href="{{ route('admin.transfers.index') }}" class="btn btn-primary btn-sm">Lihat</a>
                </div>
            </div>
        </div>
    </div>
    <div class="row mb-4">
        <div class="col-md-4">
            <canvas id="weeklyChart"></canvas>
        </div>
        <div class="col-md-4">
            <canvas id="monthlyChart"></canvas>
        </div>
        <div class="col-md-4">
            <canvas id="yearlyChart"></canvas>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const weeklyCtx = document.getElementById('weeklyChart');
        const monthlyCtx = document.getElementById('monthlyChart');
        const yearlyCtx = document.getElementById('yearlyChart');

        new Chart(weeklyCtx, {
            type: 'pie',
            data: {
                labels: ['Transfer', 'COD'],
                datasets: [{
                    label: 'Transaksi Minggu Ini',
                    data: [{{ $weekly['transfer'] }}, {{ $weekly['cod'] }}],
                    backgroundColor: ['#0d6efd', '#ffc107']
                }]
            }
        });

        new Chart(monthlyCtx, {
            type: 'pie',
            data: {
                labels: ['Transfer', 'COD'],
                datasets: [{
                    label: 'Transaksi Bulan Ini',
                    data: [{{ $monthly['transfer'] }}, {{ $monthly['cod'] }}],
                    backgroundColor: ['#198754', '#fd7e14']
                }]
            }
        });

        new Chart(yearlyCtx, {
            type: 'pie',
            data: {
                labels: ['Transfer', 'COD'],
                datasets: [{
                    label: 'Transaksi Tahun Ini',
                    data: [{{ $yearly['transfer'] }}, {{ $yearly['cod'] }}],
                    backgroundColor: ['#6f42c1', '#20c997']
                }]
            }
        });
    </script>
     <div class="mb-3">
        <a href="{{ route('admin.reports.pdf') }}" class="btn btn-danger btn-sm me-2">
            <i class="fa fa-file-pdf-o"></i> Download PDF
        </a>
        <a href="{{ route('admin.reports.excel') }}" class="btn btn-success btn-sm">
            <i class="fa fa-file-excel-o"></i> Download Excel
        </a>
    </div>
</div>
@endsection
