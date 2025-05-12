<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CheckOut extends Model
{
    protected $table = "check_out_items";
    protected $fillable = [
     'productId',
     'productName',
     'category',
     'stock',
     'totalPrice',
     'userId',
     'firstName',
     'address',
     'phoneNumber',
    ];
}
