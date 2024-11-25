<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'event_id' => 'required|exists:events,id',
        ]);

        $favoriteExists = $request->user()->favorites()->where('event_id', $request->event_id)->exists();

        if ($favoriteExists) {
            return response()->json(['message' => 'Already favorited'], 409);
        }

        $request->user()->favorites()->create($request->only('event_id'));
        return response()->json(['success' => true]);
    }

    public function destroy(Request $request, $id)
    {
        $request->user()->favorites()->where('event_id', $id)->delete();

        return response()->json(['success' => true]);
    }
}
