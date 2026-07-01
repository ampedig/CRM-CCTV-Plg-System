<?php

namespace App\Exports;

class TransactionsExport
{
    protected $transactions;

    public function __construct($transactions)
    {
        $this->transactions = $transactions;
    }

    /**
     * Transform collection into array of rows for FastExcel.
     */
    public function collection(): \Illuminate\Support\Collection
    {
        return $this->transactions->map(function ($transaction) {
            $detailsArray = [];
            foreach ($transaction->details as $detail) {
                $productName    = $detail->product?->name ?? 'Produk Terhapus';
                $detailsArray[] = "{$productName} ({$detail->quantity}x)";
            }

            return [
                'ID_Transaksi'         => $transaction->id,
                'Tanggal'              => $transaction->created_at->format('Y-m-d H:i:s'),
                'Nama_Pelanggan'       => $transaction->customer?->full_name ?? '-',
                'Detail_Produk'        => implode(', ', $detailsArray),
                'Total_Transaksi_(Rp)' => number_format($transaction->grand_total, 2, ',', '.'),
                'Status_Pembayaran'    => ucfirst($transaction->payment_status),
            ];
        });
    }
}
