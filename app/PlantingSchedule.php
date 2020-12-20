<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PlantingSchedule extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'slug',
        'information',
        'start_at',
        'end_at'
    ];

    protected $dates = [
        'start_at',
        'end_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function PlantingScheduleDetails()
    {
        return $this->hasMany(PlantingScheduleDetail::class);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
