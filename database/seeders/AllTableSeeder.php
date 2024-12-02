<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Event;
use App\Models\Ticket;
use App\Models\Booking;
use App\Models\Category;
use App\Models\Favorite;
use App\Models\TicketType;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AllTableSeeder extends Seeder
{
    public function run(): void
    {
        // Check and create admin
        if (!User::where('email', 'admin1@example.com')->exists()) {
            User::create([
                'name' => 'Admin User',
                'email' => 'admin1@example.com',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]);
        }

        // Check and create organizers
        $organizers = [
            ['name' => 'Event Master', 'email' => 'organizer@example.com'],
            ['name' => 'Concert Pro', 'email' => 'concert@example.com'],
            ['name' => 'Tech Events', 'email' => 'tech@example.com'],
            ['name' => 'Sports Org', 'email' => 'sports@example.com']
        ];

        foreach ($organizers as $org) {
            if (!User::where('email', $org['email'])->exists()) {
                User::create([
                    'name' => $org['name'],
                    'email' => $org['email'],
                    'password' => Hash::make('password'),
                    'role' => 'organizer',
                ]);
            }
        }

        // Check and create regular users
        $users = [
            ['name' => 'John Doe', 'email' => 'john@example.com'],
            ['name' => 'Jane Smith', 'email' => 'jane@example.com'],
            ['name' => 'Bob Wilson', 'email' => 'bob@example.com'],
            ['name' => 'Alice Brown', 'email' => 'alice@example.com'],
            ['name' => 'Charlie Davis', 'email' => 'charlie@example.com']
        ];

        foreach ($users as $userData) {
            if (!User::where('email', $userData['email'])->exists()) {
                User::create([
                    'name' => $userData['name'],
                    'email' => $userData['email'],
                    'password' => Hash::make('password'),
                    'role' => 'user',
                ]);
            }
        }

        // Check and create categories
        $categories = [
            'Music' => 'Musical events and concerts',
            'Sports' => 'Sporting events and competitions',
            'Arts' => 'Art exhibitions and cultural events',
            'Technology' => 'Tech conferences and workshops',
            'Food' => 'Food festivals and culinary events'
        ];

        foreach ($categories as $name => $description) {
            if (!Category::where('name', $name)->exists()) {
                Category::create([
                    'name' => $name,
                    'description' => $description
                ]);
            }
        }

        // Create Events
        $events = [
            [
                'name' => 'Summer Music Festival',
                'description' => 'A fantastic summer music festival featuring top artists',
                'event_date' => '2024-07-15',
                'location' => 'Central Park',
                'category_id' => 1,
                'image' => 'uploads/events/music_festival.jpg'
            ],
            [
                'name' => 'Tech Conference 2024',
                'description' => 'Annual technology conference with industry leaders',
                'event_date' => '2024-09-20',
                'location' => 'Convention Center',
                'category_id' => 4,
                'image' => 'uploads/events/tech_conf.jpg'
            ],
            [
                'name' => 'Art Exhibition',
                'description' => 'Contemporary art showcase featuring local artists',
                'event_date' => '2024-06-10',
                'location' => 'City Gallery',
                'category_id' => 3,
                'image' => 'uploads/events/art_exhibit.jpg'
            ],
            [
                'name' => 'Food & Wine Festival',
                'description' => 'Culinary delights from around the world',
                'event_date' => '2024-08-25',
                'location' => 'Downtown Square',
                'category_id' => 5,
                'image' => 'uploads/events/food_fest.jpg'
            ],
            [
                'name' => 'Sports Championship',
                'description' => 'Annual sports championship event',
                'event_date' => '2024-10-05',
                'location' => 'Sports Complex',
                'category_id' => 2,
                'image' => 'uploads/events/sports_event.jpg'
            ],
            [
                'name' => 'Jazz Night',
                'description' => 'Evening of smooth jazz and blues',
                'event_date' => '2024-07-30',
                'location' => 'Jazz Club',
                'category_id' => 1,
                'image' => 'uploads/events/jazz_night.jpg'
            ]
        ];

        $organizers = User::where('role', 'organizer')->get();
        $regularUsers = User::where('role', 'user')->get();

        // Check and create events
        foreach ($events as $eventData) {
            if (!Event::where('name', $eventData['name'])->exists()) {
                $eventData['user_id'] = User::where('role', 'organizer')->inRandomOrder()->first()->id;
                $event = Event::create($eventData);

                // Create ticket types only for new events
                $ticketTypes = [
                    ['name' => 'VIP', 'price' => rand(150, 300), 'available_tickets' => rand(20, 50)],
                    ['name' => 'Regular', 'price' => rand(50, 150), 'available_tickets' => rand(100, 200)],
                    ['name' => 'Basic', 'price' => rand(20, 50), 'available_tickets' => rand(200, 300)]
                ];

                foreach ($ticketTypes as $ticketType) {
                    TicketType::create([
                        'event_id' => $event->id,
                        'name' => $ticketType['name'],
                        'price' => $ticketType['price'],
                        'available_tickets' => $ticketType['available_tickets']
                    ]);
                }

                // Create bookings and tickets only for new events
                $randomUsers = User::where('role', 'user')
                    ->inRandomOrder()
                    ->take(rand(1, 3))
                    ->get();

                foreach ($randomUsers as $user) {
                    $ticketQuantity = rand(1, 4);
                    $randomTicketType = TicketType::where('event_id', $event->id)
                        ->inRandomOrder()
                        ->first();
                    $ticketPrice = $randomTicketType->price;
                    $totalAmount = $ticketPrice * $ticketQuantity;

                    $booking = Booking::create([
                        'user_id' => $user->id,
                        'event_id' => $event->id,
                        'total_amount' => $totalAmount,
                        'total_tickets' => $ticketQuantity,
                        'status' => 'pending'
                    ]);

                    // Create tickets
                    for ($i = 0; $i < $ticketQuantity; $i++) {
                        Ticket::create([
                            'user_id' => $user->id,
                            'ticket_type' => $randomTicketType->id,
                            'booking_id' => $booking->id,
                            'ticket_code' => 'TIC-' . strtoupper(Str::random(8)),
                            'price' => $ticketPrice,
                            'status' => 'pending'
                        ]);
                    }
                }

                // Create favorites only for new events
                $randomFavoriteUsers = User::where('role', 'user')
                    ->inRandomOrder()
                    ->take(rand(2, 4))
                    ->get();

                foreach ($randomFavoriteUsers as $user) {
                    if (!Favorite::where('user_id', $user->id)->where('event_id', $event->id)->exists()) {
                        Favorite::create([
                            'user_id' => $user->id,
                            'event_id' => $event->id
                        ]);
                    }
                }
            }
        }
    }
}

