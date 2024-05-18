<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    // List all contacts
    public function index(){
        return view('dashboard.contacts.index', [
            'contacts' => Contact::latest()->paginate(100)
        ]);
    }

    // Contact page
    public function create(){
        return view('dashboard.contacts.contact');
    }

    // Store contact message
    public function store(Request $request){
        $request->validate([
            'name' => ['required', 'max:255', 'string'],
            'email' => ['required', 'max:255', 'email'],
            'subject' => ['required', 'max:255', 'string'],
            'message' => ['required']
        ]);
        Contact::create([
            'name' => $request->name,
            'email' => $request->email,
            'subject' => $request->subject,
            'message' => $request->message
        ]);
        return back()->with('success', 'Your message has been sent!');
    }
}
