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
    
//Route::get('plots/{plot}', [CustomerPlotController::class, 'show'])->name('customer.plots.show');

// Default welcome route - redirects to the main dashboard
Route::get('/', function () {
    return redirect()->route('/dashboard');
});

Route::resource("inquiries", InquiriesController::class);
// Routes that require authentication for both customers and admins
Route::middleware(['auth'])->group(function () {   
    
    // Logout route
    Route::post('/logout', [AuthController::class, 'logoutUser'])->name('logout');
    Route::get('/dashboard', [DashboardController::class, "index"])->name('dashboard');
    
    Route::resource('plots', AdminPlotController::class);
    Route::get('/plots/search', [AdminPlotController::class, 'search'])->name('plots.search');
    
    // Customer plot routes
    Route::get('/customer/plots', [CustomerPlotController::class, 'index'])->name('customer.plots.index');
    Route::get('/customer/plots/{plot}', [CustomerPlotController::class, 'show'])->name('customer.plots.show');

    Route::get('/users', [UserController::class, 'index'])->name('user.index');
    Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('user.edit');
    Route::put('/users/{id}/update', [UserController::class, 'update'])->name('user.update');
    Route::post('/users/{id}/change-password', [UserController::class, 'changePassword'])->name('user.change_password');

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
});

// Guest routes
Route::middleware(['guest'])->group(function () {
    Route::view('/', 'auth.login')->name('home');
    Route::view('/register', 'auth.register')->name('register');
    Route::post('/register', [AuthController::class, 'registerUser']);
    Route::view('/login', 'auth.login')->name('login');
    Route::post('/login', [AuthController::class, 'loginUser']);

    // Password reset routes
    Route::view('/forgot_password', 'auth.forgot_password')->name('password.request');
    Route::post('/forgot_password', [ResetPasswordController::class, 'sendResetLink'])->name('password.email');
    Route::get('/reset_password/{token}',[ResetPasswordController::class, 'passwordReset'] )->name('password.reset');
    Route::post('/reset_password', [ResetPasswordController::class, 'passwordUpdate'])->name('password.update');
    });
 



