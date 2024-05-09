<?php

namespace App\Models;

use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Discount extends Model
{
    use HasFactory;

    protected $fillable = [
        'discount',
        'slug',
        'product_id'
    ];

    public function product(){
        return $this->belongsTo(Product::class);
    }
}
