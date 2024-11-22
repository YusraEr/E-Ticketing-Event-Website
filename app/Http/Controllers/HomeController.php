<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $events = Event::with('category')->get();  // Add with('category') to eager load the relationship
        return view('home', compact('events'));
    }
}
