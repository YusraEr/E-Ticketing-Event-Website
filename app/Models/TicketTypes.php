<?php

namespace App\Models;

use GPBMetadata\Google\Api\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
class TicketTypes extends Model
{
    protected $fillable = [
        'event_id',
        'name',
        'price',
        'quantity',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
