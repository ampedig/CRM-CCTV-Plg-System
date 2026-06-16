<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class CustomersExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    protected $customers;

    public function __construct($customers)
    {
        $this->customers = $customers;
    }

    public function collection()
    {
        return $this->customers;
    }

    public function headings(): array
    {
        return [
            'ID_Pelanggan',
            'Nama',
            'Umur',
            'Pekerjaan',
            'Jumlah_Chat',
            'Frekuensi_Konsultasi',
            'Kunjungan_Website',
            'Nilai_Transaksi',
            'Frekuensi_Pembelian',
            'Produk_Diminati',
            'Status_Pembayaran',
            'Lead_Scoring'
        ];
    }

    public function map($customer): array
    {
        $age = $customer->date_of_birth ? \Carbon\Carbon::parse($customer->date_of_birth)->age : '-';

        return [
            $customer->id,
            $customer->full_name,
            $age,
            $customer->occupation ?? '-',
            $customer->total_chats_received,
            $customer->consultation_frequency,
            $customer->web_visit_count,
            number_format($customer->total_transaction_value, 2, ',', '.'),
            $customer->transaction_count,
            $customer->last_product_interest ?? '-',
            $customer->payment_status,
            ucfirst($customer->lead_score_status ?? 'Cold')
        ];
    }
}
