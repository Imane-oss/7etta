<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Product extends Model
{
    protected $table = 'Product';

    protected $primaryKey = 'product_id';

    public $timestamps = false;

    protected $fillable = [
        'name_product',
        'slug',
        'description',
        'price',
        'stock_quantity',
        'category_id',
        'color',
        'size',
        'image_url',
        'image_hover_url',
        'created_at',
        'updated_at',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    /**
     * Use slug for route model binding.
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * Auto-generate slug when creating a product.
     */
    protected static function booted(): void
    {
        static::creating(function (Product $product) {
            if (empty($product->slug)) {
                $product->slug = Str::slug($product->name_product) . '-' . uniqid();
            }
        });
    }

    /**
     * Get available sizes as an array.
     */
    public function getAvailableSizesAttribute(): array
    {
        if (empty($this->size)) {
            return [];
        }

        return array_map('trim', explode(',', $this->size));
    }

    /**
     * Get available colors as an array.
     */
    public function getAvailableColorsAttribute(): array
    {
        if (empty($this->color)) {
            return [];
        }

        return array_map('trim', explode(',', $this->color));
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id', 'category_id');
    }

    public function variants(): HasMany
    {
        return $this->hasMany(ProductVariant::class, 'product_id', 'product_id');
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(ProductReview::class, 'product_id', 'product_id');
    }
}
