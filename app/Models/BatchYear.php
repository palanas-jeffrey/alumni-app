<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BatchYear extends Model
{
    protected $table = 'batch_year'; 

    protected $fillable = [
        'batch_year',
    ];
}
