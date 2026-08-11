<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountActivation extends Model
{
    use HasFactory;

    protected $table = 'account_activations'; // Specify the table name

    //protected $primaryKey = 'activation_id'; // Specify the primary key

    protected $fillable = [
        'user_id',
        'token',
        'created_at',
        'expired_at',
        'is_activated',
    ]; // Fields that are mass assignable

    public $timestamps = false; // Disable Laravel's default timestamps

    // Define the relationship with the User model
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
