<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

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

    // Handle PayChangu callback/webhook
    public function callback(Request $request)
    {
        Log::info('PayChangu callback received', $request->all());
        // Validate and process PayChangu's response
        $transactionId = $request->input('transaction_id');
        $status = $request->input('status');
        $paymentId = $request->input('payment_id');

        $payment = Payment::find($paymentId);
        if ($payment) {
            $payment->status = $status;
            $payment->transaction_id = $transactionId;
            $payment->save();

            // Optionally, update reservation status if payment is successful
            if ($status === 'success') {
                $reservation = $payment->reservation;
                if ($reservation) {
                    $reservation->status = 'completed';
            $reservation->save();
                } 
            }
        }
        return response()->json(['success' => true]);
    }
}
