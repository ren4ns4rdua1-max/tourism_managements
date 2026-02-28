<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\DestinationController;
use App\Http\Controllers\HotelController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UtilityController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index']);

/*
|--------------------------------------------------------------------------
| Admin Only Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('users', UserController::class);
});

/*
|--------------------------------------------------------------------------
| Admin & Manager Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin,manager'])->group(function () {

    Route::resource('destinations', DestinationController::class)->only(['index', 'store', 'create', 'update', 'destroy', 'edit']);
    Route::resource('gallery', GalleryController::class)->only(['index', 'store', 'create', 'destroy']);
    Route::resource('feedback', FeedbackController::class)->only(['index', 'store', 'create', 'show', 'update', 'destroy', 'edit']);

    // Hotel Management
    Route::resource('hotel', HotelController::class);

    // Room Management
    Route::get('hotel/{hotel}/rooms/create', [HotelController::class, 'createRoom'])->name('hotel.rooms.create');
    Route::post('hotel/{hotel}/rooms', [HotelController::class, 'storeRoom'])->name('hotel.rooms.store');
    Route::get('hotel/{hotel}/rooms/{room}/edit', [HotelController::class, 'editRoom'])->name('hotel.rooms.edit');
    Route::put('hotel/{hotel}/rooms/{room}', [HotelController::class, 'updateRoom'])->name('hotel.rooms.update');
    Route::delete('hotel/{hotel}/rooms/{room}', [HotelController::class, 'destroyRoom'])->name('hotel.rooms.destroy');

    // Booking Management
    Route::get('hotel/bookings', [HotelController::class, 'bookings'])->name('hotel.bookings.index');
    Route::get('hotel/bookings/create', [HotelController::class, 'createBooking'])->name('hotel.bookings.create');
    Route::post('hotel/bookings', [HotelController::class, 'storeBooking'])->name('hotel.bookings.store');
    Route::get('hotel/bookings/{booking}/edit', [HotelController::class, 'editBooking'])->name('hotel.bookings.edit');
    Route::put('hotel/bookings/{booking}', [HotelController::class, 'updateBooking'])->name('hotel.bookings.update');
    Route::post('hotel/bookings/{booking}/confirm', [HotelController::class, 'confirmBooking'])->name('hotel.bookings.confirm');
    Route::post('hotel/bookings/{booking}/cancel', [HotelController::class, 'cancelBooking'])->name('hotel.bookings.cancel');
    Route::post('hotel/bookings/{booking}/checkin', [HotelController::class, 'checkIn'])->name('hotel.bookings.checkin');
    Route::post('hotel/bookings/{booking}/checkout', [HotelController::class, 'checkOut'])->name('hotel.bookings.checkout');
    Route::post('hotel/bookings/{booking}/assign-room', [HotelController::class, 'assignRoom'])->name('hotel.bookings.assign-room');

    // Availability
    Route::get('hotel/availability', [HotelController::class, 'checkAvailability'])->name('hotel.bookings.availability');
});

/*
|--------------------------------------------------------------------------
| Public Destination View
|--------------------------------------------------------------------------
*/

Route::get('/destinations/{destination}', [DestinationController::class, 'show'])
    ->name('destinations.show');

/*
|--------------------------------------------------------------------------
| Dashboard (No Closure)
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', [UtilityController::class, 'dashboard'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

/*
|--------------------------------------------------------------------------
| Utility Routes (No Closure)
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    Route::get('/check-role', [UtilityController::class, 'checkRole']);
    Route::get('/set-admin', [UtilityController::class, 'setAdmin']);
});

/*
|--------------------------------------------------------------------------
| Profile Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';