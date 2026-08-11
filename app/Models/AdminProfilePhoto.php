<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminProfilePhoto extends Model
{
    protected $table = 'admin_profile_photo';

    protected $fillable = [
        'admin_id',
        'photo_path'
    ];

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }
}