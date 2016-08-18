<?php

namespace App\Http\Controllers;

use App\Models\Option;
use Illuminate\Http\Request;
use Auth;

use App\Http\Requests;

class HomeController extends Controller
{
    public function index()
    {
        if(Auth::check()){
            return view('home.index');
        }

        return view('home.login');
    }
}
