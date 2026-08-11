<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DonationInKind extends Model
{
    use HasFactory;
    
    protected $table = 'donation_in_kind';

    protected $fillable = [
        'user_id', 
        'item_name', 
        'quantity', 
        'unit',
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
