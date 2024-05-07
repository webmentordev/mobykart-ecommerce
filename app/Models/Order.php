<?php

namespace App\Models;

use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'product_id',
        'quantity',
        'price',
        'is_paid',
        'payment',
        'shipping',
        'order_id',
        'url',
        'transit_id',
        'logistics'
    ];
    
    public function product(){
        return $this->belongsTo(Product::class);
    }
}