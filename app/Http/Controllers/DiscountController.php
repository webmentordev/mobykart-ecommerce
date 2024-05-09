<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Discount;
use Illuminate\Http\Request;

class DiscountController extends Controller
{
    // List all discounts
    public function index()
    {
        return view('dashboard.discount.index', [
            'discounts' => Discount::latest()->with('product')->get(),
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

    // To create new discount for product
    public function store(Request $request)
    {
        $request->validate([
            'discount' => ['required', 'numeric', 'max:99'],
            'product' => ['required', 'numeric', 'unique:discounts,product_id']
        ]);
        Discount::create([
            'discount' => $request->discount,
            'product_id' => $request->product,
            'slug' => $this->randomSlug()
        ]);
        return back()->with('success', 'Discount has been created!');
    }

    // To delete tag
    public function delete(Discount $discount)
    {
        $discount->delete();
        return back()->with('success', 'Discount has been deleted!');
    }
}
