<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>{{ config('app.name') }}</title>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
  <div class="text-center">
    <h1 class="text-2xl font-bold mb-4">Pay for Your Reservation</h1>
    <button type="button" onclick="makePayment()" class="px-6 py-3 bg-yellow-500 text-white rounded-lg font-bold hover:bg-yellow-600 transition">Pay Now</button>
  </div>
  <script src="https://in.paychangu.com/js/popup.js"></script>
  <div id="wrapper"></div>
  <script>
    function makePayment() {
      if (paymentInProgress) {
        return;
      }

      setLoadingState(true);
      showStatus('Initializing payment...', 'info');

      // Generate unique tx_ref
      const txRef = 'RES-{{ $payment->id }}-{{ time() }}';

      try {
        PaychanguCheckout({
          "public_key": "PUB-TEST-PvuQhVa7NUDFOMJNfw5jgJZMC4ACs36Q",
          "tx_ref": txRef,
          "amount": {{ $amount }},
          "currency": "MWK",
          "callback_url": "{{ route('payments.callback') }}",
          "return_url": "{{ route('customer.reservations.index') }}",
          "customer": {
            "email": "{{ $user->email }}",
            "first_name": "{{ $user->name }}",
            "last_name": "",
          },
          "customization": {
            "title": "Plot Reservation Payment",
            "description": "Payment for reservation #{{ $reservation->id }}",
          },
          "meta": {
            "reservation_id": "{{ $reservation->id }}",
            "payment_id": "{{ $payment->id }}",
            "plot_id": "{{ $reservation->plot_id }}"
          },
          "onclose": function() {
            setLoadingState(false);
            showStatus('Payment window was closed. You can try again or contact support.', 'error');
            
            // Redirect after 3 seconds
            setTimeout(() => {
              window.location.href = "{{ route('customer.reservations.index') }}";
            }, 3000);
          },
          "onSuccess": function(response) {
            setLoadingState(false);
            showStatus('Payment successful! Redirecting...', 'success');
            
            // Store tx_ref in payment record for tracking
            storeTxRef(txRef);
            
            // Redirect to reservation details
            setTimeout(() => {
              window.location.href = "{{ route('reservation.show', $reservation->id) }}";
            }, 2000);
          },
          "onError": function(error) {
            setLoadingState(false);
            showStatus('Payment failed: ' + (error.message || 'Unknown error'), 'error');
            console.error('Paychangu error:', error);
          }
        });
      } catch (error) {
        setLoadingState(false);
        showStatus('Failed to initialize payment: ' + error.message, 'error');
        console.error('Payment initialization error:', error);
      }
    }

    function storeTxRef(txRef) {
      // Store tx_ref in payment record for tracking
      fetch('{{ route("payments.store-tx-ref", $payment->id) }}', {
        method: 'POST',
        headers: {
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
          'Accept': 'application/json',
          'Content-Type': 'application/json'
        },
        body: JSON.stringify({ tx_ref: txRef })
      })
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          console.log('Tx_ref stored successfully:', txRef);
        }
      })
      .catch(error => {
        console.error('Error storing tx_ref:', error);
      });
    }
  </script>
</body>
</html> 