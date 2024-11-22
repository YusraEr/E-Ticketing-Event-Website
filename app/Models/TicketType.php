<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TicketType extends Model 
{
    protected $fillable = [
        'event_id',
        'name',
        'price',
        'available_tickets', 
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
