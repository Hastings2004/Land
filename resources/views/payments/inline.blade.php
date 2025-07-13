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
    function makePayment(){
      PaychanguCheckout({
        "public_key": "PUB-TEST-PvuQhVa7NUDFOMJNfw5jgJZMC4ACs36Q",
        "tx_ref": 'RES-{{ $payment->id }}-{{ time() }}',
        "amount": {{ $amount }},
        "currency": "MWK",
        "callback_url": "{{ $callbackUrl }}",
        "return_url": "{{ route('customer.reservation.show', $reservation->id) }}",
        "customer":{
          "email": "{{ $user->email }}",
          "first_name":"{{ $user->name }}",
          "last_name":"",
        },
        "customization": {
          "title": "Plot Reservation Payment",
          "description": "Payment for reservation #{{ $reservation->id }}",
        },
        "meta": {
          "reservation_id": "{{ $reservation->id }}",
          "payment_id": "{{ $payment->id }}"
        },
        "onclose": function() {
          window.location.href = "{{ route('customer.reservations.index') }}";
        }
      });
    }
  </script>
</body>
</html> 