<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FormSection extends Model
{
    protected $fillable = [
        'question_section_title',
        'description',
        'order',
        'form_id',
    ];

    public function forms()
    {
        return $this->belongsTo(Form::class, 'form_id');
    }

    public function fields()
    {
        return $this->hasMany(FormSectionField::class, 'section_id');
    }

    protected static function booted()
    {
        static::deleting(function ($section) {
            $section->fields()->delete();
        });
    }
}
