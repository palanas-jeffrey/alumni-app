<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventDate extends Model
{
    use HasFactory;

    protected $table = 'event_dates';

    protected $fillable = [
        'event_id',
        'event_date'
    ];

    public function event()
    {
        return $this->belongsTo(UAEvent::class, 'event_id');
    }
}