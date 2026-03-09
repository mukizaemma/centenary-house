<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Response to your room enquiry</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px; }
        h1 { color: #f46f58; font-size: 1.5rem; margin-bottom: 20px; }
        .meta { font-size: 0.9rem; color: #555; margin-bottom: 10px; }
        .box { background: #f9f9f9; padding: 16px; border-radius: 8px; border-left: 4px solid #f46f58; margin-top: 12px; }
        .footer { margin-top: 24px; font-size: 0.85rem; color: #888; }
    </style>
</head>
<body>
    <h1>Thank you for your enquiry</h1>

    <p>Dear {{ $enquiry->visitor_name }},</p>

    <p>We have reviewed your enquiry about
        @if($enquiry->room && $enquiry->room->title)
            <strong>{{ $enquiry->room->title }}</strong>
        @else
            this space
        @endif
        and have shared a response below.</p>

    <div class="meta">
        <strong>Your original message:</strong>
    </div>
    <div class="box">
        {{ nl2br(e($enquiry->message)) }}
    </div>

    @if($enquiry->admin_response)
        <div class="meta">
            <strong>Our response:</strong>
        </div>
        <div class="box">
            {{ nl2br(e($enquiry->admin_response)) }}
        </div>
    @endif

    <div class="footer">
        <p>If you have any further questions, you can reply directly to this email.</p>
        <p>Best regards,<br>{{ config('app.name') }}</p>
    </div>
</body>
</html>

