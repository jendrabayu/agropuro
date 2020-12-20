<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ForumCategory extends Model
{
    protected $fillable = [
        'name',
        'slug'
    ];

    public function forums()
    {
        return $this->hasMany(Forum::class);
    }
}
