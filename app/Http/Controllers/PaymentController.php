<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;

class PaymentController extends Controller
{
    // Initiate payment and return JS for PayChangu inline pop-out
    public function pay(Request $request, Reservation $reservation)
    {
        $user = Auth::user();
        $amount = $reservation->plot->price;
        $paychanguPublicKey = env('PAYCHANGU_PUBLIC_KEY');
        $paychanguApiKey = env('PAYCHANGU_API_KEY');
        $paychanguMerchantId = env('PAYCHANGU_MERCHANT_ID');
        $callbackUrl = route('payments.callback');

        // Create a payment record (pending)
        $payment = Payment::create([
            'user_id' => $user->id,
            'plot_id' => $reservation->plot_id,
            'reservation_id' => $reservation->id,
            'amount' => $amount,
            'status' => 'pending',
            'provider' => 'paychangu',
        ]);

        return response()->view('payments.inline', [
            'amount' => $amount,
            'user' => $user,
            'payment' => $payment,
            'callbackUrl' => $callbackUrl,
            'reservation' => $reservation,
            'paychanguPublicKey' => $paychanguPublicKey,
            'paychanguApiKey' => $paychanguApiKey,
            'paychanguMerchantId' => $paychanguMerchantId,
        ]);
    }

    /**
     * Store tx_ref in payment record
     */
    public function storeTxRef(Request $request, Payment $payment)
    {
        try {
            $txRef = $request->input('tx_ref');
            
            if (!$txRef) {
                return response()->json(['error' => 'tx_ref is required'], 400);
            }

            // Update payment with tx_ref
            $currentData = json_decode($payment->provider_data, true) ?: [];
            $currentData['tx_ref'] = $txRef;
            $currentData['stored_at'] = now()->toISOString();

            $payment->update([
                'provider_data' => json_encode($currentData)
            ]);

            Log::info('Tx_ref stored for payment', [
                'payment_id' => $payment->id,
                'tx_ref' => $txRef
            ]);

            return response()->json(['success' => true, 'message' => 'Tx_ref stored successfully']);

        } catch (\Exception $e) {
            Log::error('Error storing tx_ref', [
                'payment_id' => $payment->id,
                'error' => $e->getMessage()
            ]);
            
            return response()->json(['error' => 'Failed to store tx_ref'], 500);
        }
    }

    /**
     * Handle PayChangu callback/webhook
     */
    public function callback(Request $request)
    {
        try {
            // Log the incoming callback data
            Log::info('PayChangu callback received', [
                'headers' => $request->headers->all(),
                'payload' => $request->all(),
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent()
            ]);

            // Validate the callback data
            $validator = Validator::make($request->all(), [
                'transaction_id' => 'required|string',
                'status' => 'required|string|in:success,failed,pending,cancelled',
                'payment_id' => 'required|integer|exists:payments,id',
                'amount' => 'required|numeric',
                'currency' => 'required|string',
                'tx_ref' => 'required|string',
                // Add signature validation if Paychangu provides it
                // 'signature' => 'required|string',
            ]);

            if ($validator->fails()) {
                Log::error('PayChangu callback validation failed', [
                    'errors' => $validator->errors()->toArray(),
                    'payload' => $request->all()
                ]);
                return response()->json(['error' => 'Invalid callback data'], 400);
            }

            // Verify signature if Paychangu provides one (recommended for security)
            // $this->verifyPaychanguSignature($request);

            // Extract validated data
        $transactionId = $request->input('transaction_id');
        $status = $request->input('status');
        $paymentId = $request->input('payment_id');
            $amount = $request->input('amount');
            $currency = $request->input('currency');
            $txRef = $request->input('tx_ref');

            // Find the payment record
        $payment = Payment::find($paymentId);
            if (!$payment) {
                Log::error('PayChangu callback: Payment not found', [
                    'payment_id' => $paymentId,
                    'transaction_id' => $transactionId
                ]);
                return response()->json(['error' => 'Payment not found'], 404);
            }

            // Verify amount matches
            if ($payment->amount != $amount) {
                Log::error('PayChangu callback: Amount mismatch', [
                    'expected' => $payment->amount,
                    'received' => $amount,
                    'payment_id' => $paymentId
                ]);
                return response()->json(['error' => 'Amount mismatch'], 400);
            }

            // Update payment record
            $payment->update([
                'status' => $status,
                'transaction_id' => $transactionId,
                'provider_data' => json_encode($request->all()), // Store full response for debugging
            ]);

            Log::info('PayChangu payment updated', [
                'payment_id' => $payment->id,
                'transaction_id' => $transactionId,
                'status' => $status,
                'amount' => $amount
            ]);

            // Handle different payment statuses
            switch ($status) {
                case 'success':
                    $this->handleSuccessfulPayment($payment);
                    // Redirect to reservation details page after successful payment
                    return redirect()->route('reservation.show', ['reservation' => $payment->reservation_id])
                        ->with('success', 'Payment successful!');
                case 'failed':
                    $this->handleFailedPayment($payment);
                    break;
                case 'cancelled':
                    $this->handleCancelledPayment($payment);
                    break;
                case 'pending':
                    $this->handlePendingPayment($payment);
                    break;
                default:
                    Log::warning('PayChangu callback: Unknown status', ['status' => $status]);
            }

            return response()->json(['success' => true, 'message' => 'Callback processed successfully']);

        } catch (\Exception $e) {
            Log::error('PayChangu callback error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'payload' => $request->all()
            ]);
            
            return response()->json(['error' => 'Internal server error'], 500);
        }
    }

    /**
     * Verify payment status using Paychangu API
     */
    public function verifyPayment(Request $request, $txRef)
    {
        try {
            Log::info('Verifying payment with Paychangu API', ['tx_ref' => $txRef]);

            $secretKey = env('PAYCHANGU_SECRET_KEY');
            if (!$secretKey) {
                Log::error('Paychangu secret key not configured');
                return response()->json(['error' => 'Payment verification not configured'], 500);
            }

            // Make API call to Paychangu
            $response = Http::withHeaders([
                'Accept' => 'application/json',
                'Authorization' => 'Bearer ' . $secretKey,
            ])->get("https://api.paychangu.com/verify-payment/{$txRef}");

            Log::info('Paychangu API response', [
                'status_code' => $response->status(),
                'response' => $response->json()
            ]);

            if (!$response->successful()) {
                Log::error('Paychangu API error', [
                    'status_code' => $response->status(),
                    'response' => $response->body()
                ]);
                return response()->json(['error' => 'Failed to verify payment'], 500);
            }

            $apiResponse = $response->json();
            
            // Check if the API response is successful
            if ($apiResponse['status'] !== 'success') {
                Log::error('Paychangu API returned error', ['response' => $apiResponse]);
                return response()->json(['error' => 'Payment verification failed'], 500);
            }

            $paymentData = $apiResponse['data'];
            
            // Find payment by tx_ref
            $payment = Payment::where('provider_data', 'like', '%"tx_ref":"' . $txRef . '"%')
                ->orWhere('provider_data', 'like', '%"tx_ref":"' . $paymentData['tx_ref'] . '"%')
                ->first();
            
            if (!$payment) {
                Log::warning('Payment not found for tx_ref', ['tx_ref' => $txRef]);
                return response()->json(['error' => 'Payment not found'], 404);
            }

            // Extract payment details from Paychangu response
            $status = $paymentData['status'] ?? 'unknown';
            $reference = $paymentData['reference'] ?? null;
            $amount = $paymentData['amount'] ?? null;
            $currency = $paymentData['currency'] ?? null;
            $charges = $paymentData['charges'] ?? null;
            $customerEmail = $paymentData['customer']['email'] ?? null;
            $customerName = $paymentData['customer']['first_name'] . ' ' . $paymentData['customer']['last_name'] ?? null;
            $authorization = $paymentData['authorization'] ?? null;
            $logs = $paymentData['logs'] ?? [];
            $createdAt = $paymentData['created_at'] ?? null;
            $updatedAt = $paymentData['updated_at'] ?? null;

            // Verify amount matches (convert to decimal if needed)
            if ($amount && $payment->amount != $amount) {
                Log::error('Paychangu API: Amount mismatch', [
                    'expected' => $payment->amount,
                    'received' => $amount,
                    'payment_id' => $payment->id
                ]);
                return response()->json(['error' => 'Amount mismatch'], 400);
            }

            // Update payment record with comprehensive data
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
                        'charges' => $charges,
                        'status' => $status,
                        'mode' => $paymentData['mode'] ?? null,
                        'type' => $paymentData['type'] ?? null,
                        'event_type' => $paymentData['event_type'] ?? null,
                        'number_of_attempts' => $paymentData['number_of_attempts'] ?? null,
                        'customer' => [
                            'email' => $customerEmail,
                            'name' => $customerName
                        ],
                        'authorization' => $authorization,
                        'logs' => $logs,
                        'created_at' => $createdAt,
                        'updated_at' => $updatedAt,
                        'customization' => $paymentData['customization'] ?? null,
                        'meta' => $paymentData['meta'] ?? null
                    ],
                    'verified_at' => now()->toISOString(),
                    'verification_method' => 'api_call'
                ]),
            ]);

            Log::info('Payment verified and updated via API', [
                'payment_id' => $payment->id,
                'tx_ref' => $txRef,
                'status' => $status,
                'reference' => $reference,
                'amount' => $amount,
                'customer_email' => $customerEmail
            ]);

            // Handle payment status
            switch ($status) {
                case 'success':
                    $this->handleSuccessfulPayment($payment);
                    break;
                case 'failed':
                    $this->handleFailedPayment($payment);
                    break;
                case 'cancelled':
                    $this->handleCancelledPayment($payment);
                    break;
                case 'pending':
                    $this->handlePendingPayment($payment);
                    break;
                default:
                    Log::warning('Unknown payment status from API', ['status' => $status]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Payment verified successfully',
                'payment' => $payment->fresh(),
                'verification_data' => [
                    'tx_ref' => $paymentData['tx_ref'],
                    'reference' => $reference,
                    'status' => $status,
                    'amount' => $amount,
                    'currency' => $currency,
                    'customer' => [
                        'email' => $customerEmail,
                        'name' => $customerName
                    ],
                    'authorization' => $authorization,
                    'verified_at' => now()->toISOString()
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('Payment verification error', [
                'tx_ref' => $txRef,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json(['error' => 'Verification failed: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Manual payment verification endpoint (for admin use)
     */
    public function manualVerify(Request $request, Payment $payment)
    {
        try {
            // Extract tx_ref from provider_data
            $providerData = json_decode($payment->provider_data, true);
            $txRef = $providerData['tx_ref'] ?? null;

            if (!$txRef) {
                return response()->json(['error' => 'No tx_ref found for this payment'], 400);
            }

            return $this->verifyPayment($request, $txRef);

        } catch (\Exception $e) {
            Log::error('Manual payment verification error', [
                'payment_id' => $payment->id,
                'error' => $e->getMessage()
            ]);
            
            return response()->json(['error' => 'Manual verification failed'], 500);
        }
    }

    /**
     * Admin: View all payments
     */
    public function adminIndex()
    {
        $payments = Payment::with(['user', 'reservation', 'plot'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.payments.index', compact('payments'));
    }

    /**
     * Admin: Get payment details (JSON)
     */
    public function adminShow(Payment $payment)
    {
        $payment->load(['user', 'reservation', 'plot']);
        
        return response()->json([
            'success' => true,
            'payment' => $payment
        ]);
    }

    /**
     * Handle successful payment
     */
    private function handleSuccessfulPayment(Payment $payment)
    {
        try {
            // Update reservation status
            if ($payment->reservation) {
                $payment->reservation->update(['status' => 'completed']);
                
                Log::info('Reservation completed after successful payment', [
                    'reservation_id' => $payment->reservation->id,
                    'payment_id' => $payment->id
                ]);

                // Mark the plot as sold
                $plot = $payment->reservation->plot;
                if ($plot) {
                    $plot->status = 'sold';
                    $plot->save();
                    Log::info('Plot marked as sold after successful payment', [
                        'plot_id' => $plot->id,
                        'payment_id' => $payment->id
                    ]);
                }

                // Send notification to user
                $payment->user->notify(new \App\Notifications\ReservationPaidNotification($payment->reservation));
            }

            // Send notification to admin
            $this->notifyAdminOfPayment($payment, 'success');

        } catch (\Exception $e) {
            Log::error('Error handling successful payment', [
                'payment_id' => $payment->id,
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Handle failed payment
     */
    private function handleFailedPayment(Payment $payment)
    {
        try {
            // Update reservation status if needed
            if ($payment->reservation && $payment->reservation->status === 'pending') {
                $payment->reservation->update(['status' => 'payment_failed']);
            }

            // Send notification to user
            $payment->user->notify(new \App\Notifications\ReservationCancelledNotification($payment->reservation));

            // Send notification to admin
            $this->notifyAdminOfPayment($payment, 'failed');

        } catch (\Exception $e) {
            Log::error('Error handling failed payment', [
                'payment_id' => $payment->id,
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Handle cancelled payment
     */
    private function handleCancelledPayment(Payment $payment)
    {
        try {
            // Update reservation status if needed
            if ($payment->reservation && $payment->reservation->status === 'pending') {
                $payment->reservation->update(['status' => 'cancelled']);
            }

            // Send notification to admin
            $this->notifyAdminOfPayment($payment, 'cancelled');

        } catch (\Exception $e) {
            Log::error('Error handling cancelled payment', [
                'payment_id' => $payment->id,
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Handle pending payment
     */
    private function handlePendingPayment(Payment $payment)
    {
        try {
            Log::info('Payment is pending', [
                'payment_id' => $payment->id,
                'transaction_id' => $payment->transaction_id
            ]);

            // Send notification to admin
            $this->notifyAdminOfPayment($payment, 'pending');

        } catch (\Exception $e) {
            Log::error('Error handling pending payment', [
                'payment_id' => $payment->id,
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Notify admin of payment status
     */
    private function notifyAdminOfPayment(Payment $payment, $status)
    {
        try {
            $statusMessages = [
                'success' => 'Payment completed successfully',
                'failed' => 'Payment failed',
                'cancelled' => 'Payment was cancelled',
                'pending' => 'Payment is pending'
            ];

            \App\Models\Notification::create([
                'type' => 'payment_' . $status,
                'title' => 'Payment ' . ucfirst($status),
                'message' => $statusMessages[$status] . ' for reservation #' . $payment->reservation_id,
                'data' => [
                    'payment_id' => $payment->id,
                    'reservation_id' => $payment->reservation_id,
                    'amount' => $payment->amount,
                    'status' => $status,
                    'user_email' => $payment->user->email
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('Error creating admin notification', [
                'payment_id' => $payment->id,
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Verify Paychangu signature (implement if they provide signature verification)
     */
    private function verifyPaychanguSignature(Request $request)
    {
        // TODO: Implement signature verification if Paychangu provides it
        // This is important for security to ensure the callback is actually from Paychangu
        
        $signature = $request->input('signature');
        $payload = $request->getContent();
        $secretKey = env('PAYCHANGU_SECRET_KEY');
        
        // Example signature verification (adjust based on Paychangu's documentation)
        // $expectedSignature = hash_hmac('sha256', $payload, $secretKey);
        // if (!hash_equals($expectedSignature, $signature)) {
        //     throw new \Exception('Invalid signature');
        // }
    }
}
