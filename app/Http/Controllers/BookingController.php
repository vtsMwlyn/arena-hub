<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Inertia\Inertia;

class BookingController extends Controller
{
    public function index(){
        return Inertia::render('Bookings/All', [
            'bookings' => Booking::with(['booker', 'court'])->orderBy('date', 'asc')->orderBy('start_time', 'asc')->get()
        ]);
    }
}
