<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Payment;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class VerifyPayments extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'payments:verify {--payment-id= : Verify specific payment by ID} {--all : Verify all pending payments}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Verify payment status using Paychangu API';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $secretKey = env('PAYCHANGU_SECRET_KEY');
        if (!$secretKey) {
            $this->error('Paychangu secret key not configured in .env file');
            return 1;
        }

        if ($paymentId = $this->option('payment-id')) {
            $this->verifySpecificPayment($paymentId, $secretKey);
        } elseif ($this->option('all')) {
            $this->verifyAllPendingPayments($secretKey);
        } else {
            $this->error('Please specify --payment-id or --all option');
            return 1;
        }

        return 0;
    }

    /**
     * Verify a specific payment
     */
    private function verifySpecificPayment($paymentId, $secretKey)
    {
        $payment = Payment::find($paymentId);
        if (!$payment) {
            $this->error("Payment #{$paymentId} not found");
            return;
        }

        $this->info("Verifying payment #{$paymentId}...");
        $this->verifyPayment($payment, $secretKey);
    }

    /**
     * Verify all pending payments
     */
    private function verifyAllPendingPayments($secretKey)
    {
        $pendingPayments = Payment::where('status', 'pending')
            ->where('provider', 'paychangu')
            ->get();

        if ($pendingPayments->isEmpty()) {
            $this->info('No pending payments found');
            return;
        }

        $this->info("Found {$pendingPayments->count()} pending payments to verify...");

        $bar = $this->output->createProgressBar($pendingPayments->count());
        $bar->start();

        foreach ($pendingPayments as $payment) {
            $this->verifyPayment($payment, $secretKey);
            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info('Payment verification completed!');
    }

    /**
     * Verify a single payment
     */
    private function verifyPayment(Payment $payment, $secretKey)
    {
        try {
            // Extract tx_ref from provider_data
            $providerData = json_decode($payment->provider_data, true);
            $txRef = $providerData['tx_ref'] ?? null;

            if (!$txRef) {
                $this->warn("No tx_ref found for payment #{$payment->id}");
                return;
            }

            // Make API call to Paychangu
            $response = Http::withHeaders([
                'Accept' => 'application/json',
                'Authorization' => 'Bearer ' . $secretKey,
            ])->get("https://api.paychangu.com/verify-payment/{$txRef}");

            if (!$response->successful()) {
                $this->warn("API call failed for payment #{$payment->id}: HTTP {$response->status()}");
                return;
            }

            $apiResponse = $response->json();
            
            // Check if the API response is successful
            if ($apiResponse['status'] !== 'success') {
                $this->warn("API returned error for payment #{$payment->id}: " . ($apiResponse['message'] ?? 'Unknown error'));
                return;
            }

            $paymentData = $apiResponse['data'];
            $status = $paymentData['status'] ?? 'unknown';
            $reference = $paymentData['reference'] ?? null;
            $amount = $paymentData['amount'] ?? null;
            $currency = $paymentData['currency'] ?? null;
            $customerEmail = $paymentData['customer']['email'] ?? null;
            $customerName = ($paymentData['customer']['first_name'] ?? '') . ' ' . ($paymentData['customer']['last_name'] ?? '');
            $authorization = $paymentData['authorization'] ?? null;
            $logs = $paymentData['logs'] ?? [];

            // Update payment with comprehensive data
            $payment->update([
                'status' => $status,
                'transaction_id' => $reference,
                'provider_data' => json_encode([
                    'api_response' => $apiResponse,
                    'payment_details' => [
                        'tx_ref' => $paymentData['tx_ref'],
                        'reference' => $reference,
                        'amount' => $amount,
                        'currency' => $currency,
                        'status' => $status,
                        'mode' => $paymentData['mode'] ?? null,
                        'type' => $paymentData['type'] ?? null,
                        'event_type' => $paymentData['event_type'] ?? null,
                        'number_of_attempts' => $paymentData['number_of_attempts'] ?? null,
                        'customer' => [
                            'email' => $customerEmail,
                            'name' => trim($customerName)
                        ],
                        'authorization' => $authorization,
                        'logs' => $logs,
                        'created_at' => $paymentData['created_at'] ?? null,
                        'updated_at' => $paymentData['updated_at'] ?? null,
                        'customization' => $paymentData['customization'] ?? null,
                        'meta' => $paymentData['meta'] ?? null
                    ],
                    'verified_at' => now()->toISOString(),
                    'verification_method' => 'console_command'
                ]),
            ]);

            $this->info("Payment #{$payment->id} updated: {$payment->status} → {$status} (Ref: {$reference})");

            // Log the verification
            Log::info('Payment verified via command', [
                'payment_id' => $payment->id,
                'tx_ref' => $txRef,
                'old_status' => $payment->status,
                'new_status' => $status,
                'reference' => $reference,
                'amount' => $amount,
                'customer_email' => $customerEmail
            ]);

        } catch (\Exception $e) {
            $this->error("Error verifying payment #{$payment->id}: " . $e->getMessage());
            Log::error('Payment verification command error', [
                'payment_id' => $payment->id,
                'error' => $e->getMessage()
            ]);
        }
    }
}
