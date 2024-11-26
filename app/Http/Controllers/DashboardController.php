<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Booking;
use App\Models\Favorite;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index($section = 'bookings')
    {
        // user
        $bookings = Booking::with('event')->where('user_id', Auth::id())->get();
        $favorites = Favorite::with('event')->where('user_id', Auth::id())->get();

        // admin
        $users = User::all();
        $events = Event::with(['bookings', 'favorites'])->get();
        $bookings = Booking::all();

        if (Auth::check()) {
            if (Auth::user()->role == 'admin') {
                return view('dashboard.admin', compact('users', 'events', 'bookings'));
            } else if (Auth::user()->role == 'organizer') {
                return view('dashboard.organizer');
            }
            return view("dashboard.user", compact('bookings', 'favorites', 'section'));
        }
        return redirect()->route('login');
    }
}
