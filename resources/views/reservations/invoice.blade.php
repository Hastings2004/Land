<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Reservation Invoice</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; color: #333; }
        .header { text-align: center; margin-bottom: 30px; }
        .logo { width: 120px; margin-bottom: 10px; }
        .title { font-size: 28px; font-weight: bold; color: #2563eb; }
        .section { margin-bottom: 20px; }
        .label { font-weight: bold; }
        .footer { margin-top: 40px; text-align: center; font-size: 14px; color: #888; }
        .details-table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        .details-table th, .details-table td { border: 1px solid #eee; padding: 8px; text-align: left; }
        .details-table th { background: #dbeafe; }
    </style>
</head>
<body>
    <div class="header">
        <img src="{{ public_path('logo.png') }}" class="logo" alt="Company Logo">
        <div class="title">Atsogo Estate Agency</div>
        <div>Reservation Invoice</div>
    </div>
    <div class="section">
        <span class="label">Invoice #:</span> {{ $invoice_number }}<br>
        <span class="label">Date:</span> {{ $date }}
    </div>
    <div class="section">
        <span class="label">Customer:</span> {{ $user->name }}<br>
        <span class="label">Email:</span> {{ $user->email }}<br>
        <span class="label">Phone:</span> {{ $user->phone_number }}
    </div>
    <table class="details-table">
        <tr>
            <th>Plot</th>
            <th>Location</th>
            <th>Reservation ID</th>
            <th>Reserved On</th>
            <th>Expires On</th>
        </tr>
        <tr>
            <td>{{ $plot->title }}</td>
            <td>{{ $plot->location }}</td>
            <td>{{ $reservation->id }}</td>
            <td>{{ $reservation->created_at->format('Y-m-d H:i') }}</td>
            <td>{{ $reservation->expires_at->format('Y-m-d H:i') }}</td>
        </tr>
    </table>
    <div class="section">
        <span class="label">Reservation Fee:</span> MWK {{ number_format($plot->price, 2) }}<br>
        <span class="label">Payment Status:</span> {{ $reservation->status == 'completed' ? 'Paid' : 'Unpaid' }}
    </div>
    <div class="section">
        <span class="label">Instructions:</span><br>
        Please pay the reservation fee within 24 hours to secure your plot.<br>
        For questions, contact info@atsogo.mw
    </div>
    <div class="footer">
        Thank you for your reservation!
    </div>
</body>
</html> 