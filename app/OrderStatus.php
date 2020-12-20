<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderStatus extends Model
{

    protected $fillable = ['code', 'status_admin', 'status_user', 'color'];

    public function orders()
    {
        return $this->hasMany(Order::class, 'order_status_id', 'id');
    }
}
