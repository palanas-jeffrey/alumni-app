<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubmissionSchedule extends Model
{
    protected $table = 'submission_schedule';

    protected $fillable = [
        'date',
        'isDone',
        'note',
    ];
}

