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
     * Otomatis mengkalkulasi Lead Score berdasarkan Aktivitas & Nilai Transaksi
     */
    public function updateLeadScore(): void
    {
        $transaksi = $this->total_transaction_value ?? 0;
        $chat = $this->total_chats_received ?? 0;
        $web = $this->web_visit_count ?? 0;

        $score = 'Cold'; // Default

        // HOT: Transaksi super besar (>= 10 Juta) ATAU Transaksi lumayan besar (>= 5 Juta) + Aktif interaksi
        if ($transaksi >= 10000000) {
            $score = 'Hot';
        } elseif ($transaksi >= 5000000 && ($chat >= 15 || $web >= 10)) {
            $score = 'Hot';
        } 
        // WARM: Transaksi menengah (>= 2 Juta) ATAU sering tanya-tanya walau belum beli
        elseif ($transaksi >= 2000000 || $chat >= 15 || $web >= 10) {
            $score = 'Warm';
        }

        $this->update(['lead_score_status' => $score]);
    }
}
