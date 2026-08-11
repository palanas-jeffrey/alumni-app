<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Form extends Model
{
    protected $fillable = [
        'title',
        'description',
        'course',
        'batch_year',
        'publish_year'
    ];

    public function sections()
    {
        return $this->hasMany(FormSection::class, 'form_id');
    }

    // public function fields()
    // {
    //     return $this->hasMany(Field::class);
    // }

    public function responses()
    {
        return $this->hasMany(Response::class);
    }

    public function formPublishes()
    {
        return $this->hasMany(FormPublish::class, 'form_id');
    }
}
