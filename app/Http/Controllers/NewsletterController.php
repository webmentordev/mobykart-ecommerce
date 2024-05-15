<?php

namespace App\Http\Controllers;

use App\Models\Newsletter;
use Illuminate\Http\Request;

class NewsletterController extends Controller
{
    public function index(){
        return view('dashboard.newsletter.index', [
            'newsletters' => Newsletter::latest()->get()
        ]);
    }

    public function store(Request $request){
        $request->validate([
            'email' => ['required', 'max:255', 'email']
        ]);
        Newsletter::create([
            'email' => $request->email
        ]);
        return back()->with('newsletter', 'Subscribed successfully!');
    }
}