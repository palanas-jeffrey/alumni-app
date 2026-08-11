<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'middle_name',
        'maiden_name',
        'date_of_birth',
        'gender',
        'civil_status',
        'program_id',
        'batch_year',
        'permanent_address',
        'current_address',
        'mobile_number',
        'email',
        'alumni_id',
        'password',
        'first_login'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    protected static function booted()
    {
        static::created(function ($user) {
            \DB::table('account_activations')->insert([
                'user_id' => $user->id,
                'token' => Str::random(100), 
                'expired_at' => now()->addDays(7),
                'is_activated' => false,
            ]);
        });
    }

    public function accountActivation()
    {
        return $this->hasOne(AccountActivation::class, 'user_id', 'id');
    }

    public function profilePhoto()
    {
        return $this->hasOne(ProfilePhoto::class);
    }

    public function monetaryDonations()
    {
        return $this->hasMany(DonationMonetary::class);
    }

    public function inKindDonations()
    {
        return $this->hasMany(DonationInKind::class);
    }

    public function facilityDonations()
    {
        return $this->hasMany(DonationFacility::class);
    }
    
    public function programTaken()
    {   
        return $this->belongsTo(Program::class, 'program_id');
    }   
}
