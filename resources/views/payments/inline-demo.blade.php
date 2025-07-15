<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>PayChangu Inline Demo</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { font-family: 'Inter', sans-serif; background: #fffbe6; color: #23272f; margin: 0; }
        .center { min-height: 100vh; display: flex; flex-direction: column; justify-content: center; align-items: center; }
        .card { background: #fff; border-radius: 1rem; box-shadow: 0 2px 16px rgba(245,158,66,0.08); padding: 2.5rem 2rem; text-align: center; max-width: 400px; width: 100%; }
        .btn { background: #f59e42; color: #fff; font-weight: 700; padding: 0.75rem 2rem; border: none; border-radius: 0.5rem; font-size: 1.1rem; cursor: pointer; text-decoration: none; }
        .btn:hover { background: #fbbf24; }
    </style>
</head>
<body>
    <div class="center">
        <div class="card">
            <h2>PayChangu Inline Checkout Demo</h2>
            <p>Click below to test the payment flow using PayChangu's inline checkout.</p>
            <div id="wrapper"></div>
            <button class="btn" type="button" onclick="makePayment()">Pay Now</button>
        </div>
    </div>
    <script src="https://in.paychangu.com/js/popup.js"></script>
    <script>
    function makePayment() {
        PaychanguCheckout({
            "public_key": "pub-test-HYSBQpa5K91mmXMHrjhkmC6mAjObPJ2u", // Use your real/test public key
            "tx_ref": '' + Math.floor((Math.random() * 1000000000) + 1),
            "amount": 1000, // Set dynamically if needed
            "currency": "MWK",
            "callback_url": "http://127.0.0.1:8000/payments/callback",
            "return_url": "http://127.0.0.1:8000/payments/success",
            "customer": {
                "email": "yourmail@example.com",
                "first_name": "Mac",
                "last_name": "Phiri"
            },
            "customization": {
                "title": "Test Payment",
                "description": "Payment Description"
            },
            "meta": {
                "uuid": "uuid",
                "response": "Response"
            }
        });
    }
    </script>
</body>
</html> 