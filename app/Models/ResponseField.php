<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResponseField extends Model
{
    use HasFactory;

    // Define the table name (optional)
    protected $table = 'response_fields';

    // Specify which attributes can be mass-assigned
    protected $fillable = ['response_id', 'field_id', 'value', 'section_id'];

    // Define the relationship with the Response model
    public function response()
    {
        return $this->belongsTo(Response::class, 'response_id');
    }

    // Define the relationship with the Field model
    public function field()
    {
        return $this->belongsTo(FormSectionField::class, 'field_id');
    }
}