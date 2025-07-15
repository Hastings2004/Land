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
use Illuminate\Support\Facades\Auth;

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

// Default welcome route - only guests see the welcome page
Route::get('/', function () {
    if (Auth::check()) {
        // Redirect logged-in users to their dashboard
        return redirect()->route(Auth::user()->role === 'admin' ? 'admin.dashboard' : 'customer.dashboard');
    }
    // Show welcome page to guests only
    return view('welcome');
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

    // Payment Management
    Route::get('/payments', [\App\Http\Controllers\PaymentController::class, 'adminIndex'])->name('payments.index');
    Route::get('/payments/{payment}', [\App\Http\Controllers\PaymentController::class, 'adminShow'])->name('payments.show');

    // Notification Management
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/mark-read', [NotificationController::class, 'markAsRead'])->name('notifications.mark-read');
    Route::post('/notifications/mark-all-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.mark-all-read');
    Route::get('/notifications/unread-count', [NotificationController::class, 'getUnreadCount'])->name('notifications.unread-count');
    Route::get('/notifications/all', [NotificationController::class, 'getAll'])->name('notifications.all');

    // Admin notifications page (Blade view)
    Route::get('/notifications/all/view', [NotificationController::class, 'showAll'])->name('notifications.all.view');
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
    Route::post('/reservations/{reservation}/pay', [\App\Http\Controllers\PaymentController::class, 'pay'])->name('reservations.pay');
    Route::get('/reservations/{reservation}', [\App\Http\Controllers\ReservationController::class, 'show'])->name('reservation.show');

    // Customer inquiries
    Route::get('/inquiries', [\App\Http\Controllers\InquiriesController::class, 'customerIndex'])->name('inquiries.index');
    Route::get('/inquiries/create', [\App\Http\Controllers\InquiriesController::class, 'customerCreate'])->name('inquiries.create');
    Route::post('/inquiries', [\App\Http\Controllers\InquiriesController::class, 'customerStore'])->name('inquiries.store');
    Route::get('/inquiries/{inquiry}', [\App\Http\Controllers\InquiriesController::class, 'customerShow'])->name('inquiries.show');
    Route::get('/inquiries/{inquiry}/edit', [\App\Http\Controllers\InquiriesController::class, 'customerEdit'])->name('inquiries.edit');
    Route::put('/inquiries/{inquiry}', [\App\Http\Controllers\InquiriesController::class, 'customerUpdate'])->name('inquiries.update');
    Route::delete('/inquiries/{inquiry}', [\App\Http\Controllers\InquiriesController::class, 'customerDestroy'])->name('inquiries.destroy');
    Route::post('/inquiries/{inquiry}/restore', [\App\Http\Controllers\InquiriesController::class, 'customerRestore'])->name('inquiries.restore');
    Route::delete('/inquiries/{inquiry}/permanent-delete', [\App\Http\Controllers\InquiriesController::class, 'customerPermanentDelete'])->name('inquiries.permanent-delete');

    // Customer notifications page (Blade view)
    Route::get('/notifications/all/view', [\App\Http\Controllers\NotificationController::class, 'showAll'])->name('notifications.all.view');
    Route::get('/notifications', [\App\Http\Controllers\NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/mark-read', [\App\Http\Controllers\NotificationController::class, 'markAsRead'])->name('notifications.mark-read');
    Route::post('/notifications/mark-all-read', [\App\Http\Controllers\NotificationController::class, 'markAllAsRead'])->name('notifications.mark-all-read');
    Route::get('/notifications/unread-count', [\App\Http\Controllers\NotificationController::class, 'getUnreadCount'])->name('notifications.unread-count');
    Route::get('/notifications/all', [\App\Http\Controllers\NotificationController::class, 'getAll'])->name('notifications.all');
});

// Fallback GET route for payment to prevent MethodNotAllowedHttpException
Route::get('/customer/reservations/{reservation}/pay', function () {
    return redirect()->route('customer.reservations.index');
});

// Payment callback route for PayChangu (must be public)
Route::post('/payments/callback', [\App\Http\Controllers\PaymentController::class, 'callback'])->name('payments.callback');

// Add GET route for PayChangu return_url redirect
Route::get('/payments/callback', function (\Illuminate\Http\Request $request) {
    $status = $request->query('status');
    $txRef = $request->query('tx_ref');
    if ($status === 'success') {
        return redirect()->route('customer.reservations.index')->with('success', 'Payment successful! Reference: ' . $txRef);
    } else {
        return redirect()->route('customer.reservations.index')->with('error', 'Payment failed or cancelled. Please try again.');
    }
});

// Payment verification routes (for manual verification)
Route::get('/payments/verify/{tx_ref}', [\App\Http\Controllers\PaymentController::class, 'verifyPayment'])->name('payments.verify');
Route::post('/payments/{payment}/verify', [\App\Http\Controllers\PaymentController::class, 'manualVerify'])->name('payments.manual-verify');
Route::post('/payments/{payment}/store-tx-ref', [\App\Http\Controllers\PaymentController::class, 'storeTxRef'])->name('payments.store-tx-ref');

// Test route to simulate Paychangu callback (for debugging - remove in production)
Route::get('/test-paychangu-callback/{payment_id}', function($payment_id) {
    $payment = \App\Models\Payment::find($payment_id);
    if (!$payment) {
        return response()->json(['error' => 'Payment not found'], 404);
    }
    
    // Simulate Paychangu callback data
    $callbackData = [
        'transaction_id' => 'TXN_' . time(),
        'status' => 'success',
        'payment_id' => $payment_id,
        'amount' => $payment->amount,
        'currency' => 'MWK',
        'tx_ref' => 'RES-' . $payment_id . '-' . time(),
        'customer_email' => $payment->user->email,
        'customer_name' => $payment->user->name,
    ];
    
    // Make POST request to callback endpoint
    $response = \Illuminate\Support\Facades\Http::post(url('/payments/callback'), $callbackData);
    
    return response()->json([
        'message' => 'Test callback sent',
        'callback_data' => $callbackData,
        'response' => $response->json()
    ]);
})->name('test.paychangu.callback');

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

// Public payment success page for PayChangu return_url (must remain unprotected)
Route::get('/payments/success', function () {
    return view('payments.success');
})->name('payments.success');

Route::get('/payments/card', [\App\Http\Controllers\PaymentController::class, 'showCardForm'])->name('payments.card');
Route::post('/payments/charge', [\App\Http\Controllers\PaymentController::class, 'charge'])->name('payments.charge');
Route::get('/payments/3ds-redirect', [\App\Http\Controllers\PaymentController::class, 'handle3dsRedirect'])->name('payments.3ds-redirect');
Route::get('/payments/verify/{charge_id}', [\App\Http\Controllers\PaymentController::class, 'verifyCharge'])->name('payments.verify');
Route::get('/payments/inline-demo', function () {
    return view('payments.inline-demo');
})->name('payments.inline-demo');




