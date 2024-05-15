<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // List categories
    public function index(){
        return view('dashboard.category.index', [
            'categories' => Category::latest()->withCount('products')->get()
        ]);
    }

    // Create a new category
    public function store(Request $request){
        $request->validate([
            'title' => ['required', 'max:255', 'string', 'unique:categories,title']
        ]);
        Category::create([
            'title' => $request->title,
            'slug'=> str_replace(' ', '-', strtolower($request->title))
        ]);
        return back()->with('success', 'Category has been created!');
    }

    // Update the category
    public function update(Request $request, Category $category){
        $request->validate([
            'title' => ['required', 'max:255', 'string'],
            'slug' => ['required', 'max:255', 'string']
        ]);
        $category->update([
            'title' => $request->title,
            'slug'=> str_replace(' ', '-', strtolower($request->slug))
        ]);
        return back()->with('success', 'Category has been updated!');
    }

    // Update the category status
    public function status(Category $category){
        $category->is_active = !$category->is_active;
        $category->save();
        return back()->with('success', 'Category status has been updated!');
    }
}
