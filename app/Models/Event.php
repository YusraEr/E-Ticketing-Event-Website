<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Event extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'user_id',
        'name',
        'description',
        'event_date',
        'location',
        'image',
        'category_id',
    ];

    public function ticketTypes()
    {
        return $this->hasMany(TicketType::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }
}
