<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        // Get categories for the dropdown
        $categories = Category::all();

        // Start with a base query
        $query = Event::query();

        // Initialize a flag to check if user is actively searching/filtering
        $isSearching = false;

        // Search by name
        if ($request->has('search') && !empty($request->search)) {
            $query->where('name', 'like', '%' . $request->search . '%');
            $isSearching = true;
        }

        // Filter by category
        if ($request->has('category') && !empty($request->category)) {
            $query->whereHas('category', function($q) use ($request) {
                $q->where('slug', $request->category);
            });
            $isSearching = true;
        }

        // Get the events
        $events = $query->latest()->get();

        // Only show alerts if user is actively searching/filtering
        if ($isSearching) {
            if ($events->count() > 0) {
                if ($request->has('search') && $request->has('category')) {
                    session()->flash('success', 'Found ' . $events->count() . ' events matching "' . $request->search . '" in selected category');
                } elseif ($request->has('search')) {
                    session()->flash('success', 'Found ' . $events->count() . ' events matching "' . $request->search . '"');
                } else {
                    session()->flash('success', 'Found ' . $events->count() . ' events in selected category');
                }
            } else {
                session()->flash('error', 'No events found matching your criteria. Showing all events instead.');
                $events = Event::latest()->get();
            }
        }

        return view('home', compact('events', 'categories'));
    }
}


