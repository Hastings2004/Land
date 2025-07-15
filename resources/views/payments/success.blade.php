<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Payment Success</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { font-family: 'Inter', sans-serif; background: #fffbe6; color: #23272f; margin: 0; }
        .center { min-height: 100vh; display: flex; flex-direction: column; justify-content: center; align-items: center; }
        .card { background: #fff; border-radius: 1rem; box-shadow: 0 2px 16px rgba(245,158,66,0.08); padding: 2.5rem 2rem; text-align: center; }
        .icon { font-size: 3rem; color: #f59e42; margin-bottom: 1rem; }
        .btn { background: #f59e42; color: #fff; font-weight: 700; padding: 0.75rem 2rem; border: none; border-radius: 0.5rem; font-size: 1.1rem; cursor: pointer; text-decoration: none; }
        .btn:hover { background: #fbbf24; }
    </style>
</head>
<body>
    <div class="center">
        <div class="card">
            <div class="icon"><i class="fas fa-check-circle"></i></div>
            <h1>Payment Successful!</h1>
            <p>Thank you for your payment.<br>Your reservation is now confirmed.</p>
            <a href="{{ route('customer.reservations.index') }}" class="btn">Go to My Reservations</a>
        </div>
    </div>
</body>
</html> 