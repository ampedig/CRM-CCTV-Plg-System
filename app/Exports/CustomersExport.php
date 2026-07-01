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
        return $this->customers->map(function ($customer) {
            $age = $customer->date_of_birth
                ? Carbon::parse($customer->date_of_birth)->age
                : '-';

            return [
                'ID_Pelanggan'          => $customer->id,
                'Nama'                  => $customer->full_name,
                'Umur'                  => $age,
                'Pekerjaan'             => $customer->occupation ?? '-',
                'Jumlah_Chat'           => $customer->total_chats_received,
                'Frekuensi_Konsultasi'  => $customer->consultation_frequency,
                'Kunjungan_Website'     => $customer->web_visit_count,
                'Nilai_Transaksi'       => number_format($customer->total_transaction_value, 2, ',', '.'),
                'Frekuensi_Pembelian'   => $customer->transaction_count,
                'Produk_Diminati'       => $customer->last_product_interest ?? '-',
                'Status_Pembayaran'     => $customer->payment_status,
                'Lead_Scoring'          => ucfirst($customer->lead_score_status ?? 'Cold'),
            ];
        });
    }
}
