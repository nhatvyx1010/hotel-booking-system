<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function type(){
        return $this->belongsTo(RoomType::class, 'roomtype_id', 'id');
    }

    public function room_numbers(){
        return $this->hasMany(RoomNumber::class, 'rooms_id')->where('status', 'Active');
    }

    public function bookings(){
        return $this->hasManyThrough(Booking::class, BookingRoomList::class, 'room_number_id', 'id', 'id', 'booking_id');
    }

    public function hotel()
    {
        return $this->belongsTo(User::class, 'hotel_id', 'id');
    }

    public function facilities()
    {
        return $this->hasMany(Facility::class, 'rooms_id');
    }

    public function specialPrices()
    {
        return $this->hasMany(RoomSpecialPrice::class, 'room_id');
    }
}
