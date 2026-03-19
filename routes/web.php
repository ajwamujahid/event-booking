<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\EventController;
use Illuminate\Support\Facades\Route;

/* ── Root ── */
Route::get('/', fn () => redirect()->route('events.index'));

/* ── Guest Routes ── */
Route::middleware('guest')->group(function () {
    Route::get('/register',  [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/login',     [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login',    [AuthController::class, 'login']);
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

/* ── Events ── */
Route::get('/events', [EventController::class, 'index'])->name('events.index');

// ⚠️ create MUST come before {event} wildcard
Route::get('/events/create', [EventController::class, 'create'])
    ->middleware('auth')
    ->name('events.create');

Route::post('/events', [EventController::class, 'store'])
    ->middleware('auth')
    ->name('events.store');

Route::get('/events/{event}', [EventController::class, 'show'])->name('events.show');

Route::get('/events/{event}/edit', [EventController::class, 'edit'])
    ->middleware('auth')
    ->name('events.edit');

Route::put('/events/{event}', [EventController::class, 'update'])
    ->middleware('auth')
    ->name('events.update');

Route::delete('/events/{event}', [EventController::class, 'destroy'])
    ->middleware('auth')
    ->name('events.destroy');

/* ── Bookings ── */
Route::middleware('auth')->group(function () {
    Route::get('/bookings', [BookingController::class, 'index'])->name('bookings.index');

    Route::post('/events/{event}/bookings', [BookingController::class, 'store'])
        ->name('bookings.store');

    Route::patch('/bookings/{booking}/cancel', [BookingController::class, 'cancel'])
        ->middleware('booking.owner')
        ->name('bookings.cancel');
});