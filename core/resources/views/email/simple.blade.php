<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $subject }}</title>
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
            background-color: #f8f9fa;
            padding: 20px;
            text-align: center;
            border-radius: 5px;
        }
        .content {
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            margin-top: 20px;
            border: 1px solid #dee2e6;
        }
        .footer {
            margin-top: 20px;
            text-align: center;
            font-size: 12px;
            color: #6c757d;
        }
        .otp-code {
            font-size: 24px;
            font-weight: bold;
            text-align: center;
            padding: 15px;
            background-color: #f8f9fa;
            border-radius: 5px;
            margin: 20px 0;
            letter-spacing: 5px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>{{ $site_name }}</h1>
    </div>
    
    <div class="content">
        <h2>{{ $subject }}</h2>
        <p>Hello {{ $username }},</p>
        
        <div>{!! nl2br(e($message)) !!}</div>
        
        <p>If you did not request this, please ignore this email.</p>
    </div>
    
    <div class="footer">
        <p>Thank you,<br>{{ $site_name }}</p>
        <p>&copy; {{ date('Y') }} {{ $site_name }}. All rights reserved.</p>
    </div>
</body>
</html>