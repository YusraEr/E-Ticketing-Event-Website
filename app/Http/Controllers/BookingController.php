<?php

namespace App\Http\Controllers;

use App\Models\TicketType;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Http\Controllers\TicketController;

class BookingController extends Controller
{
    protected $ticketController;
    protected $eventController;

    public function __construct(TicketController $ticketController, EventController $eventController)
    {
        $this->ticketController = $ticketController;
        $this->eventController = $eventController;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('warning', 'Please login to make a booking.');
        }

        try {
            $eventId = request('event_id');
            $tickets = TicketType::where('event_id', $eventId)->get();

            if ($tickets->isEmpty()) {
                return back()->with('info', 'No tickets available for this event.');
            }

            return view('booking.create', compact('tickets'));
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to load booking form: ' . $e->getMessage());
        }
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
        try {
            $quantities = $request->input('quantities', []);

            if (array_sum($quantities) === 0) {
                return redirect()->back()
                    ->with('warning', 'Please select at least one ticket')
                    ->withInput();
            }

            $request->validate([
                'event_id' => 'required|exists:events,id',
                'quantities' => 'required|array'
            ]);

            $user = Auth::user();
            $totalAmount = 0;
            $tickets = TicketType::whereIn('id', array_keys($request->quantities))->get();

            // Validate ticket availability first
            foreach ($request->quantities as $ticketId => $quantity) {
                if ($quantity > 0) {
                    $ticket = $tickets->find($ticketId);
                    if (!$ticket || $ticket->available_tickets < $quantity) {
                        throw new \Exception('Not enough tickets available for ' . $ticket->name);
                    }
                    $totalAmount += $ticket->price * $quantity;
                }
            }

            $processingFee = $totalAmount * 0.05;
            $finalAmount = $totalAmount + $processingFee;

            // Create booking
            $booking = Booking::create([
                'user_id' => $user->id,
                'event_id' => $request->event_id,
                'total_amount' => $finalAmount,
                'status' => 'pending',
                'total_tickets' => array_sum($request->quantities),
            ]);

            // Process tickets and update availability
            foreach ($request->quantities as $ticketTypeId => $quantity) {
                if ($quantity > 0) {
                    $ticketType = $tickets->find($ticketTypeId);
                    $this->eventController->updateAvailableTickets($ticketTypeId, $quantity);

                    // Create individual tickets
                    for ($i = 0; $i < $quantity; $i++) {
                        $this->ticketController->store([
                            'user_id' => $user->id,
                            'event_id' => $request->event_id,
                            'ticket_type' => $ticketTypeId,
                            'booking_id' => $booking->id,
                            'price' => $ticketType->price,
                        ]);
                    }
                }
            }

            return redirect()->route('booking.show', $booking->id)
                ->with('success', 'Booking created successfully! Please wait for approval.');
        } catch (\Exception $e) {
            return back()
                ->with('error', 'Booking failed: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $booking = Booking::with(['event.user', 'tickets.ticketType', 'user'])->findOrFail($id);
            return view('booking.show', compact('booking'));
        } catch (\Exception $e) {
            return redirect()->route('dashboard')
                ->with('error', 'Booking not found: ' . $e->getMessage());
        }
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

    public function cancel(Booking $booking)
    {
        if ($booking->created_at->diffInHours(now()) > 24) {
            return back()->with('error', 'Bookings can only be cancelled within 24 hours of creation.');
        }

        try {
            $booking->status = 'cancelled';

            $totalTickets = $booking->total_tickets;

            $booking->tickets()->delete();

            $event = $booking->event;
            $event->available_tickets += $totalTickets;

            $booking->save();
            $event->save();

            return redirect()->route('dashboard')
                ->with('success', 'Booking cancelled successfully.');

        } catch (\Exception $e) {
            return back()->with('error', 'Failed to cancel booking. Please try again.');
        }
    }
}

