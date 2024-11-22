<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\TicketType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        return view('booking.index', [
            'tickets' => TicketType::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Event $event)
    {
        if (!Auth::check() || Auth::id() !== $event->user_id) {
            return redirect()->route('login');
        }

        // Check if event already has maximum types (3)
        if ($event->ticketTypes()->count() >= 3) {
            return redirect()->route('events.show', $event->id)
                ->with('error', 'Maximum ticket types (3) reached');
        }

        return view('ticket.create', compact('event'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Event $event)
    {
        if (!Auth::check() || Auth::id() !== $event->user_id) {
            return redirect()->route('login');
        }

        $currentCount = $event->ticketTypes()->count();
        $newCount = count($request->input('ticket_categories', []));

        if ($currentCount + $newCount > 3) {
            return back()->with('error', 'Maximum ticket categories (3) will be exceeded');
        }

        $validated = $request->validate([
            'ticket_categories' => 'required|array|min:1',
            'ticket_categories.*' => 'required|string|max:255',
            'ticket_prices' => 'required|array|min:1',
            'ticket_prices.*' => 'required|numeric|min:0',
            'ticket_quantities' => 'required|array|min:1',
            'ticket_quantities.*' => 'required|integer|min:1'
        ]);

        try {
            for ($i = 0; $i < count($validated['ticket_categories']); $i++) {
                $event->ticketTypes()->create([
                    'name' => $validated['ticket_categories'][$i],
                    'price' => $validated['ticket_prices'][$i],
                    'available_tickets' => $validated['ticket_quantities'][$i]
                ]);
            }

            return redirect()->route('events.show', $event->id)
                ->with('success', 'Ticket categories added successfully');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to add ticket categories: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
