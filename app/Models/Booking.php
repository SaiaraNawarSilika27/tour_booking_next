<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Booking extends Model {
    protected $fillable = ['package_id', 'user_name', 'email', 'phone', 'booking_date', 'persons', 'total_price'];
    public function package() {
        return $this->belongsTo(Package::class);
    }
}
