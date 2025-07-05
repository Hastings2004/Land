<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminPlotController;
use App\Http\Controllers\CustomerPlotController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InquiriesController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SavedPlotController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\ReviewController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Default welcome route - redirects to the main dashboard
Route::get('/', function () {
    return redirect()->route('dashboard');
});

// Guest routes (no authentication required)
Route::middleware(['guest'])->group(function () {
    Route::view('/login', 'auth.login')->name('login');
    Route::post('/login', [AuthController::class, 'loginUser']);
    Route::view('/register', 'auth.register')->name('register');
    Route::post('/register', [AuthController::class, 'registerUser']);

    // Password reset routes
    Route::view('/forgot_password', 'auth.forgot_password')->name('password.request');
    Route::post('/forgot_password', [ResetPasswordController::class, 'sendResetLink'])->name('password.email');
    Route::get('/reset_password/{token}', [ResetPasswordController::class, 'passwordReset'])->name('password.reset');
    Route::post('/reset_password', [ResetPasswordController::class, 'passwordUpdate'])->name('password.update');
});

// Authenticated routes (both admin and customer)
Route::middleware(['auth'])->group(function () {
    // Logout route
    Route::post('/logout', [AuthController::class, 'logoutUser'])->name('logout');

    // Dashboard route (redirects based on user role)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile management (both admin and customer can edit their own profile)
    Route::get('/profile/edit', [UserController::class, 'editProfile'])->name('profile.edit');
    Route::put('/profile/update', [UserController::class, 'updateProfile'])->name('profile.update');
    Route::post('/profile/change-password', [UserController::class, 'changePassword'])->name('profile.change_password');
});

// ========================================
// ADMIN ROUTES (Admin only)
// ========================================
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Admin Dashboard
    Route::get('/', [DashboardController::class, 'adminDashboard'])->name('dashboard');

    // Plot Management
    Route::get('/plots/pending', [AdminPlotController::class, 'pending'])->name('plots.pending');
    Route::post('/plots/{id}/approve', [AdminPlotController::class, 'approve'])->name('plots.approve');
    Route::post('/plots/{id}/reject', [AdminPlotController::class, 'reject'])->name('plots.reject');
    Route::get('/plots/search', [AdminPlotController::class, 'search'])->name('plots.search');
    Route::resource('plots', AdminPlotController::class);

        // User Management
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{id}/update', [UserController::class, 'update'])->name('users.update');

    // Inquiry Management
    Route::get('/inquiries', [InquiriesController::class, 'adminIndex'])->name('inquiries.index');
    Route::get('/inquiries/{inquiry}', [InquiriesController::class, 'show'])->name('inquiries.show');
    Route::get('/inquiries/{inquiry}/edit', [InquiriesController::class, 'edit'])->name('inquiries.edit');
    Route::put('/inquiries/{inquiry}', [InquiriesController::class, 'update'])->name('inquiries.update');
    Route::delete('/inquiries/{inquiry}', [InquiriesController::class, 'destroy'])->name('inquiries.destroy');

    // Reservation Management
    Route::get('/reservations', [ReservationController::class, 'adminIndex'])->name('reservations.index');
    Route::put('/reservations/{reservation}/approve', [ReservationController::class, 'approve'])->name('reservations.approve');
    Route::put('/reservations/{reservation}/reject', [ReservationController::class, 'reject'])->name('reservations.reject');
});

// ========================================
// CUSTOMER ROUTES (Customer only)
// ========================================
Route::middleware(['auth', 'customer'])->prefix('customer')->name('customer.')->group(function () {
    // Customer Dashboard
    Route::get('/', [DashboardController::class, 'customerDashboard'])->name('dashboard');

    // Plot Browsing
    Route::get('/plots', [CustomerPlotController::class, 'index'])->name('plots.index');
    Route::get('/plots/{plot}', [CustomerPlotController::class, 'show'])->name('plots.show');

    // Saved Plots
    Route::get('/saved-plots', [SavedPlotController::class, 'index'])->name('saved-plots.index');
    Route::post('/saved-plots', [SavedPlotController::class, 'store'])->name('saved-plots.store');
    Route::delete('/saved-plots/{plot_id}', [SavedPlotController::class, 'destroy'])->name('saved-plots.destroy');

    // Reservations
    Route::get('/reservations', [ReservationController::class, 'index'])->name('reservations.index');
    Route::post('/reservations', [ReservationController::class, 'store'])->name('reservations.store');
    Route::delete('/reservations/{reservation}', [ReservationController::class, 'destroy'])->name('reservations.destroy');

    // Reviews
    Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');

    // Inquiries (customer can create and view their own)
    Route::get('/inquiries', [InquiriesController::class, 'index'])->name('inquiries.index');
    Route::get('/inquiries/create', [InquiriesController::class, 'create'])->name('inquiries.create');
    Route::post('/inquiries', [InquiriesController::class, 'store'])->name('inquiries.store');
    Route::get('/inquiries/{inquiry}', [InquiriesController::class, 'show'])->name('inquiries.show');
});

// Legacy routes for backward compatibility (redirect to appropriate areas)
Route::middleware(['auth'])->group(function () {
    // Redirect old plot routes to appropriate areas
    Route::get('/plots', function () {
        return auth()->user()->isAdmin()
            ? redirect()->route('admin.plots.index')
            : redirect()->route('customer.plots.index');
    })->name('plots.index');

    Route::get('/plots/create', function () {
        return auth()->user()->isAdmin()
            ? redirect()->route('admin.plots.create')
            : abort(403, 'Access denied.');
    })->name('plots.create');

    // Redirect old user routes
    Route::get('/users', function () {
        return auth()->user()->isAdmin()
            ? redirect()->route('admin.users.index')
            : redirect()->route('customer.dashboard');
    })->name('user.index');

    // Redirect old inquiry routes
    Route::get('/inquiries', function () {
        return auth()->user()->isAdmin()
            ? redirect()->route('admin.inquiries.index')
            : redirect()->route('customer.inquiries.index');
    })->name('inquiries.index');
});




