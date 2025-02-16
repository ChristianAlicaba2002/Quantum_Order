<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArchiveProducts extends Model
{
    protected $table = "archive_products";
    protected $fillable = [
        'productId',
        'productName',
        'category',
        'price',
        'stock',
        'description',
        'image',
    ];
}
