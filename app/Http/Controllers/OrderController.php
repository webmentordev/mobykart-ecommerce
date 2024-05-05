<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    // Mark order as completed & send email
    public function complete(Order $order){
        if($order->payment == 'pending'){
            $order->is_paid = true;
            $order->payment = 'completed';
            $order->save();
        }
        return view('order.completed', [
            'order' => $order
        ]);
    }

    // Mark order as canceled & send email
    public function cancel(Order $order){
        if($order->payment == 'pending'){
            $order->payment = 'canceled';
            $order->save();
        }
        return view('order.cancel', [
            'order' => $order
        ]);
    }
}