<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class TransactionsExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    protected $transactions;

    public function __construct($transactions)
    {
        $this->transactions = $transactions;
    }

    public function collection()
    {
        return $this->transactions;
    }

    public function headings(): array
    {
        return [
            'ID Transaksi',
            'Tanggal',
            'Nama Pelanggan',
            'Detail Produk',
            'Total Transaksi (Rp)',
            'Status Pembayaran'
        ];
    }

    public function map($transaction): array
    {
        $detailsArray = [];
        foreach ($transaction->details as $detail) {
            $productName = $detail->product?->name ?? 'Produk Terhapus';
            $detailsArray[] = "{$productName} ({$detail->quantity}x)";
        }
        $detailsText = implode(', ', $detailsArray);

        return [
            $transaction->id,
            $transaction->created_at->format('Y-m-d H:i:s'),
            $transaction->customer?->full_name ?? '-',
            $detailsText,
            number_format($transaction->grand_total, 2, ',', '.'),
            ucfirst($transaction->payment_status)
        ];
    }
}
