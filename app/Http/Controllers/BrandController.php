<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Product;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    // List brands
    public function index(){
        return view('dashboard.brand.index', [
            'brands' => Brand::latest()->withCount('products')->get()
        ]);
    }

    // Create a new brand
    public function store(Request $request){
        $request->validate([
            'title' => ['required', 'max:255', 'string', 'unique:brands,title']
        ]);
        Brand::create([
            'title' => $request->title,
            'slug'=> str_replace(' ', '-', strtolower($request->title))
        ]);
        return back()->with('success', 'Brand has been created!');
    }

    // Update the brand
    public function update(Request $request, Brand $brand){
        $request->validate([
            'title' => ['required', 'max:255', 'string', 'unique:brands,title']
        ]);
        $brand->update([
            'title' => $request->title,
            'slug'=> str_replace(' ', '-', strtolower($request->title))
        ]);
        return back()->with('success', 'Brand has been updated!');
    }

    // Update the brand status
    public function status(Brand $brand){
        $brand->is_active = !$brand->is_active;
        $brand->save();
        return back()->with('success', 'Brand status has been updated!');
    }
}