<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Forum extends Model
{
    protected $fillable = [
        'user_id',
        'forum_category_id',
        'title',
        'slug',
        'body',
        'is_solved'
    ];

    protected $casts = [
        'is_solved' => 'boolean',
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(ForumCategory::class, 'forum_category_id', 'id');
    }

    public function forumCategory()
    {
        return $this->belongsTo(ForumCategory::class, 'forum_category_id', 'id');
    }

    public function forumComments()
    {
        return $this->hasMany(ForumComment::class, 'forum_id', 'id');
    }
}
