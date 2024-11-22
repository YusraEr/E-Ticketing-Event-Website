<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::check()) {
            return view('event.index');
        } else {
            return redirect()->route('login');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        return view('event.create');
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
                'ticket_categories' => 'required|array|min:1|max:3',
                'ticket_categories.*' => 'required|string|max:255',
                'ticket_prices' => 'required|array|min:1|max:3',
                'ticket_prices.*' => 'required|numeric|min:0',
                'ticket_quantities' => 'required|array|min:1|max:3',
                'ticket_quantities.*' => 'required|integer|min:1'
            ]);


            // Handle image upload
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $imagePath = $image->storeAs('uploads/events', $imageName, 'public');
            } elseif ($request->has('cropped_image')) {
                // Handle base64 cropped image if file upload fails
                $image_64 = $request->input('cropped_image');
                $extension = explode('/', explode(':', substr($image_64, 0, strpos($image_64, ';')))[1])[1];
                $replace = substr($image_64, 0, strpos($image_64, ',')+1);
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

            return redirect()->route('events.show', $event->id)
                ->with('success', 'Event created successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to create event: ' . $e->getMessage());
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
