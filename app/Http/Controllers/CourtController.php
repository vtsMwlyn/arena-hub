<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Court;
use Illuminate\Http\Request;

class CourtController extends Controller
{
    public function index(){
        return Inertia::render('Courts/Index', [
            "courts" => Court::all()
        ]);
    }
}
