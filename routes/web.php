<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\DashboardController;

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/event', [EventController::class, 'index'])->name('event.index');
Route::get('/event/{event}', [EventController::class, 'show'])->name('event.show');
Route::get('/api/events/filter', [EventController::class, 'filterEvents'])->name('events.filter');

// Authentication required routes
Route::middleware('auth')->group(function () {
    // Dashboard routes
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/save-tab-state', [DashboardController::class, 'saveTabState'])->name('save.tab.state');
    Route::get('main', function () {
        return view('dashboard');
    })->name('main');

    // Profile routes
    Route::controller(ProfileController::class)->group(function () {
        Route::get('/profile', 'edit')->name('profile.edit');
        Route::patch('/profile', 'update')->name('profile.update');
        Route::delete('/profile', 'destroy')->name('profile.destroy');
    });

    // User management routes
    Route::controller(UserController::class)->group(function () {
        Route::middleware('is_admin')->group(function () {
            Route::get('/user/create', 'create')->name('user.create');
            Route::post('/user', 'store')->name('user.store');
            Route::get('/user/{user}/edit', 'edit')->name('user.edit');
            Route::put('/user/{user}', 'update')->name('user.update');
            Route::delete('/user/{user}', 'destroy')->name('user.destroy');
        });
    });

    // Event management routes
    Route::controller(EventController::class)->group(function () {
        Route::middleware('is_not_auth')->group(function () {
            Route::post('/event', 'store')->name('event.store');
            Route::get('/event-create', 'create')->name('event.create');
            Route::delete('/event/{event}', 'destroy')->name('event.destroy');
            Route::put('/event/{event}', 'update')->name('event.update');
            Route::get('/event/{event}/edit', 'edit')->name('event.edit');
            Route::get('/event/{event}/queue', 'showQueue')->name('event.queue');
            Route::put('/queue/{booking}/approve', 'approveQueue')->name('queue.approve');
            Route::put('/queue/{booking}/reject', 'rejectQueue')->name('queue.reject');
            Route::put('/queue/{booking}/approve-all', 'approveAllQueue')->name('queue.approve.all');
        });
    });




    Route::middleware('is_user')->group(function () {
        
        // Booking routes
        Route::controller(BookingController::class)->group(function () {
            Route::get('/booking', 'index')->name('booking.index');
            Route::get('/booking-create', 'create')->name('booking.create');
            Route::post('/booking', 'store')->name('booking.store');
            Route::get('/booking/{booking}', 'show')->name('booking.show');
            Route::delete('/booking/{booking}/cancel', 'cancel')->name('booking.cancel');
        });

        // Favorite routes
        Route::controller(FavoriteController::class)->group(function () {
            Route::post('/favorite', 'store')->name('favorite.store');
            Route::delete('/favorite/{id}', 'destroy')->name('favorite.destroy');
        });
    });
});


require __DIR__ . '/auth.php';
