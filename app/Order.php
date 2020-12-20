<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{

    protected $guarded = [];

    use SoftDeletes;


    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }

    public function orderStatus()
    {
        return $this->belongsTo(OrderStatus::class,);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function bankAccount()
    {
        return $this->belongsTo(BankAccount::class)->withTrashed();
    }

    public function address()
    {
        return $this->belongsTo(Address::class)->withTrashed();
    }

    public function shipping()
    {
        return $this->hasOne(Shipping::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }
}
