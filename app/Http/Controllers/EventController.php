<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Booking;
use App\Models\Category;
use App\Models\TicketType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $events = Event::with('favorites', 'bookings')->paginate(10);
        $categories = Category::all();
        return view('event.index', compact( 'events', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        $categories = Category::all();
        return view('event.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        try {

            $validated = $request->validate([
                'name' => 'required|max:255',
                'description' => 'required',
                'event_date' => 'required|date|after:now',
                'location' => 'required',
                'image' => 'required|image|max:10240',
                'category_id' => 'required|exists:categories,id',
                'ticket_categories' => 'required|array|min:1|max:3',
                'ticket_categories.*' => 'required|string|max:255',
                'ticket_prices' => 'required|array|min:1|max:3',
                'ticket_prices.*' => 'required|numeric|min:0',
                'ticket_quantities' => 'required|array|min:1|max:3',
                'ticket_quantities.*' => 'required|integer|min:1'
            ]);

            // Add more detailed error logging

            // Handle image upload
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $imagePath = $image->storeAs('uploads/events', $imageName, 'public');
            } elseif ($request->has('cropped_image')) {
                // Handle base64 cropped image if file upload fails
                $image_64 = $request->input('cropped_image');
                $extension = explode('/', explode(':', substr($image_64, 0, strpos($image_64, ';')))[1])[1];
                $replace = substr($image_64, 0, strpos($image_64, ',') + 1);
                $image = str_replace($replace, '', $image_64);
                $image = str_replace(' ', '+', $image);

                $imageName = time() . '_' . uniqid() . '.' . $extension;
                $imagePath = 'uploads/events/' . $imageName;
                Storage::disk('public')->put($imagePath, base64_decode($image));
            } else {
                return back()->with('error', 'No image provided');
            }

            $event = Event::create([
                'user_id' => Auth::id(),
                'name' => $validated['name'],
                'description' => $validated['description'],
                'event_date' => $validated['event_date'],
                'location' => $validated['location'],
                'category_id' => $validated['category_id'],
                'image' => $imagePath,
            ]);


            // Store ticket categories
            for ($i = 0; $i < count($validated['ticket_categories']); $i++) {
                $ticketType = $event->ticketTypes()->create([
                    'name' => $validated['ticket_categories'][$i],
                    'price' => $validated['ticket_prices'][$i],
                    'available_tickets' => $validated['ticket_quantities'][$i]
                ]);
            }

            return redirect()->route('event.show', $event->id)
                ->with('success', 'Event created successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to create event: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $event = Event::with('ticketTypes')->findOrFail($id);
        return view('event.show', compact('event'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $event = Event::with('ticketTypes')->findOrFail($id);

        // Check if user is authorized to edit this event
        if ($event->user_id !== Auth::id()) {
            return redirect()->route('event.index')
                ->with('error', 'You are not authorized to edit this event.');
        }

        $categories = Category::all();
        return view('event.edit', compact('event', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $event = Event::findOrFail($id);

        // Check if user is authorized to update this event
        if ($event->user_id !== Auth::id()) {
            return redirect()->route('event.index')
                ->with('error', 'You are not authorized to update this event.');
        }

        try {
            $validated = $request->validate([
                'name' => 'required|max:255',
                'description' => 'required',
                'event_date' => 'required|date',
                'location' => 'required',
                'image' => 'nullable|image|max:10240',
                'category_id' => 'required|exists:categories,id',
                'ticket_categories' => 'required|array|min:1|max:3',
                'ticket_categories.*' => 'required|string|max:255',
                'ticket_prices' => 'required|array|min:1|max:3',
                'ticket_prices.*' => 'required|numeric|min:0',
                'ticket_quantities' => 'required|array|min:1|max:3',
                'ticket_quantities.*' => 'required|integer|min:1'
            ]);

            // Handle image update

            $imagePath = $event->image; // Keep existing image by default
            if ($request->hasFile('image')) {
                // Delete old image
                if ($event->image) {
                    Storage::disk('public')->delete($event->image);
                }

                $image = $request->file('image');
                $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $imagePath = $image->storeAs('uploads/events', $imageName, 'public');
            } elseif ($request->has('cropped_image')) {
                // Handle base64 cropped image
                if ($event->image) {
                    Storage::disk('public')->delete($event->image);
                }

                $image_64 = $request->input('cropped_image');
                $extension = explode('/', explode(':', substr($image_64, 0, strpos($image_64, ';')))[1])[1];
                $replace = substr($image_64, 0, strpos($image_64, ',') + 1);
                $image = str_replace($replace, '', $image_64);
                $image = str_replace(' ', '+', $image);

                $imageName = time() . '_' . uniqid() . '.' . $extension;
                $imagePath = 'uploads/events/' . $imageName;
                Storage::disk('public')->put($imagePath, base64_decode($image));
            }

            // Update event
            $event->update([
                'name' => $validated['name'],
                'description' => $validated['description'],
                'event_date' => $validated['event_date'],
                'location' => $validated['location'],
                'category_id' => $validated['category_id'],
                'image' => $imagePath,
            ]);

            // Update ticket types
            $event->ticketTypes()->delete(); // Remove old ticket types

            // Create new ticket types
            for ($i = 0; $i < count($validated['ticket_categories']); $i++) {
                $event->ticketTypes()->create([
                    'name' => $validated['ticket_categories'][$i],
                    'price' => $validated['ticket_prices'][$i],
                    'available_tickets' => $validated['ticket_quantities'][$i]
                ]);
            }

            return redirect()->route('event.show', $event->id)
                ->with('success', 'Event updated successfully!');

        } catch (\Exception $e) {
            return back()->with('error', 'Failed to update event: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $event = Event::findOrFail($id);

            // Check if user is authorized to delete this event
            if ($event->user_id !== Auth::id()) {
                return response()->json([
                    'success' => false,
                    'message' => 'You are not authorized to delete this event.'
                ], 403);
            }

            // Delete event image
            if ($event->image) {
                Storage::disk('public')->delete($event->image);
            }

            // Delete the event (this will cascade delete related ticket types)
            $event->delete();

            if (request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Event deleted successfully!'
                ]);
            }

            return redirect()->route('dashboard')
                ->with('success', 'Event deleted successfully!');

        } catch (\Exception $e) {
            if (request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to delete event: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->back()
                ->with('error', 'Failed to delete event: ' . $e->getMessage());
        }
    }

    public function updateAvailableTickets($ticketTypeId, $quantity)
    {
        try {
            $ticketType = TicketType::findOrFail($ticketTypeId);


            if ($ticketType->available_tickets < $quantity) {
                throw new \Exception('Not enough tickets available');
            }

            $ticketType->available_tickets -= $quantity;
            $ticketType->save();

            return true;
        } catch (\Exception $e) {

            throw new \Exception('Failed to update ticket availability: ' . $e->getMessage());
        }
    }

    /**
     * Display ticket queues for a specific event
     */
    public function showQueue(string $id)
    {
        $event = Event::with(['ticketTypes', 'bookings.tickets.ticketType'])
            ->findOrFail($id);

        $ticketQueues = $event->bookings()
            ->with(['user', 'event', 'tickets.ticketType'])
            ->get()
            ->groupBy('status');

        $queuesByStatus = [
            'pending' => $ticketQueues->get('pending', collect()),
            'ready' => $ticketQueues->get('ready', collect()),
            'rejected' => $ticketQueues->get('rejected', collect()),
        ];

        return view('event.queue', compact('event', 'queuesByStatus'));
    }

    /**
     * Approve a ticket queue request
     */
    public function approveQueue(string $id)
    {
        try {
            Log::info('Approving queue: ' . $id);
            $booking = Booking::with(['event'])->findOrFail($id);

            if ($booking->status !== 'pending') {
                Log::warning('Attempt to approve non-pending booking: ' . $id);
                return redirect()->back()->with('error', 'This booking has already been processed.');
            }

            // Use model transaction
            $booking->getConnection()->transaction(function() use ($booking) {
                // Update booking status
                $booking->update([
                    'status' => 'ready',
                    'approved_at' => now()
                ]);
            });

            Log::info('Successfully approved booking: ' . $id);
            return redirect()->back()->with('success', 'Ticket request approved successfully!');
        } catch (\Exception $e) {
            Log::error('Approval error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to approve ticket: ' . $e->getMessage());
        }
    }

    public function rejectQueue(string $id)
    {
        try {
            Log::info('Rejecting queue: ' . $id);
            $booking = Booking::with(['event', 'tickets.ticketType'])->findOrFail($id);

            if ($booking->status !== 'pending') {
                Log::warning('Attempt to reject non-pending booking: ' . $id);
                return redirect()->back()->with('error', 'This booking has already been processed.');
            }

            // Use model transaction
            $booking->getConnection()->transaction(function() use ($booking) {
                // Update booking status
                $booking->update([
                    'status' => 'rejected',
                    'rejected_at' => now()
                ]);

                // Return tickets to available pool by grouping tickets by ticket type
                $ticketsByType = $booking->tickets->groupBy('ticket_type_id');
                foreach ($ticketsByType as $ticketTypeId => $tickets) {
                    $ticketType = $tickets->first()->ticketType;
                    $quantityToReturn = $tickets->count();

                    $ticketType->increment('available_tickets', $quantityToReturn);
                    Log::info("Returned {$quantityToReturn} tickets to pool for ticket type: {$ticketTypeId}");
                }
            });

            Log::info('Successfully rejected booking: ' . $id);
            return redirect()->back()->with('success', 'Ticket request rejected successfully!');
        } catch (\Exception $e) {
            Log::error('Rejection error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to reject ticket: ' . $e->getMessage());
        }
    }

    public function approveAllQueue(string $eventId)
    {
        try {
            Log::info('Approving all pending queues for event: ' . $eventId);

            $event = Event::findOrFail($eventId);
            $pendingBookings = $event->bookings()->where('status', 'pending')->get();

            if ($pendingBookings->isEmpty()) {

                return redirect()->back()->with('info', 'No pending tickets to approve.');
            }

            DB::transaction(function() use ($pendingBookings) {
                foreach ($pendingBookings as $booking) {
                    $booking->update([
                        'status' => 'ready',
                        'approved_at' => now()
                    ]);
                }
            });

            Log::info('Successfully approved all pending bookings for event: ' . $eventId);
            return redirect()->back()->with('success', 'All pending tickets have been approved!');
        } catch (\Exception $e) {
            Log::error('Bulk approval error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to approve tickets: ' . $e->getMessage());
        }
    }
}








