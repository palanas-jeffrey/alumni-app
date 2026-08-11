<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SurveyResponseField extends Model
{
    use HasFactory;

    // Define the table name (optional)
    protected $table = 'survey_response_fields';

    // Specify which attributes can be mass-assigned
    protected $fillable = ['response_id', 'field_id', 'value', 'section_id'];

    public function response()
    {
        return $this->belongsTo(SurveyResponse::class, 'response_id');
    }

    public function field()
    {
        return $this->belongsTo(SurveySectionField::class, 'field_id');
    }
}