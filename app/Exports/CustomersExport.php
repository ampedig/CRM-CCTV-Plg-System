<?php

namespace App\Exports;

use Carbon\Carbon;

class CustomersExport
{
    protected $customers;

    public function __construct($customers)
    {
        $this->customers = $customers;
    }

    /**
     * Transform collection into array of rows for FastExcel.
     * FastExcel accepts a Collection or Generator; we map each customer to a flat array.
     */
    public function collection(): \Illuminate\Support\Collection
    {
        $counter = 1;
        return $this->customers->map(function ($customer) use (&$counter) {
            $age = $customer->date_of_birth
                ? Carbon::parse($customer->date_of_birth)->age
                : '-';

            return [
                'ID_Pelanggan'          => $counter++,
                'Tahun'                 => $customer->created_at ? $customer->created_at->format('Y') : '-',
                'Umur'                  => $age,
                'Pekerjaan'             => $customer->occupation ?? '-',
                'Jumlah_Chat'           => $customer->total_chats_received,
                'Frekuensi_Konsultasi'  => $customer->consultation_frequency,
                'Kunjungan_Website'     => $customer->web_visit_count,
                'Nilai_Transaksi'       => (int) $customer->total_transaction_value,
                'Frekuensi_Pembelian'   => $customer->transaction_count,
                'Produk_Diminati'       => $customer->last_product_interest ?? '-',
                'Status_Pembayaran'     => $customer->payment_status,
            ];
        });
    }
}
