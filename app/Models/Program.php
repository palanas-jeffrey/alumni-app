<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    use HasFactory;

    protected $table = 'programs';

    // Specify the fields that are mass assignable
    protected $fillable = [
        'program_abbreviation',
        'program_name'
    ];
    
    public function users()
    {
        $this->hasMany(User::class);
    }
}