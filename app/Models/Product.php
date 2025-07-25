<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'products';
    protected $fillable = [
        'product_name',
        'price',
        'quantity',
        'warranty',
        'description'
    ];
}
