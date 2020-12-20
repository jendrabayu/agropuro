<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ShopAddress extends Model
{
    protected $table =  'shop_address';
    protected $fillable = ['city_id', 'kecamatan', 'kelurahan', 'phone_number', 'detail'];

    public function city()
    {
        return $this->hasOne(City::class, 'city_id', 'city_id');
    }
}
