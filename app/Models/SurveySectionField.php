<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SurveySectionField extends Model
{
    protected $table = 'survey_section_fields';

    protected $fillable = [
        'field_label',
        'type',
        'choices',
        'required',
        'order',
        'section_id'
    ];

    public function section()
    {
        return $this->belongsTo(SurveyForm::class, 'section_id');
    }

    public function fieldResponse()
    {
        return $this->hasMany(SurveyResponseField::class, 'field_id');
    }
}
