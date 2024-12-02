<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function store(Request $request)
    {
        try {
            $request->validate([
                'event_id' => 'required|exists:events,id',
            ]);

            $favoriteExists = $request->user()->favorites()->where('event_id', $request->event_id)->exists();

            if ($favoriteExists) {
                if ($request->wantsJson()) {
                    return response()->json(['message' => 'Event already in favorites'], 409);
                }
                return back()->with('info', 'Event is already in your favorites.');
            }

            $request->user()->favorites()->create($request->only('event_id'));

            if ($request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Event added to favorites successfully'
                ]);
            }
            return back()->with('success', 'Event added to favorites successfully!');

        } catch (\Exception $e) {
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to add to favorites: ' . $e->getMessage()
                ], 500);
            }
            return back()->with('error', 'Failed to add event to favorites.');
        }
    }

    public function destroy($id)
    {
        try {
            $favorite = Favorite::where('event_id', $id)
                ->where('user_id', Auth::id())
                ->firstOrFail();

            $favorite->delete();

            return redirect()->back()->with('success', 'Event removed from favorites successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to remove event from favorites');
        }
    }
}

