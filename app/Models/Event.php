<?php

namespace App\Models;

use GPBMetadata\Google\Api\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Event extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'description',
        'date',
        'location',
        'image',
        'organizer_id',
    ];

    public function organizer()
    {
        return $this->belongsTo(User::class, 'organizer_id');
    }
}
