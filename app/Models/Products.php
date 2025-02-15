<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    protected $table = 'products';

    protected $fillable = [
        'productId',
        'productName',
        'category',
        'price',
        'stock',
        'description',
        'image',
        'UserLoginID',
        'UserLoginName'
    ];
}
