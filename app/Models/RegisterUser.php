<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;


class RegisterUser extends Authenticatable
{
    use HasFactory , Notifiable , HasApiTokens;

    protected $guard = 'register_user';

    protected $table = 'register_user';

    protected $fillable = [
        'userId',
        'firstName',
        'lastName',
        'gender',
        'address',
        'PhoneNumber',
        'username',
        'password'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }


}
