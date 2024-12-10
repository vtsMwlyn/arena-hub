<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Court;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function index(){
        return Inertia::render('Bookings/Index', [
            'bookings' => Booking::where("user_id", Auth::user()->id)->orderBy('date', 'asc')->orderBy('start_time', 'asc')->with(['booker', 'court'])->get()
        ]);
    }

    public function create(Court $court){
        return Inertia::render('Bookings/Create', [
            'bookings' => Booking::where("user_id", Auth::user()->id)->orderBy('date', 'asc')->orderBy('start_time', 'asc')->with(['booker', 'court'])->get(),
            'court' => $court
        ]);
    }

    public function store(Request $request, Court $court){
        $validated = $request->validate([
            'date' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
            'category' => 'required',
            'people' => 'required|min:0|not_in:0|numeric'
        ]);

        $validated['user_id'] = Auth::user()->id;
        $validated['court_id'] = $court->id;

        Booking::create($validated);

        return redirect()->route('bookings.index');
    }

    public function destroy(Booking $booking){
        $booking->delete();

        return redirect()->route('bookings.index');
    }
}
