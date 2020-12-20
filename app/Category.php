<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Category extends Model
{
    protected $fillable = ['name', 'slug', 'image', 'updated_at'];

    use SoftDeletes;

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    protected static function boot()
    {
        parent::boot();
        static::deleting(function ($categories) {
            foreach ($categories->products()->get() as $product) {
                $product->delete();
            }
        });
    }
}
