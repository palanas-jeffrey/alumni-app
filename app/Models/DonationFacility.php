<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DonationFacility extends Model
{
    protected $table = 'donation_facilities';

    protected $fillable = [
        'user_id', 
        'facility', 
        'description',
        'status_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function status()
    {
        return $this->belongsTo(DonationStatus::class);
    }
}
