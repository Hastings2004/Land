<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>New Contact Form Submission</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background: linear-gradient(135deg, #f59e0b, #f97316);
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 10px 10px 0 0;
        }
        .content {
            background: #f9fafb;
            padding: 30px;
            border-radius: 0 0 10px 10px;
            border: 1px solid #e5e7eb;
        }
        .field {
            margin-bottom: 20px;
        }
        .field-label {
            font-weight: bold;
            color: #374151;
            margin-bottom: 5px;
        }
        .field-value {
            background: white;
            padding: 15px;
            border-radius: 8px;
            border-left: 4px solid #f59e0b;
        }
        .message-box {
            background: white;
            padding: 20px;
            border-radius: 8px;
            border: 1px solid #e5e7eb;
            white-space: pre-wrap;
        }
        .footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
            text-align: center;
            color: #6b7280;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>📧 New Contact Form Submission</h1>
        <p>ATSOGO Land Marketing Support</p>
    </div>
    
    <div class="content">
        <p>You have received a new contact form submission from your website. Here are the details:</p>
        
        <div class="field">
            <div class="field-label">👤 Name:</div>
            <div class="field-value">{{ $name }}</div>
        </div>
        
        <div class="field">
            <div class="field-label">📧 Email:</div>
            <div class="field-value">{{ $email }}</div>
        </div>
        
        <div class="field">
            <div class="field-label">💬 Message:</div>
            <div class="message-box">{{ $message }}</div>
        </div>
        
        <div class="footer">
            <p><strong>ATSOGO Land Marketing</strong></p>
            <p>📞 +265 888 052 362 | 📧 info@atsogo.mw</p>
            <p>📍 Area 47 sector 4, Mazengera street, gate No 25, Lilongwe</p>
            <p>🌐 www.atsogo.mw</p>
        </div>
    </div>
</body>
</html> 