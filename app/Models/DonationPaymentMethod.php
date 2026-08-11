<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DonationPaymentMethod extends Model
{
    use HasFactory;

    protected $table = 'donation_payment_methods';

    // Specify the fields that are mass assignable
    protected $fillable = [
        'method_name',
        'description'
    ];
}