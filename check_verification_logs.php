<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Payment;

echo "=== PAYCHANGU VERIFICATION LOGS CHECK ===\n\n";

// Check if Paychangu credentials are configured
$publicKey = env('PAYCHANGU_PUBLIC_KEY');
$secretKey = env('PAYCHANGU_SECRET_KEY');
$apiKey = env('PAYCHANGU_API_KEY');
$merchantId = env('PAYCHANGU_MERCHANT_ID');

echo "🔑 PAYCHANGU CREDENTIALS STATUS:\n";
echo "Public Key: " . ($publicKey ? "✅ Configured" : "❌ Missing") . "\n";
echo "Secret Key: " . ($secretKey ? "✅ Configured" : "❌ Missing") . "\n";
echo "API Key: " . ($apiKey ? "✅ Configured" : "❌ Missing") . "\n";
echo "Merchant ID: " . ($merchantId ? "✅ Configured" : "❌ Missing") . "\n\n";

if (!$secretKey) {
    echo "❌ ERROR: Paychangu secret key not configured!\n";
    echo "Add this to your .env file:\n";
    echo "PAYCHANGU_SECRET_KEY=your_secret_key_here\n\n";
    exit(1);
}

// Get latest payment with provider_data
$latestPayment = Payment::whereNotNull('provider_data')
    ->orderBy('updated_at', 'desc')
    ->first();

if ($latestPayment) {
    echo "📋 LATEST PAYMENT WITH PROVIDER DATA:\n";
    echo "Payment ID: {$latestPayment->id}\n";
    echo "Status: {$latestPayment->status}\n";
    echo "Transaction ID: " . ($latestPayment->transaction_id ?: 'N/A') . "\n";
    echo "Updated: {$latestPayment->updated_at}\n\n";
    
    $providerData = json_decode($latestPayment->provider_data, true);
    if ($providerData) {
        echo "📄 PROVIDER DATA STRUCTURE:\n";
        echo json_encode($providerData, JSON_PRETTY_PRINT) . "\n\n";
    }
} else {
    echo "📋 NO PAYMENTS WITH PROVIDER DATA FOUND\n\n";
}

// Check for verification attempts in logs
echo "🔍 VERIFICATION LOGS LOCATIONS:\n";
echo "1. Laravel Logs: storage/logs/laravel.log\n";
echo "2. Payment Records: provider_data column in payments table\n";
echo "3. Console Output: When running verification commands\n\n";

echo "📝 LOGGED VERIFICATION EVENTS:\n";
echo "- Payment verification attempts\n";
echo "- API responses from Paychangu\n";
echo "- Error messages and debugging info\n";
echo "- Callback processing results\n\n";

echo "🚀 TO SEE VERIFICATION RESPONSES:\n";
echo "1. Add your Paychangu credentials to .env\n";
echo "2. Run: php artisan payments:verify --payment-id=9\n";
echo "3. Check: storage/logs/laravel.log\n";
echo "4. Or use admin dashboard: /admin/payments\n\n";

echo "=== END ===\n"; 