<?php

namespace App\Http\Controllers;

use App\Mail\Canceled;
use App\Mail\Completed;
use App\Mail\Processed;
use App\Mail\Refunded;
use App\Mail\Transit;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
    // List all orders in dashboard
    public function index(){
        return view('dashboard.orders.index', [
            'orders' => Order::latest()->get()
        ]);
    }

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


    // Update order shipping in dashboard
    public function status(Request $request, Order $order){
        $request->validate([
            'transit' => ['required_if:status,transit', 'max:255'],
            'logistics' => ['required_if:status,transit', 'max:255']
        ]);
        if($request->status == 'processed' && $request->email_send){
            Mail::to($order->email)->send(new Processed($order->order_id));
        }elseif($request->status == 'transit' && $request->email_send){
            Mail::to($order->email)->send(new Transit($order->order_id, $request->transit, $request->logistics));
            Order::where('order_id', $order->order_id)->update([
                'transit_id' => $request->transit,
                'logistics' => $request->logistics
            ]);
        }elseif($request->status == 'completed' && $request->email_send){
            Mail::to($order->email)->send(new Completed($order->order_id));
        }elseif($request->status == 'refunded' && $request->email_send){
            Mail::to($order->email)->send(new Refunded($order->order_id));
        }elseif($request->status == 'canceled' && $request->email_send){
            Mail::to($order->email)->send(new Canceled($order->order_id));
        }
        Order::where('order_id', $order->order_id)->update([
            'shipping' => $request->status
        ]);
        return back()->with('success', 'Shipping Status has been updated!');
    }
}