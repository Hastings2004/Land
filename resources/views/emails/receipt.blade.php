<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Receipt</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; color: #333; }
        .header { text-align: center; margin-bottom: 30px; }
        .title { font-size: 24px; font-weight: bold; color: #f59e0b; }
        .section { margin-bottom: 20px; }
        .label { font-weight: bold; }
        .footer { margin-top: 40px; text-align: center; font-size: 14px; color: #888; }
        .details-table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        .details-table th, .details-table td { border: 1px solid #eee; padding: 8px; text-align: left; }
        .details-table th { background: #fef3c7; }
    </style>
</head>
<body>
    <div class="header">
        <div class="title">Atsogo Estate Agency</div>
        <div>Official Payment Receipt</div>
    </div>
    <div class="section">
        <span class="label">Customer:</span> {{ $user->name }}<br>
        <span class="label">Email:</span> {{ $user->email }}<br>
        <span class="label">Date:</span> {{ $date }}
    </div>
    <table class="details-table">
        <tr>
            <th>Plot</th>
            <th>Location</th>
            <th>Price</th>
        </tr>
        <tr>
            <td>{{ $plot->title }}</td>
            <td>{{ $plot->location }}</td>
            <td>MWK {{ number_format($plot->price, 2) }}</td>
        </tr>
    </table>
    <div class="footer">
        Thank you for your purchase!<br>
        For any questions, contact us at info@atsogo.mw
    </div>
</body>
</html> 