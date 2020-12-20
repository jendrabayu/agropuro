<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Address extends Model
{

    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'city_id',
        'name',
        'kecamatan',
        'kelurahan',
        'phone_number',
        'detail',
        'is_main'
    ];

    protected $casts = [
        'is_main' => 'boolean'
    ];

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id', 'city_id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
