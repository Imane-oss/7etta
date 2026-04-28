<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShippingMethod extends Model
{
    protected $table = 'ShippingMethod';

    protected $primaryKey = 'method_id';

    public $timestamps = false;

    protected $fillable = [
        'method_name',
        'cost',
    ];

    protected function casts(): array
    {
        return [
            'cost' => 'decimal:2',
        ];
    }
}
