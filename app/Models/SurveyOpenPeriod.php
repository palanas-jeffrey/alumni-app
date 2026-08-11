<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SurveyOpenPeriod extends Model
{
    protected $fillable = [
        'survey_form_id',
        'start_date',
        'end_date',
    ];

    protected $table = 'survey_open_periods';

    public function forms()
    {
        return $this->belongsTo(SurveyForm::class, 'survey_form_id');
    }
}
