<?php
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\DestinationController;
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

// Admin and Manager routes (multiple roles)
Route::middleware(['auth', 'role:admin,manager'])->group(function () {
    Route::resource('destinations', DestinationController::class)->except(['show']);
    Route::resource('gallery', GalleryController::class)->except(['show', 'edit', 'update']);
    Route::resource('booking', BookingController::class);
    Route::resource('feedback', FeedbackController::class);
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

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';