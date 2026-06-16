<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Transaction extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'grand_total' => 'decimal:2',
    ];

    protected static function booted()
    {
        static::saved(function ($transaction) {
            $transaction->customer?->recalculateTransactionStats();

            // If customer_id changed, recalculate for the old customer as well
            if ($transaction->wasChanged('customer_id')) {
                $oldCustomerId = $transaction->getOriginal('customer_id');
                if ($oldCustomerId) {
                    $oldCustomer = Customer::find($oldCustomerId);
                    $oldCustomer?->recalculateTransactionStats();
                }
            }
        });

        static::deleted(function ($transaction) {
            $transaction->customer?->recalculateTransactionStats();
        });
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function details(): HasMany
    {
        return $this->hasMany(TransactionDetail::class);
    }
}
