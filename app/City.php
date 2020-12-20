<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $fillable = ['province_id', 'city_id', 'name'];

    public function province()
    {
        return $this->belongsTo(Province::class);
    }

    public function addresses()
    {
        return $this->hasMany(Address::class,);
    }
}
