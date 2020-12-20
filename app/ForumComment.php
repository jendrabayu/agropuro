<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ForumComment extends Model
{
    protected $fillable = [
        'user_id',
        'forum_id',
        'forum_comment_id',
        'body',
        'is_answer'
    ];

    protected $casts = [
        'is_answer' => 'boolean'
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function forum()
    {
        return $this->belongsTo(Forum::class, 'forum_id', 'id');
    }

    public function parent()
    {
        return $this->belongsTo(self::class);
    }

    public function child()
    {
        return $this->hasMany(self::class, 'forum_comment_id', 'id');
    }

    public function countAnswerComment()
    {
    }
}
