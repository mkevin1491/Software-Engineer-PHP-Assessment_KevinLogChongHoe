<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'short_description',
        'full_description',
        'specs',
        'category',
        'brand',
        'model_no',
        'warranty',
        'price',
        'image',
    ];

    protected $casts = [
        'specs' => 'array',
    ];


    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }
}
