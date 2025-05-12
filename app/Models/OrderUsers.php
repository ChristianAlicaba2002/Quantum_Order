<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderUsers extends Model
{
    protected $table = "order_users";
    protected $fillable = [
        'productId',
        'productName',
        'price',
        'quantity',
        'category',
        'payment',
        'description',
        'image',
        'userIdLogin',
        'userNameLogin',
        'userAddress',
        'userPhoneNumber'
    ];
}
