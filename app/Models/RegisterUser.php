<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RegisterUser extends Model
{
    protected $table = 'register_user';
    protected $fillable = [
        'userId',
        'firstName',
        'lastName',
        'address',
        'contactNumber',
        'username',
        'password'
    ];
}
