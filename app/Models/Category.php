<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
class Category extends Model
{
    protected $fillable = [
        'name',
        'description',
    ];

    public function events()
    {
        return $this->hasMany(Event::class);
    }
}
