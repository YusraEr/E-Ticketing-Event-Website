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
        try {
            if (!Auth::check()) {
                return redirect()->route('login')->with('warning', 'Please login to access the dashboard.');
            }

            $activeTab = session('activeTab', 'events');

            // User data
            $user = Auth::user();

            switch ($user->role) {
                case 'admin':
                    $data = $this->getAdminData();
                    return view('dashboard.admin', $data)->with('success', 'Welcome to admin dashboard!');

                case 'organizer':
                    $data = $this->getOrganizerData();
                    return view('dashboard.organizer', $data)->with('success', 'Welcome to organizer dashboard!');

                default:
                    $data = $this->getUserData($section, $activeTab);
                    return view('dashboard.user', $data)->with('success', 'Welcome to your dashboard!');
            }

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to load dashboard: ' . $e->getMessage());
        }
    }

    private function getAdminData()
    {
        return [
            'users' => User::all(),
            'events' => Event::with(['bookings', 'favorites'])->get(),
            'bookings' => Booking::all(),
            'myEvents' => Event::with(['bookings', 'favorites'])->where('user_id', Auth::id())->get()
        ];
    }

    private function getOrganizerData()
    {
        return [
            'events' => Event::with(['bookings', 'favorites'])->get(),
            'bookings' => Booking::all(),
            'myEvents' => Event::with(['bookings', 'favorites'])->where('user_id', Auth::id())->get()
        ];
    }

    private function getUserData($section, $activeTab)
    {
        return [
            'bookings' => Booking::with('event')->where('user_id', Auth::id())->get(),
            'favorites' => Favorite::with('event')->where('user_id', Auth::id())->get(),
            'section' => $section,
            'activeTab' => $activeTab
        ];
    }

    public function saveTabState(Request $request)
    {
        try {
            $request->session()->put('activeTab', $request->tab);
            return response()->json([
                'success' => true,
                'message' => 'Tab state saved successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to save tab state'
            ], 500);
        }
    }
}

