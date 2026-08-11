<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SurveyResponse extends Model
{
    use HasFactory;

    protected $table = 'survey_responses';

    protected $fillable = [
        'survey_form_id',
        'user_id',
        'program_id',
        'batch_year',
        'survey_period_id'
    ];

    public function responseFields()
    {
        return $this->hasMany(SurveyResponseField::class, 'response_id');
    }

    public function form()
    {
        return $this->belongsTo(SurveyForm::class);
    }

    public function program()
    {
        return $this->belongsTo(Program::class, 'program_id');
    }

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }
}
