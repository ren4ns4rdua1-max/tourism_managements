# TODO - Add Accept/Decline Actions to Manager Booking

## Plan:
- [x] 1. Add routes for accept/decline actions in web.php
- [x] 2. Create Mailable class for booking confirmation email
- [x] 3. Update BookingController with accept/decline methods
- [x] 4. Update manager index view with Accept/Decline buttons

## Gmail Configuration (to be added in .env):
```
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=ren4ns4rdua1@gmail.com
MAIL_PASSWORD=brainprow5
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=ren4ns4rdua1@gmail.com
MAIL_FROM_NAME="${APP_NAME}"
```

## Progress:
- [x] Step 1: Add routes in web.php
- [x] Step 2: Create Mailable class
- [x] Step 3: Update BookingController with accept/decline methods
- [x] Step 4: Update manager index view with Accept/Decline buttons

## Summary of Changes:
1. **routes/web.php**: Added accept and decline routes
2. **app/Mail/BookingConfirmation.php**: Created new Mailable class for sending booking confirmation/decline emails
3. **resources/views/emails/booking-confirmation.blade.php**: Created email template
4. **app/Http/Controllers/BookingController.php**: Added accept() and decline() methods with email functionality
5. **resources/views/booking/manager/index.blade.php**: Added Accept/Decline buttons that only appear for pending bookings
