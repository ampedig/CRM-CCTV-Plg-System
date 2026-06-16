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
    }
}
