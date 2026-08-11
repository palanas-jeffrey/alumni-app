<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UAEvent extends Model
{
    use HasFactory;

    protected $table = 'ua_events';

    protected $fillable = [
        'event_name',
        'description',
        'start_time',
        // 'duration',
        'venue',
    ];

    

    /**
     * Relationship with EventPhoto
     * A UAEvent can have multiple associated photo.
     */
    public function photo()
    {
        return $this->hasOne(EventPhoto::class, 'alumni_event_id');
    }

    public function eventDates()
    {
        return $this->hasMany(EventDate::class, 'event_id');
    }
}