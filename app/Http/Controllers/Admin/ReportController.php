<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\TransactionExport;

class ReportController extends Controller
{
    public function exportPdf()
    {
        $items = OrderItem::with(['product.user'])->get();

        $pdf = Pdf::loadView('admin.reports.pdf', compact('items'));

        return $pdf->download('laporan-transaksi.pdf');
    }

    public function exportExcel()
    {
        return Excel::download(new TransactionExport, 'laporan-transaksi.xlsx');
    }
}
