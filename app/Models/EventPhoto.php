<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventPhoto extends Model
{
    protected $table = 'event_photos';

    protected $fillable = [
        'alumni_event_id',
        'photo_path',
        'image_type',
    ];

    /**
     * Inverse Relationship to UAEvent
     * An EventPhoto belongs to one UAEvent.
     */
    public function uaEvent()
    {
        return $this->belongsTo(UAEvent::class, 'alumni_event_id');
    }
}