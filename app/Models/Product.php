<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'is_active' => 'boolean',
        'price' => 'decimal:2',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    protected static function booted(): void
    {
        // Update count saat produk baru dibuat
        static::created(function (Product $product) {
            if ($product->category_id) {
                $product->category->increment('count');
            }
        });

        // Update count saat kategori produk diubah
        static::updated(function (Product $product) {
            if ($product->wasChanged('category_id')) {
                // Kurangi count kategori lama
                if ($oldCategoryId = $product->getOriginal('category_id')) {
                    Category::find($oldCategoryId)?->decrement('count');
                }
                
                // Tambah count kategori baru
                if ($product->category_id) {
                    $product->category->increment('count');
                }
            }
        });

        // Update count saat produk dihapus
        static::deleted(function (Product $product) {
            if ($product->category_id) {
                $product->category->decrement('count');
            }
        });
    }
}
