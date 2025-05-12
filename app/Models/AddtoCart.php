<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AddtoCart extends Model
{
    protected $table = "add_to_cart";

    protected $fillable = [
        'productId',
        'productName',
        'category',
        'price',
        'stock',
        'quantity',
        'description',
        'image',
        'userId',
        'username',
    ];
}
