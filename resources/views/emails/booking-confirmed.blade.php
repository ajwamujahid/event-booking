<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f4f4; margin: 0; padding: 0; }
        .container { max-width: 600px; margin: 30px auto; background: white; border-radius: 10px; overflow: hidden; }
        .header { background: linear-gradient(135deg, #667eea, #764ba2); padding: 30px; text-align: center; color: white; }
        .body { padding: 30px; }
        .detail-row { display: flex; justify-content: space-between; padding: 10px 0; border-bottom: 1px solid #eee; }
        .footer { background: #f8f9fa; padding: 20px; text-align: center; color: #999; font-size: 12px; }
        .badge { background: #28a745; color: white; padding: 4px 12px; border-radius: 20px; font-size: 13px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1 style="margin:0">🎟️ Booking Confirmed!</h1>
            <p style="margin:10px 0 0; opacity:0.85">Your seats have been reserved</p>
        </div>
        <div class="body">
            <p>Hi <strong>{{ $booking->user->name }}</strong>,</p>
            <p>Your booking for <strong>{{ $booking->event->title }}</strong> has been confirmed!</p>

            <div class="detail-row">
                <span style="color:#666">📅 Event Date</span>
                <strong>{{ $booking->event->event_date->format('D, M d Y – h:i A') }}</strong>
            </div>
            <div class="detail-row">
                <span style="color:#666">📍 Location</span>
                <strong>{{ $booking->event->location }}</strong>
            </div>
            <div class="detail-row">
                <span style="color:#666">🪑 Seats Booked</span>
                <strong>{{ $booking->seats_booked }}</strong>
            </div>
            <div class="detail-row">
                <span style="color:#666">📋 Status</span>
                <span class="badge">Confirmed</span>
            </div>
            <div class="detail-row">
                <span style="color:#666">🗓️ Booked On</span>
                <strong>{{ $booking->booking_date->format('M d, Y') }}</strong>
            </div>

            <p style="margin-top:25px; color:#666;">
                Thank you for using <strong>EventBook</strong>. See you at the event!
            </p>
        </div>
        <div class="footer">
            © {{ date('Y') }} EventBook. All rights reserved.
        </div>
    </div>
</body>
</html>
