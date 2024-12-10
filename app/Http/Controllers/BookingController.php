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
            'bookings' => Booking::where("user_id", Auth::user()->id)->orderBy('date', 'asc')->orderBy('start_time', 'asc')->with(['booker', 'court'])->paginate(5)
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

        $validated['start_time'] .= ':00';
        $validated['end_time'] .= ':00';

        $outside_of_operational_hour = false;
        if($validated['start_time'] < $court->open || $validated['start_time'] > $court->closed){
            $outside_of_operational_hour = true;
        }
        else if($validated['end_time'] < $court->open || $validated['end_time'] > $court->closed){
            $outside_of_operational_hour = true;
        }

        if($outside_of_operational_hour){
            return redirect()->back()->with('error', 'The selected time is out of operational hour.');
        }

        $already_booked = false;
        $err = '';

        foreach($court->bookings as $b){
            if($b->category == $validated['category'] && $b->date == $request['date']){
                if($validated['start_time'] > $b->start_time && $validated['start_time'] < $b->end_time) {
                    $already_booked = true;
                    $err = 'Someone already booked at that time (' . $b->booker->name . ' [' . $b->start_time . '-' . $b->end_time . ']' . '). ';
                } else if($validated['end_time'] > $b->start_time && $validated['end_time'] < $b->end_time){
                    $already_booked = true;
                    $err = 'Someone already booked at that time (' . $b->booker->name . ' [' . $b->start_time . '-' . $b->end_time . ']' . '). ';
                }
            }
        }

        if($already_booked){
            return redirect()->back()->with('error', $err);
        }

        $validated['user_id'] = Auth::user()->id;
        $validated['court_id'] = $court->id;

        Booking::create($validated);

        return redirect()->route('bookings.index')->with('success', 'Successfully booked the court.');
    }

    public function destroy(Booking $booking){
        $booking->delete();

        return redirect()->route('bookings.index')->with('warning', 'Successfully cancelled the booking.');
    }
}
