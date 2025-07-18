<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Notification PDF</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; color: #333; }
        .header { text-align: center; margin-bottom: 30px; }
        .title { font-size: 24px; font-weight: bold; color: #2563eb; }
        .section { margin-bottom: 20px; }
        .label { font-weight: bold; }
        .footer { margin-top: 40px; text-align: center; font-size: 14px; color: #888; }
    </style>
</head>
<body>
    <div class="header">
        <div class="title">Notification</div>
    </div>
    <div class="section">
        <span class="label">Title:</span> {{ $notification->title }}<br>
        <span class="label">Date:</span> {{ $notification->created_at->format('Y-m-d H:i') }}
    </div>
    <div class="section">
        <span class="label">Message:</span><br>
        {!! $notification->message !!}
    </div>
    <div class="footer">
        &copy; {{ date('Y') }} Atsogo Estate Agency
    </div>
</body>
</html> 