<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Court;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CourtController extends Controller
{
    public function index(){
        return Inertia::render('Courts/Index', [
            "courts" => Court::filter(request(['search', 'category']))->get()
        ]);
    }

    public function create(){
        return Inertia::render('Courts/Create');
    }

    public function store(Request $request){
        $validated = $request->validate([
            'name' => 'required',
            'address' => 'required',
            'open' => 'required',
            'closed' => 'required',
            'operational_days' => 'required',
            'categories' => 'required',
            'rent_per_hour' => 'required|min:0|not_in:0|numeric',
        ]);

        $validated['operational_days'] = json_encode($validated['operational_days']);
        $validated['categories'] = json_encode($validated['categories']);

        Court::create($validated);

        return redirect()->route('courts.index')->with('success', 'Successfully added a new court.');
    }

    public function show(Court $court){
        $bookings = $court->bookings()->filter(request(['search']))->with('booker')->get();

        return Inertia::render('Courts/Show', [
            "court" => $court,
            "bookings" => $bookings
        ]);
    }

    public function edit(Court $court){
        return Inertia::render('Courts/Edit', [
            "court" => $court
        ]);
    }

    public function update(Request $request, Court $court){
        $validated = $request->validate([
            'name' => 'required',
            'address' => 'required',
            'open' => 'required',
            'closed' => 'required',
            'operational_days' => 'required',
            'categories' => 'required',
            'rent_per_hour' => 'required|min:0|not_in:0',
        ]);

        $validated['operational_days'] = json_encode($validated['operational_days']);
        $validated['categories'] = json_encode($validated['categories']);

        $court->update($validated);

        return redirect()->route('courts.index')->with('success', 'Successfully edited the court.');
    }

    public function destroy(Court $court){
        $court->delete();

        return redirect()->route('courts.index')->with('warning', 'Successfully deleted the court.');
    }
}
