<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservation Confirmation</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 20px auto; padding: 20px; border: 1px solid #ddd; border-radius: 5px; }
        .header { font-size: 24px; font-weight: bold; margin-bottom: 20px; color: #2c3e50; }
        .content p { margin: 0 0 10px; }
        .footer { margin-top: 20px; font-size: 12px; color: #777; }
        strong { color: #2c3e50; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            Reservation Confirmed!
        </div>
        <div class="content">
            <p>Hello, <strong>{{ $reservation->user->username }}</strong>,</p>
            <p>Thank you for your reservation. Your request for the plot has been successfully submitted and is now pending approval from our administration team.</p>
            <p>Here are your reservation details:</p>
            <ul>
                <li><strong>Plot Name:</strong> {{ $reservation->plot->title }}</li>
                <li><strong>Location:</strong> {{ $reservation->plot->location }}</li>
                <li><strong>Reservation ID:</strong> {{ $reservation->id }}</li>
                <li><strong>Status:</strong> {{ ucfirst($reservation->status) }}</li>
            </ul>
            <p>You will be notified again once your reservation is approved. You can view the status of your reservations on your dashboard.</p>
            <p>Thank you for choosing us!</p>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} ATSOGO. All rights reserved.</p>
        </div>
    </div>
</body>
</html>