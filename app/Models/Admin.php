<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable implements CanResetPassword
{
    use Notifiable;

    protected $guard = 'admin';
    protected $table = 'admins';

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password'
    ];

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

    public static function boot()
    {
        parent::boot();

        static::retrieved(function ($admin) {
            ResetPassword::createUrlUsing(function ($notifiable, string $token) {
                return url("/admin/reset-password/{$token}?email=" . urlencode($notifiable->getEmailForPasswordReset()));
            });
        });
    }


    public function profilePhoto()
    {
        return $this->hasOne(AdminProfilePhoto::class, 'admin_id');
    }
}

