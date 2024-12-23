<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class Ticket extends Model
{
    protected $fillable = [
        'price',
        'booking_id',
        'ticket_type',
        'user_id',
        'status',
        'ticket_code',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function booking() {
        return $this->belongsTo(Booking::class);
    }

    public function ticketType() {
        return $this->belongsTo(TicketType::class, 'ticket_type');
    }


}
