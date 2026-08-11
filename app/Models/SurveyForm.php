<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SurveyForm extends Model
{
    protected $fillable = [
        'title',
        'description',
        'is_published',
        'target_participants',
    ];

    public function sections()
    {
        return $this->hasMany(SurveySection::class, 'survey_form_id');
    }

    public function openPeriods()
    {
        return $this->hasMany(SurveyOpenPeriod::class, 'survey_form_id');
    }
}
