<?php

namespace App\Http\Controllers;

use App\Models\TicketType;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $eventId = request('event_id');
        $tickets = TicketType::where('event_id', $eventId)->get();

        return view('booking.create', [
            'tickets' => $tickets
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'event_id' => 'required|exists:events,id',
            'quantities' => 'required|array'
        ]);

        $user = Auth::user();
        $totalAmount = 0;
        $tickets = TicketType::whereIn('id', array_keys($request->quantities))->get();

        foreach ($request->quantities as $ticketId => $quantity) {
            if ($quantity > 0) {
                $ticket = $tickets->find($ticketId);
                if ($ticket->available_tickets < $quantity) {
                    return back()->with('error', 'Not enough tickets available.');
                }
                $totalAmount += $ticket->price * $quantity;
            }
        }

        $booking = Booking::create([
            'user_id' => $user->id,
            'event_id' => $request->event_id,
            'total_amount' => $totalAmount
        ]);

        foreach ($request->quantities as $ticketId => $quantity) {
            if ($quantity > 0) {
                $booking->tickets()->create([
                    'ticket_type_id' => $ticketId,
                    'quantity' => $quantity
                ]);
            }
        }

        return redirect()->route('home')
            ->with('success', 'Booking created successfully!');
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
