<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class AdminAccessKey extends Model
{
    protected $table = 'admin_access_key';
    protected $fillable = ['admin_access_key'];

    public function setAdminAccessKeyAttribute($value)
    {
        $this->attributes['admin_access_key'] = Hash::make($value);
    }
}

