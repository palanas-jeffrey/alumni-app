<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SurveySection extends Model
{
    protected $fillable = [
        'survey_section_title',
        'description',
        'order',
        'survey_form_id',
    ];

    public function forms()
    {
        return $this->belongsTo(SurveyForm::class, 'survey_form_id');
    }

    public function fields()
    {
        return $this->hasMany(SurveySectionField::class, 'section_id');
    }

    protected static function booted()
    {
        static::deleting(function ($section) {
            $section->fields()->delete();
        });
    }
}
