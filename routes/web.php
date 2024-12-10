<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CourtController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->middleware(['auth', 'verified'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ===== Courts ===== //
Route::get('/courts', [CourtController::class, 'index'])->name('courts.index')->middleware('auth');
Route::get('/courts/{court}/show', [CourtController::class, 'show'])->name('courts.show')->middleware('auth');
Route::middleware(['auth', 'admin'])->group(function(){
    Route::get('/courts/create', [CourtController::class, 'create'])->name('courts.create');
    Route::post('/courts/create', [CourtController::class, 'store'])->name('courts.store');
    Route::get('/courts/{court}/edit', [CourtController::class, 'edit'])->name('courts.edit');
    Route::put('/courts/{court}/edit', [CourtController::class, 'update'])->name('courts.update');
    Route::delete('/courts/{court}/delete', [CourtController::class, 'destroy'])->name('courts.destroy');
});

// ===== Bookings ===== //
// My bookings
Route::get('/bookings', [BookingController::class, 'index'])->name('bookings.index')->middleware('auth');

// Book court via show court page
Route::get('/bookings/{court}/create', [BookingController::class, 'create'])->name('bookings.create')->middleware('auth');
Route::post('/bookings/{court}/create', [BookingController::class, 'store'])->name('bookings.store')->middleware('auth');

// Cancel booking
Route::delete('/bookings/{booking}/delete', [BookingController::class, 'destroy'])->name('bookings.destroy')->middleware('auth');


require __DIR__.'/auth.php';
