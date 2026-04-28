<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductVariant extends Model
{
    protected $table = 'ProductVariant';

    protected $primaryKey = 'variant_id';

    public $timestamps = false;

    protected $fillable = [
        'product_id',
        'size',
        'color',
        'stock',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id', 'product_id');
    }
}
