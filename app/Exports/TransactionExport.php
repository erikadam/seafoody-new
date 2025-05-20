<?php

namespace App\Exports;

use App\Models\OrderItem;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class TransactionExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return OrderItem::with(['product.user'])->get();
    }

    public function headings(): array
    {
        return [
            'Penjual',
            'Produk',
            'Jumlah',
            'Harga Satuan',
            'Total',
            'Tanggal',
        ];
    }

    public function map($item): array
    {
        $price = $item->product->price ?? 0;
        $total = $item->quantity * $price;

        return [
            $item->product->user->name ?? '-',
            $item->product->name ?? '-',
            $item->quantity,
            $price,
            $total,
            $item->created_at->format('d-m-Y'),
        ];
    }
}
