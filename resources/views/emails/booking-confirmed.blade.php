<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Confirmed</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Arial, sans-serif; background-color: #f0f4ff; padding: 30px 15px; }
        .wrapper { max-width: 600px; margin: 0 auto; }

        /* Header */
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 16px 16px 0 0;
            padding: 40px 30px;
            text-align: center;
            color: white;
        }
        .header .icon { font-size: 52px; margin-bottom: 12px; }
        .header h1 { font-size: 28px; font-weight: 700; margin-bottom: 6px; }
        .header p { font-size: 15px; opacity: 0.85; }

        /* Body */
        .body {
            background: #ffffff;
            padding: 35px 30px;
        }
        .greeting { font-size: 16px; color: #333; margin-bottom: 20px; }
        .greeting strong { color: #667eea; }

        /* Booking Card */
        .booking-card {
            background: #f8f9ff;
            border: 1px solid #e0e7ff;
            border-radius: 12px;
            overflow: hidden;
            margin: 20px 0;
        }
        .booking-card-header {
            background: linear-gradient(135deg, #667eea, #764ba2);
            padding: 14px 20px;
            color: white;
            font-size: 14px;
            font-weight: 600;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }
        .booking-card-body { padding: 0; }
        .detail-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 14px 20px;
            border-bottom: 1px solid #e8ecff;
        }
        .detail-row:last-child { border-bottom: none; }
        .detail-label {
            color: #888;
            font-size: 13px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .detail-value {
            color: #222;
            font-size: 14px;
            font-weight: 600;
            text-align: right;
        }

        /* Status Badge */
        .status-badge {
            background: #dcfce7;
            color: #16a34a;
            padding: 4px 14px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 600;
        }

        /* Info Box */
        .info-box {
            background: #eff6ff;
            border-left: 4px solid #667eea;
            border-radius: 6px;
            padding: 14px 18px;
            margin: 20px 0;
            color: #444;
            font-size: 14px;
            line-height: 1.6;
        }

        /* Button */
        .btn-wrap { text-align: center; margin: 25px 0; }
        .btn {
            display: inline-block;
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white !important;
            text-decoration: none;
            padding: 13px 35px;
            border-radius: 8px;
            font-size: 15px;
            font-weight: 600;
        }

        /* Footer */
        .footer {
            background: #f8f9ff;
            border-radius: 0 0 16px 16px;
            border-top: 1px solid #e0e7ff;
            padding: 22px 30px;
            text-align: center;
        }
        .footer p { color: #999; font-size: 12px; line-height: 1.7; }
        .footer strong { color: #667eea; }
    </style>
</head>
<body>
    <div class="wrapper">

        {{-- Header --}}
        <div class="header">
            <div class="icon">🎟️</div>
            <h1>Booking Confirmed!</h1>
            <p>Your seat(s) have been successfully reserved</p>
        </div>

        {{-- Body --}}
        <div class="body">

            <p class="greeting">
                Hi <strong>{{ $booking->user->name }}</strong>, great news! 🎉<br>
                Your booking for <strong>{{ $booking->event->title }}</strong> has been confirmed.
            </p>

            {{-- Booking Details Card --}}
            <div class="booking-card">
                <div class="booking-card-header">📋 Booking Details</div>
                <div class="booking-card-body">

                    <div class="detail-row">
                        <span class="detail-label">🎪 Event</span>
                        <span class="detail-value">{{ $booking->event->title }}</span>
                    </div>

                    <div class="detail-row">
                        <span class="detail-label">📅 Date</span>
                        <span class="detail-value">{{ $booking->event->event_date->format('D, M d Y') }}</span>
                    </div>

                    <div class="detail-row">
                        <span class="detail-label">⏰ Time</span>
                        <span class="detail-value">{{ $booking->event->event_date->format('h:i A') }}</span>
                    </div>

                    <div class="detail-row">
                        <span class="detail-label">📍 Location</span>
                        <span class="detail-value">{{ $booking->event->location }}</span>
                    </div>

                    <div class="detail-row">
                        <span class="detail-label">🪑 Seats Booked</span>
                        <span class="detail-value">{{ $booking->seats_booked }} {{ $booking->seats_booked > 1 ? 'Seats' : 'Seat' }}</span>
                    </div>

                    <div class="detail-row">
                        <span class="detail-label">🗓️ Booked On</span>
                        <span class="detail-value">{{ $booking->booking_date->format('M d, Y – h:i A') }}</span>
                    </div>

                    <div class="detail-row">
                        <span class="detail-label">✅ Status</span>
                        <span class="status-badge">Confirmed</span>
                    </div>

                </div>
            </div>

            {{-- Info --}}
            <div class="info-box">
                ℹ️ Please keep this email as your booking reference.
                If you need to cancel your booking, you can do so from your
                <strong>My Bookings</strong> page before the event date.
            </div>

            {{-- CTA Button --}}
            <div class="btn-wrap">
                <a href="{{ config('app.url') }}/bookings" class="btn">
                    View My Bookings →
                </a>
            </div>

            <p style="color:#666; font-size:14px; line-height:1.7;">
                Thank you for using <strong style="color:#667eea;">EventBook</strong>.
                We look forward to seeing you at the event! 🚀
            </p>

        </div>

        {{-- Footer --}}
        <div class="footer">
            <p>
                This email was sent by <strong>EventBook</strong><br>
                © {{ date('Y') }} EventBook. All rights reserved.<br>
                <span style="font-size:11px;">Please do not reply to this email.</span>
            </p>
        </div>

    </div>
</body>
</html>