<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Product;
use App\Models\Category;
use Stripe\StripeClient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    // List all products
    public function index(){
        return view('dashboard.products.index', [
            'products' => Product::latest()
                ->with(['brand', 'category', 'tags', 'discount', 'gallery'])
                ->withCount(['tags', 'gallery'])->paginate(100)
        ]);
    }

    // Create product
    public function create(){
        return view('dashboard.products.create', [
            'brands' => Brand::latest()->get(),
            'categories' => Category::latest()->get()
        ]);
    }
    public function store(Request $request){
        $request->validate([
            'title' => ['required', 'max:255', 'string'],
            'price' => ['required', 'min:1', 'numeric'],
            'brand' => ['required', 'numeric'],
            'category' => ['required', 'numeric'],
            'description' => ['required', 'max:255'],
            'seo' => ['required', 'max:255'],
            'body' => ['required'],
            'image' => ['required', 'image', 'max:2500', 'mimes:png,jpg,webp,jpeg']
        ]);
        $slug = str_replace(' ', '-', strtolower($request->title)).'-'.rand(1, 9999999999);
        $image = $request->image->storeAs('products', $slug.'-thumb.'.$request->image->getClientOriginalExtension());
        $stripe = new StripeClient(config('app.stripe'));
        $product = $stripe->products->create(['name' => $request->title, 'images' => [ config('app.url').'/storage/'.$image ]]);
        Product::create([
            'title' => $request->title,
            'stripe_id' => $product['id'],
            'slug' => $slug,
            'body' => $request->body,
            'description' => $request->description,
            'seo' => $request->seo,
            'price' => $request->price,
            'brand_id' => $request->brand,
            'category_id' => $request->category,
            'image' => $image,
        ]);
        return back()->with('success', 'Product has been created!');
    }

    // Update product
    public function update(Product $product){
        return view('dashboard.products.update', [
            'product' => $product,
            'brands' => Brand::latest()->get(),
            'categories' => Category::latest()->get()
        ]);
    }
    public function edit(Request $request, Product $product){
        $request->validate([
            'title' => ['required', 'max:255', 'string'],
            'price' => ['required', 'min:1', 'numeric'],
            'slug' => ['required'],
            'brand' => ['required', 'numeric'],
            'category' => ['required', 'numeric'],
            'description' => ['required', 'max:255'],
            'seo' => ['required', 'max:255'],
            'body' => ['required'],
            'image' => ['nullable', 'image', 'max:2500', 'mimes:png,jpg,webp,jpeg']
        ]);
        $image = null;
        $stripe = new StripeClient(config('app.stripe'));
        $slug = str_replace(' ', '-', strtolower($request->slug));
        if($request->hasFile('image')){
            Storage::disk('public_disk')->delete($product->image);
            $image = $request->image->storeAs('products', $slug.'-'.rand(1, 9999999999).'-thumb.'.$request->image->getClientOriginalExtension());
            $stripe->products->update(
                $product->stripe_id,
                [
                    'images' => [
                        config('app.url').'/storage/'.$image
                    ]
                ]
            );
        }
        if($request->title != $product->title){
            $stripe->products->update(
                $product->stripe_id,
                ['name' => $request->title]
            );
        }
        $product->update(array_filter([
            'title' => $request->title,
            'slug' => $slug,
            'body' => $request->body,
            'description' => $request->description,
            'seo' => $request->seo,
            'price' => $request->price,
            'brand_id' => $request->brand,
            'category_id' => $request->category,
            'image' => $image,
        ]));
        return to_route('admin.product.update', [$slug])->with('success', 'Product has been updated!');
    }


    // Update Active status
    public function status(Product $product){
        $product->is_active = !$product->is_active;
        $product->save();
        return back()->with('success', 'Product status has been updated!');
    }

    // Update Feature status
    public function feature(Product $product){
        $product->is_featured = !$product->is_featured;
        $product->save();
        return back()->with('success', 'Product feature has been updated!');
    }
}