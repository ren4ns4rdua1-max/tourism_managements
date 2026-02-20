<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Confirmation</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .container {
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        .header {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .content {
            padding: 30px;
        }
        .status-badge {
            display: inline-block;
            padding: 8px 16px;
            border-radius: 50px;
            font-weight: bold;
            margin-bottom: 20px;
        }
        .status-accepted {
            background-color: #d1fae5;
            color: #065f46;
        }
        .status-declined {
            background-color: #fee2e2;
            color: #991b1b;
        }
        .details {
            background-color: #f9fafb;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
        }
        .detail-row {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #e5e7eb;
        }
        .detail-row:last-child {
            border-bottom: none;
        }
        .detail-label {
            font-weight: 600;
            color: #6b7280;
        }
        .detail-value {
            color: #111827;
        }
        .footer {
            background-color: #f3f4f6;
            padding: 20px;
            text-align: center;
            color: #6b7280;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>
                @if($action === 'accepted')
                    🎉 Booking Confirmed!
                @else
                    ❌ Booking Declined
                @endif
            </h1>
        </div>
        
        <div class="content">
            <p>Dear <strong>{{ $booking->user->name }}</strong>,</p>
            
            <p>
                @if($action === 'accepted')
                    Your booking has been <strong>confirmed</strong>! We're excited to have you join us.
                @else
                    We regret to inform you that your booking has been <strong>declined</strong>. 
                    Please contact us for more information or make a new booking.
                @endif
            </p>
            
            <div class="details">
                <div class="detail-row">
                    <span class="detail-label">Booking ID</span>
                    <span class="detail-value">#{{ $booking->id }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Destination</span>
                    <span class="detail-value">{{ $booking->destination->name }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Location</span>
                    <span class="detail-value">{{ $booking->destination->location }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Booking Date</span>
                    <span class="detail-value">{{ \Carbon\Carbon::parse($booking->booking_date)->format('M d, Y') }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Number of Guests</span>
                    <span class="detail-value">{{ $booking->number_of_guests }} Guest(s)</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Total Amount</span>
                    <span class="detail-value">₱{{ number_format($booking->total_amount, 2) }}</span>
                </div>
                @if($booking->special_requests)
                <div class="detail-row">
                    <span class="detail-label">Special Requests</span>
                    <span class="detail-value">{{ $booking->special_requests }}</span>
                </div>
                @endif
            </div>
            
            @if($action === 'accepted')
            <p>We look forward to seeing you on your booking date!</p>
            @endif
            
            <p>If you have any questions, please don't hesitate to contact us.</p>
        </div>
        
        <div class="footer">
            <p>&copy; {{ date('Y') }} Travel Management System. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
