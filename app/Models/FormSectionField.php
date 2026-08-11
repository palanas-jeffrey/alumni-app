<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FormSectionField extends Model
{
    protected $fillable = [
        'field_label',
        'type',
        'choices',
        'required',
        'order',
        'section_id',
    ];

    public function section()
    {
        return $this->belongsTo(FormSection::class, 'section_id');
    }

    public function fieldResponse()
    {
        return $this->hasMany(ResponseField::class, 'field_id');
    }
}
