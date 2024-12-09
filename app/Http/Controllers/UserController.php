<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function my_bookings(){
        return Inertia::render('Bookings/Mine', [
            'bookings' => Booking::where("user_id", Auth::user()->id)->orderBy('date', 'asc')->orderBy('start_time', 'asc')->with(['booker', 'court'])->get()
        ]);
    }
}
