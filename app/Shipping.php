<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Shipping extends Model
{
    protected $fillable = [
        'order_id',
        'address_id',
        'code',
        'service',
        'cost',
        'etd',
        'tracking_code',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function address()
    {
        return $this->belongsTo(Address::class);
    }

    public function courier()
    {
        return $this->belongsTo(Courier::class);
    }
}
