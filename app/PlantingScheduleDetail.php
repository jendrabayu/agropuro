<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PlantingScheduleDetail extends Model
{
    protected $fillable = [
        'planting_schedule_id',
        'activity',
        'information',
        'date',
        'is_done'
    ];

    protected $dates = [
        'date',
    ];

    protected $casts = [
        'is_done' => 'boolean',
    ];

    public $timestamps = false;

    public function PlantingSchedule()
    {
        return $this->belongsTo(PlantingSchedule::class);
    }
}
