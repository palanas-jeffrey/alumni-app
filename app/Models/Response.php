<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Response extends Model
{
    use HasFactory;

    protected $table = 'responses';

    protected $fillable = [
        'form_id',
        'user_id',
        'program_id',
        'batch_year',
    ];

    public function responseFields()
    {
        return $this->hasMany(ResponseField::class);
    }

    public function form()
    {
        return $this->belongsTo(Form::class);
    }

    public function program()
    {
        return $this->belongsTo(Program::class, 'program_id');
    }

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }
}
