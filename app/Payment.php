<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'order_id',
        'bank_account_id',
        'payment_proof',
        'name',
        'bank',
        'account_number',
        'confirmed_at',
    ];

    protected $dates = [
        'confirmed_at',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function bankAccount()
    {
        return $this->belongsTo(BankAccount::class);
    }
}
