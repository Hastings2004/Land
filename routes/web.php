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
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ContactController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Test route for debugging sessions
Route::get('/test-session', function () {
    session(['test' => 'Session is working!']);
    return 'Session test: ' . session('test');
});

// Debug route to check session and success message
Route::get('/debug-success', function () {
    // Set a test success message
    session(['success' => 'Debug: This is a test success message!']);
    
    // Check if session is working
    $sessionData = session()->all();
    
    return response()->json([
        'session_working' => session('success') ? 'Yes' : 'No',
        'success_message' => session('success'),
        'all_session_data' => $sessionData
    ]);
});

// Test route for success message component
Route::get('/test-success', function () {
    session(['success' => 'This is a test success message!']);
    return view('auth.login');
});

// Test route for logout success message component
Route::get('/test-logout-success', function () {
    session(['success' => 'Goodbye, TestUser! You have been logged out successfully. Come back soon!']);
    return view('auth.login');
});

// Test page for success message components
Route::get('/test-success-page', function () {
    return view('test-success');
});

// Simple test page
Route::get('/test-simple', function () {
    return view('test-simple');
});

// Test redirect with success message
Route::get('/test-redirect-success', function () {
    session(['success' => 'This is a test success message from redirect!']);
    return redirect('/test-simple');
});

// Test setting success message via POST
Route::post('/test-set-success', function () {
    session(['success' => 'This is a test success message from POST!']);
    return redirect('/test-simple');
});

// Test URL parameter success message
Route::get('/test-url-success', function () {
    $message = 'This is a test success message from URL parameter!';
    return redirect('/test-simple?success=' . urlencode($message));
});

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

    // Contact form submission (both admin and customer can use)
    Route::post('/contact/submit', [ContactController::class, 'submit'])->name('contact.submit');

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
    Route::put('/inquiries/{inquiry}', [InquiriesController::class, 'adminUpdate'])->name('inquiries.update');
    Route::delete('/inquiries/{inquiry}', [InquiriesController::class, 'destroy'])->name('inquiries.destroy');
    Route::post('/inquiries/{inquiry}/restore', [InquiriesController::class, 'adminRestore'])->name('inquiries.restore');
    Route::delete('/inquiries/{inquiry}/permanent-delete', [InquiriesController::class, 'adminPermanentDelete'])->name('inquiries.permanent-delete');

    // Reservation Management
    Route::get('/reservations', [ReservationController::class, 'adminIndex'])->name('reservations.index');
    Route::put('/reservations/{reservation}/approve', [ReservationController::class, 'approve'])->name('reservations.approve');
    Route::put('/reservations/{reservation}/reject', [ReservationController::class, 'reject'])->name('reservations.reject');

    // Notification Management
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/mark-read', [NotificationController::class, 'markAsRead'])->name('notifications.mark-read');
    Route::post('/notifications/mark-all-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.mark-all-read');
    Route::get('/notifications/unread-count', [NotificationController::class, 'getUnreadCount'])->name('notifications.unread-count');
    Route::get('/notifications/all', [NotificationController::class, 'getAll'])->name('notifications.all');

    // Admin notifications page (Blade view)
    Route::get('/notifications/all/view', [NotificationController::class, 'showAll'])->name('admin.notifications.all.view');
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
    Route::get('/inquiries', [InquiriesController::class, 'customerIndex'])->name('inquiries.index');
    Route::get('/inquiries/create', [InquiriesController::class, 'customerCreate'])->name('inquiries.create');
    Route::post('/inquiries', [InquiriesController::class, 'customerStore'])->name('inquiries.store');
    Route::get('/inquiries/{inquiry}', [InquiriesController::class, 'customerShow'])->name('inquiries.show');
    Route::get('/inquiries/{inquiry}/edit', [InquiriesController::class, 'customerEdit'])->name('inquiries.edit');
    Route::put('/inquiries/{inquiry}', [InquiriesController::class, 'customerUpdate'])->name('inquiries.update');
    Route::delete('/inquiries/{inquiry}', [InquiriesController::class, 'customerDestroy'])->name('inquiries.destroy');
    Route::post('/inquiries/{inquiry}/restore', [InquiriesController::class, 'customerRestore'])->name('inquiries.restore');
    Route::delete('/inquiries/{inquiry}/permanent-delete', [InquiriesController::class, 'customerPermanentDelete'])->name('inquiries.permanent-delete');

    // Notification Management
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/mark-read', [NotificationController::class, 'markAsRead'])->name('notifications.mark-read');
    Route::post('/notifications/mark-all-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.mark-all-read');
    Route::get('/notifications/unread-count', [NotificationController::class, 'getUnreadCount'])->name('notifications.unread-count');
    Route::get('/notifications/all', [NotificationController::class, 'getAll'])->name('notifications.all');

    // Customer notifications page (Blade view)
    Route::get('/notifications/all/view', [NotificationController::class, 'showAll'])->name('customer.notifications.all.view');
});

// Legacy routes for backward compatibility (redirect to appropriate areas)
Route::middleware(['auth'])->group(function () {
    // Redirect old plot routes to appropriate areas
    Route::get('/plots', function () {
        return \Illuminate\Support\Facades\Auth::user()->role === 'admin'
            ? redirect()->route('admin.plots.index')
            : redirect()->route('customer.plots.index');
    })->name('plots.index');

    Route::get('/plots/create', function () {
        return \Illuminate\Support\Facades\Auth::user()->role === 'admin'
            ? redirect()->route('admin.plots.create')
            : abort(403, 'Access denied.');
    })->name('plots.create');

    // Redirect old user routes
    Route::get('/users', function () {
        return \Illuminate\Support\Facades\Auth::user()->role === 'admin'
            ? redirect()->route('admin.users.index')
            : redirect()->route('customer.dashboard');
    })->name('user.index');

    // Redirect old inquiry routes
    Route::get('/inquiries', function () {
        return \Illuminate\Support\Facades\Auth::user()->role === 'admin'
            ? redirect()->route('admin.inquiries.index')
            : redirect()->route('customer.inquiries.index');
    })->name('inquiries.index');
});




