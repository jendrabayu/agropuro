<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    protected $fillable = ['province_id', 'name'];

    public function city()
    {
        return $this->hasMany(City::class);
    }
    public function cities()
    {
        return $this->hasMany(City::class, 'province_id', 'province_id');
    }
}
