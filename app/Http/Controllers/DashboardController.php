<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Favorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $bookings = Booking::with('event')->where('user_id', Auth::id())->get();
        $favorites = Favorite::with('event')->where('user_id', Auth::id())->get();

        if (Auth::check()){
            if (Auth::user()->role == 'admin'){
                return view('dashboard.admin');
            } else if (Auth::user()->role == 'organizer'){
                return view('dashboard.organizer');
            }
            return view("dashboard.user", compact('bookings', 'favorites'));
        }
        return redirect()->route('login');
    }
}
