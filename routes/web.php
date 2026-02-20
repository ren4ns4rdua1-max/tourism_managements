<?php
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\DestinationController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\BookingController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

Route::get('/', [HomeController::class, 'index']);

// Admin-only routes
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
});

// ADD THIS TEMPORARILY - Check current role
Route::get('/check-role', function() {
    if (!auth()->check()) {
        return 'Not logged in';
    }
    
    $user = auth()->user();
    return [
        'id' => $user->id,
        'name' => $user->name,
        'email' => $user->email,
        'role' => $user->role ?? 'NO ROLE SET'
    ];
})->middleware('auth');

// ADD THIS TEMPORARILY - Set yourself as admin
Route::get('/set-admin', function() {
    if (!auth()->check()) {
        return 'Please login first';
    }
    
    $user = auth()->user();
    $user->role = 'admin';
    $user->save();
    
    return 'Success! You are now admin. Role: ' . $user->role;
})->middleware('auth');

// Admin-only routes - Full destination management
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('destinations', DestinationController::class)->except(['show']);
});

// Manager-only routes - Read-only destination access
Route::middleware(['auth', 'role:manager'])->group(function () {
    Route::get('/manager/destinations', [DestinationController::class, 'index'])->name('manager.destinations.index');
});

// User-only booking routes (regular users can only create and view their own bookings)
Route::middleware(['auth', 'role:user'])->group(function () {
    Route::resource('booking', BookingController::class)->only(['index', 'create', 'store', 'show']);
});

// Admin-only booking routes - Full CRUD
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/bookings', [BookingController::class, 'adminIndex'])->name('admin.bookings.index');
    Route::get('/admin/bookings/{booking}/edit', [BookingController::class, 'adminEdit'])->name('admin.bookings.edit');
    Route::put('/admin/bookings/{booking}', [BookingController::class, 'adminUpdate'])->name('admin.bookings.update');
    Route::delete('/admin/bookings/{booking}', [BookingController::class, 'adminDestroy'])->name('admin.bookings.destroy');
});

// Manager-only booking routes - View all, update status (no delete)
Route::middleware(['auth', 'role:manager'])->group(function () {
    Route::get('/manager/bookings', [BookingController::class, 'managerIndex'])->name('manager.bookings.index');
    Route::get('/manager/bookings/{booking}/edit', [BookingController::class, 'managerEdit'])->name('manager.bookings.edit');
    Route::put('/manager/bookings/{booking}', [BookingController::class, 'managerUpdate'])->name('manager.bookings.update');
    Route::post('/manager/bookings/{booking}/accept', [BookingController::class, 'accept'])->name('manager.bookings.accept');
    Route::post('/manager/bookings/{booking}/decline', [BookingController::class, 'decline'])->name('manager.bookings.decline');
});

// All authenticated users (admin, manager, user) can access feedback routes
Route::middleware(['auth', 'role:admin|manager|user'])->group(function () {
    Route::resource('feedback', FeedbackController::class);
});

// Admin and Manager only - Gallery and Users management
Route::middleware(['auth', 'role:admin|manager'])->group(function () {
    Route::resource('gallery', GalleryController::class)->except(['show', 'edit', 'update']);
    Route::resource('users', UserController::class);
});

// Public destination view
Route::get('/destinations/{destination}', [DestinationController::class, 'show'])->name('destinations.show');

// Authenticated user routes with role-based dashboard
Route::get('/dashboard', function () {
    $user = auth()->user();

    // Redirect based on user role
    if ($user->role === 'admin') {
        return view('dashboard'); // Admin dashboard
    } elseif ($user->role === 'manager') {
        return view('dashboard.manager'); // Manager dashboard
    } else {
        return view('dashboard.user'); // User dashboard (default)
    }
})->middleware(['auth', 'verified'])->name('dashboard');

// Route for submitting feedback from user dashboard
Route::post('/dashboard/feedback', [FeedbackController::class, 'storeFromDashboard'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard.feedback.store');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';