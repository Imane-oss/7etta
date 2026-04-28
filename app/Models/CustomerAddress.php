<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CustomerAddress extends Model
{
    protected $table = 'CustomerAddress';

    protected $primaryKey = 'address_id';

    public $timestamps = false;

    protected $fillable = [
        'customer_id',
        'street',
        'city',
        'zip',
        'country_id',
        'country_name',
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'customer_id');
    }
}
