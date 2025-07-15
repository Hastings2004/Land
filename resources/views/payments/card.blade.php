<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Card Payment</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { font-family: 'Inter', sans-serif; background: #fffbe6; color: #23272f; margin: 0; }
        .center { min-height: 100vh; display: flex; flex-direction: column; justify-content: center; align-items: center; }
        .card { background: #fff; border-radius: 1rem; box-shadow: 0 2px 16px rgba(245,158,66,0.08); padding: 2.5rem 2rem; text-align: center; max-width: 400px; width: 100%; }
        .input { width: 100%; padding: 0.75rem; margin-bottom: 1rem; border: 1px solid #fbbf24; border-radius: 0.5rem; font-size: 1rem; }
        .btn { background: #f59e42; color: #fff; font-weight: 700; padding: 0.75rem 2rem; border: none; border-radius: 0.5rem; font-size: 1.1rem; cursor: pointer; text-decoration: none; }
        .btn:hover { background: #fbbf24; }
    </style>
</head>
<body>
    <div class="center">
        <form class="card" method="POST" action="{{ route('payments.charge') }}">
            @csrf
            <h2 class="mb-4">Pay with Card</h2>
            <input class="input" name="card_number" placeholder="Card Number" required>
            <input class="input" name="expiry" placeholder="MM/YY" required>
            <input class="input" name="cvv" placeholder="CVV" required>
            <input class="input" name="cardholder_name" placeholder="Cardholder Name" required>
            <input class="input" name="amount" placeholder="Amount" required>
            <input class="input" name="currency" value="USD" required>
            <input class="input" name="email" placeholder="Email" required>
            <button class="btn" type="submit">Pay</button>
        </form>
    </div>
</body>
</html> 