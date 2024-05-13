<?php

namespace App\Models;

use App\Models\Brand;
use App\Models\Order;
use App\Models\Gallery;
use App\Models\Category;
use App\Models\Discount;
use App\Models\ProductTag;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'stripe_id',
        'slug',
        'body',
        'description',
        'seo',
        'price',
        'image',
        'brand_id',
        'category_id',
        'is_active',
        'is_featured'
    ];

    public function brand(){
        return $this->belongsTo(Brand::class);
    }
    
    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function tags(){
        return $this->hasMany(ProductTag::class);
    }

    public function gallery(){
        return $this->hasMany(Gallery::class);
    }

    public function discount(){
        return $this->hasOne(Discount::class);
    }

    public function orders(){
        return $this->hasMany(Order::class);
    }
}