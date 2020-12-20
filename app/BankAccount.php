<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BankAccount extends Model
{
    protected $fillable = ['nama_bank', 'atas_nama', 'no_rekening'];

    use SoftDeletes;

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
