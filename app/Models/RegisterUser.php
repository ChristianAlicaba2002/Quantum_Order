<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;


class RegisterUser extends Authenticatable
{
    use HasFactory , Notifiable ,HasApiTokens;
    

    protected $table = 'register_user';

    protected $fillable = [
        'userId',
        'firstName',
        'lastName',
        'gender',
        'address',
        'contactNumber',
        'username',
        'password'
    ];

    protected $guard = 'register';

}
