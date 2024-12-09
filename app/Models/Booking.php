<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $guarded = ["id"];

    public function booker(){
        return $this->belongsTo(User::class, "user_id");
    }

    public function court(){
        return $this->belongsTo(Court::class);
    }
}
