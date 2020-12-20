<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderDetail extends Model
{
    protected $fillable = ['order_id', 'product_id', 'price', 'quantity'];

    use SoftDeletes;

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id')->withTrashed();
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'id',);
    }
}
