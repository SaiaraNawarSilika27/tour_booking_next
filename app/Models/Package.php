<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    protected $fillable = ['name', 'description', 'price', 'Duration', 'image'];
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}
