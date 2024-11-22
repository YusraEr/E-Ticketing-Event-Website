<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        if (Auth::check()){
            if (Auth::user()->role == 'admin'){
                return view('dashboard.admin');
            } else if (Auth::user()->role == 'organizer'){
                return view('dashboard.organizer');
            }
            return view('dashboard.user');
        }
        return redirect()->route('login');
    }
}
