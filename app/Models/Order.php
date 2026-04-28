<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    protected $table = 'Orders';

    protected $primaryKey = 'order_id';

    public $timestamps = false;

    protected $fillable = [
        'customer_id',
        'total_amount',
        'status',
        'shipping_address',
        'payment_method',
        'order_date',
    ];

    protected function casts(): array
    {
        return [
            'total_amount' => 'decimal:2',
            'order_date' => 'datetime',
        ];
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'customer_id');
    }

    public function lines(): HasMany
    {
        return $this->hasMany(OrderLine::class, 'order_id', 'order_id');
    }
}
