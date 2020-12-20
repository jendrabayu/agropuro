<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    protected $fillable  = [
        'category_id',
        'nama',
        'slug',
        'deskripsi',
        'deskripsi_singkat',
        'gambar',
        'stok',
        'harga',
        'berat',
        'diarsipkan',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'diarsipkan' => 'boolean',
    ];

    protected $appends = [
        'sales'
    ];



    use SoftDeletes;

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class, 'product_id');
    }

    public function sales()
    {
        return $this->hasMany(OrderDetail::class)->whereHas('order', function (Builder $b) {
            $b->where('order_status_id', 5);
        })->sum('quantity');
    }

    public function getSalesAttribute()
    {
        return $this->orderDetails()->whereHas('order', function ($q) {
            $q->where('order_status_id', 5);
        })->sum('quantity');
    }

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    public function getImageUrl()
    {
    }
}
