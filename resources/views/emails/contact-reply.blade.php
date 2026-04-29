<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reply to Your Message</title>
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
            background: #0d9488;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 8px 8px 0 0;
        }
        .content {
            background: #f9fafb;
            padding: 30px;
            border: 1px solid #e5e7eb;
        }
        .message-box {
            background: white;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
            border-left: 4px solid #0d9488;
        }
        .original-message {
            background: #f3f4f6;
            padding: 15px;
            border-radius: 8px;
            margin-top: 20px;
        }
        .footer {
            text-align: center;
            padding: 20px;
            color: #6b7280;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1 style="margin: 0;">Reply to Your Message</h1>
    </div>
    
    <div class="content">
        <p>Hello {{ $contactMessage->name }},</p>
        
        <p>Thank you for contacting us. Here is our response to your message:</p>
        
        <div class="message-box">
            {!! nl2br(e($replyMessage)) !!}
        </div>
        
        <div class="original-message">
            <p style="margin: 0 0 10px 0; font-weight: bold; color: #4b5563;">Your Original Message:</p>
            <p style="margin: 0; color: #6b7280;"><strong>Subject:</strong> {{ $contactMessage->subject }}</p>
            <p style="margin: 10px 0 0 0; color: #6b7280;">{{ $contactMessage->message }}</p>
        </div>
        
        <p>If you have any further questions, feel free to reply to this email.</p>
        
        <p>Best regards,<br>
        <strong>{{ config('app.name') }} Team</strong></p>
    </div>
    
    <div class="footer">
        <p>This email was sent in response to your contact form submission.</p>
        <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
    </div>
</body>
</html>
