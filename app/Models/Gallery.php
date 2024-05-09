<?php

namespace App\Models;

use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Gallery extends Model
{
    use HasFactory;

    protected $fillable = [
        'image',
        'slug',
        'product_id',
        'is_active'
    ];
    
    public function product(){
        return $this->belongsTo(Product::class);
    }
}
