<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\database\Eloquent\Factories\HasFactory;


class Order extends Model
{
    use HasFactory;

    protected $fillable = ['product_id', 'quantity', 'status'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
