<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
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

    Route::get('/user/{user}/edit', [UserController::class, 'edit'])->name('user.edit');
    Route::put('/user/{user}', [UserController::class, 'update'])->name('user.update');
    Route::get('/user/create', [UserController::class, 'create'])->name('user.create');
    Route::post('/user', [UserController::class, 'store'])->name('user.store');
    Route::delete('/user/{user}', [UserController::class, 'destroy'])->name('user.destroy');

    Route::post('/save-tab-state', [DashboardController::class, 'saveTabState'])->name('save.tab.state');
});

Route::get('/event', [EventController::class, 'index'])->name('event.index');
Route::get('/event/{event}', [EventController::class, 'show'])->name('event.show');
Route::get('/event/{event}/queue', [EventController::class, 'showQueue'])->name('event.queue'); // Add this line
Route::middleware('auth')->group(function () {
    Route::get('/event/{event}/edit', [EventController::class, 'edit'])->name('event.edit');
    Route::put('/event/{event}', [EventController::class, 'update'])->name('event.update');
    Route::get('/event-create', [EventController::class, 'create'])->name('event.create');
    Route::post('/event', [EventController::class, 'store'])->name('event.store');
    Route::delete('/event/{event}', [EventController::class, 'destroy'])->name('event.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/booking', [BookingController::class, 'index'])->name('booking.index');
    Route::get('/booking-create', [BookingController::class, 'create'])->name('booking.create');
    Route::post('/booking', [BookingController::class, 'store'])->name('booking.store');
    Route::get('/booking/{booking}', [BookingController::class, 'show'])->name('booking.show');
    Route::put('/queue/{booking}/approve', [EventController::class, 'approveQueue'])->name('queue.approve');
    Route::put('/queue/{booking}/reject', [EventController::class, 'rejectQueue'])->name('queue.reject');
    Route::put('/queue/{id}/approve', [EventController::class, 'approveQueue'])->name('queue.approve');
    Route::put('/queue/{id}/reject', [EventController::class, 'rejectQueue'])->name('queue.reject');
    Route::put('/queue/{event}/approve-all', [EventController::class, 'approveAllQueue'])->name('queue.approve.all');
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
