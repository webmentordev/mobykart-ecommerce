<?php

namespace App\Models;

use App\Models\Brand;
use App\Models\Category;
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
}