<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Controllers\EventController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\DashboardController;

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/event', [EventController::class, 'index'])->name('event.index');
Route::get('/event/{event}', [EventController::class, 'show'])->name('event.show');
Route::middleware('auth')->group(function () {
    Route::get('/event-create', [EventController::class, 'create'])->name('event.create');
    Route::post('/event', [EventController::class, 'store'])->name('event.store');
});

Route::middleware('auth')->group(function () {
    Route::get('/booking', [BookingController::class, 'index'])->name('booking.index');
    Route::get('/booking-create', [BookingController::class, 'create'])->name('booking.create');
    Route::post('/booking', [BookingController::class, 'store'])->name('booking.store');
    Route::get('/booking/{booking}', [BookingController::class, 'show'])->name('booking.show');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware('auth')
    ->name('dashboard');

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('main', function () {
    return view('dashboard');
})->name('main')->middleware('auth');

Route::middleware('auth')->group(function () {
    Route::post('/favorite', [FavoriteController::class, 'store'])->name('favorite.store');
    Route::delete('/favorite/{id}', [FavoriteController::class, 'destroy'])->name('favorite.destroy');
});

require __DIR__ . '/auth.php';
