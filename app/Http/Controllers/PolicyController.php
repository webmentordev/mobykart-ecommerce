<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PolicyController extends Controller
{
    public function terms(){
        return view('terms-of-service');
    }
    public function privacy(){
        return view('privacy-policy');
    }
    public function return(){
        return view('return-policy');
    }
}