<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductTag;
use App\Models\Tag;
use Illuminate\Http\Request;

class ProductTagController extends Controller
{
    // List all tags
    public function index()
    {
        return view('dashboard.tags.relation', [
            'tags' => Tag::latest()->get(),
            'ptags' => ProductTag::latest()->get(),
            'products' => Product::latest()->get()
        ]);
    }

    // Random slug generator
    function randomSlug() {
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $pass = array();
        $alphaLength = strlen($alphabet) - 1;
        for ($i = 0; $i < 30; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass);
    }

    // To create new tag
    public function store(Request $request)
    {
        $request->validate([
            'tag' => ['required', 'numeric'],
            'product' => ['required', 'numeric']
        ]);
        $product = ProductTag::where('tag_id', $request->tag)
                        ->where('product_id', $request->product)
                        ->first();
        if($product){
            return back()->withErrors(['tag' => 'Tag for product already exist!']);
        }
        ProductTag::create([
            'tag_id' => $request->tag,
            'product_id' => $request->product,
            'slug' => $this->randomSlug()
        ]);
        return back()->with('success', 'Tag relation has been created!');
    }

    // To delete tag
    public function delete(ProductTag $tag)
    {
        $tag->delete();
        return back()->with('success', 'Tag relation has been deleted!');
    }
}