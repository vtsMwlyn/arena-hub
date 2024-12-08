<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Court extends Model
{
    use HasFactory;

    protected $guarded = ["id"];

    public function bookers(){
        return $this->belongsToMany(User::class, "bookings");
    }

    public function bookings(){
        return $this->hasMany(Booking::class);
    }
}
