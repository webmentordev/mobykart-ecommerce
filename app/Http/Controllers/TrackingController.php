<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class TrackingController extends Controller
{
    public function index(Request $request){
        $order = Order::orWhere('order_id', $request->order)->first();
        return view('track-order', [
            'order' => $order
        ]);
    }
}