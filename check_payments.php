<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Payment;

echo "=== PAYMENT DATABASE CHECK ===\n\n";

// Get total count
$totalPayments = Payment::count();
echo "Total payments: {$totalPayments}\n\n";

// Get latest 5 payments
$latestPayments = Payment::with('user')->orderBy('id', 'desc')->take(5)->get();

echo "Latest 5 payments:\n";
echo str_repeat('-', 80) . "\n";
echo sprintf("%-5s %-20s %-15s %-10s %-20s %-15s\n", 'ID', 'User', 'Amount', 'Status', 'Transaction ID', 'Created');
echo str_repeat('-', 80) . "\n";

foreach ($latestPayments as $payment) {
    $userName = $payment->user ? $payment->user->name : 'N/A';
    $transactionId = $payment->transaction_id ?: 'N/A';
    
    echo sprintf("%-5s %-20s %-15s %-10s %-20s %-15s\n", 
        $payment->id,
        substr($userName, 0, 19),
        'MWK ' . number_format($payment->amount, 2),
        $payment->status,
        substr($transactionId, 0, 19),
        $payment->created_at->format('M d H:i')
    );
}

echo str_repeat('-', 80) . "\n\n";

// Status breakdown
echo "Status breakdown:\n";
$statuses = Payment::selectRaw('status, count(*) as count')->groupBy('status')->get();
foreach ($statuses as $status) {
    echo "  {$status->status}: {$status->count}\n";
}

echo "\n=== END ===\n"; 