<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Customer extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'last_consultation_at' => 'datetime',
    ];

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    public function chatHistories(): HasMany
    {
        return $this->hasMany(ChatHistory::class);
    }

    /**
     * Recalculate and save transaction statistics (count & total value).
     */
    public function recalculateTransactionStats(): void
    {
        $stats = $this->transactions()
            ->selectRaw('COUNT(*) as total_count, SUM(grand_total) as total_value')
            ->first();

        $hasPending = $this->transactions()->where('payment_status', 'pending')->exists();
        $hasPaid = $this->transactions()->where('payment_status', 'paid')->exists();

        $paymentStatus = 'Belum';
        if (! $hasPending && $hasPaid) {
            $paymentStatus = 'Lunas';
        }

        $this->update([
            'transaction_count' => $stats->total_count ?? 0,
            'total_transaction_value' => $stats->total_value ?? 0,
            'payment_status' => $paymentStatus,
        ]);

        $this->updateLeadScore();
    }

    /**
     * Otomatis mengkalkulasi Lead Score berdasarkan sistem pembobotan Poin
     */
    public function updateLeadScore(): void
    {
        // LOCK: Jangan ubah skor untuk 500 data pertama (Data Laporan Skripsi)
        if ($this->id <= 500) {
            return;
        }

        $chat = $this->total_chats_received ?? 0;
        $konsultasi = $this->consultation_frequency ?? 0;
        $transaksiCount = $this->transaction_count ?? 0;
        $webVisit = $this->web_visit_count ?? 0;

        $score = 0;

        // 1. Jumlah Chat (Max 30)
        if ($chat >= 12) {
            $score += 30;
        } elseif ($chat >= 8) {
            $score += 25;
        } elseif ($chat >= 4) {
            $score += 15;
        } else {
            $score += 5;
        }

        // 2. Frekuensi Konsultasi (Max 30)
        if ($konsultasi >= 6) {
            $score += 30;
        } elseif ($konsultasi >= 4) {
            $score += 25;
        } elseif ($konsultasi >= 2) {
            $score += 15;
        } else {
            $score += 5;
        }

        // 3. Riwayat Pembelian (Max 25)
        if ($transaksiCount > 0) {
            $score += 25;
        } else {
            $score += 0;
        }

        // 4. Respons / Kunjungan Website (Max 15)
        if ($webVisit >= 16) {
            $score += 15;
        } elseif ($webVisit >= 6) {
            $score += 10;
        } else {
            $score += 5;
        }

        // Penentuan Kategori berdasarkan Total Skor (Max 100)
        $status = 'Cold'; // Default: 0-40
        if ($score >= 71) {
            $status = 'Hot';
        } elseif ($score >= 41) {
            $status = 'Warm';
        }

        $this->update(['lead_score_status' => $status]);
    }
}
