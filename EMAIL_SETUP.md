# Email Notifications Setup Guide

## Overview

The Toxaway Knitting application now sends transactional emails for:
- **Order Confirmations** - Sent to customers when they complete an order
- **Custom Jacket Inquiries** - Sent to customers when they submit a custom jacket request
- **Contact Form Notifications** - Sent to admin when someone submits the contact form

## Current Development Setup

The application uses Laravel's **log** mail driver for development, which logs all emails to `storage/logs/laravel.log` instead of actually sending them.

### Testing Emails in Development

1. **Place an Order**: Complete a checkout to trigger an order confirmation email
2. **Submit Custom Jacket Request**: Fill out the custom jacket form
3. **Submit Contact Form**: Send a message via the contact page
4. Check `storage/logs/laravel.log` to see the email content

## Production Email Setup

For production, you need to configure a real email provider. Here are the recommended options:

### Option 1: Mailgun (Recommended)

1. **Sign up** at [mailgun.com](https://mailgun.com)
2. **Get your credentials** from the Mailgun dashboard
3. **Update `.env`**:
```env
MAIL_MAILER=mailgun
MAILGUN_DOMAIN=your-domain.mailgun.org
MAILGUN_SECRET=your-api-key
```

### Option 2: SendGrid

1. **Sign up** at [sendgrid.com](https://sendgrid.com)
2. **Create an API key** in Settings
3. **Update `.env`**:
```env
MAIL_MAILER=sendgrid
SENDGRID_API_KEY=your-api-key
```

### Option 3: Amazon SES

1. **Set up AWS SES** in your AWS account
2. **Get credentials** (Access Key ID and Secret Access Key)
3. **Update `.env`**:
```env
MAIL_MAILER=ses
AWS_ACCESS_KEY_ID=your-key
AWS_SECRET_ACCESS_KEY=your-secret
AWS_DEFAULT_REGION=us-east-1
AWS_SES_REGION=us-east-1
```

### Option 4: Gmail SMTP

For small-scale testing (not recommended for production):
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_ENCRYPTION=tls
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
```

## Email Configuration

Update these settings in `.env`:

```env
# Email Provider (log, smtp, mailgun, sendgrid, ses)
MAIL_MAILER=log

# From Address (displayed in emails)
MAIL_FROM_ADDRESS=support@toxawayknitting.com
MAIL_FROM_NAME="Toxaway Knitting Co."

# Admin Contact Email (for receiving contact form submissions)
# Currently uses MAIL_FROM_ADDRESS. To use a different email, update the contact route in routes/web.php
```

## Email Templates

Email templates are located in `resources/views/emails/`:

- **order-confirmation.blade.php** - Order confirmation template
- **custom-jacket-inquiry.blade.php** - Custom jacket inquiry confirmation
- **contact-notification.blade.php** - Contact form notification for admin

All templates use a consistent HTML style matching the Toxaway brand.

## Email Classes

Mail classes are in `app/Mail/`:

- **OrderConfirmation** - Handles order confirmation emails
- **CustomJacketInquiry** - Handles custom jacket inquiry emails
- **ContactNotification** - Handles contact form notifications

## Troubleshooting

### Emails not sending in production

1. **Check logs**: `tail -f storage/logs/laravel.log`
2. **Verify credentials**: Double-check `.env` settings
3. **Test configuration**: Run `php artisan config:cache` and then test again
4. **Check email provider**: Verify your account is active and has sending capacity

### Emails going to spam

1. Set up SPF records on your domain
2. Set up DKIM authentication through your email provider
3. Set up DMARC policy
4. Use a consistent "From" address

### Local testing without sending

Keep `MAIL_MAILER=log` for development to avoid accidental emails to real addresses.

## Queue Setup (Optional)

For high-volume email sending, set up Laravel queues:

```env
QUEUE_CONNECTION=database
```

Then update the Mail classes to implement `ShouldQueue`:

```php
class OrderConfirmation extends Mailable implements ShouldQueue
{
    // ...
}
```

Run `php artisan queue:work` to process queued emails.

## Monitoring

Check `storage/logs/laravel.log` to see:
- Successfully sent emails
- Failed delivery attempts
- Email content for debugging

## Next Steps

1. Choose an email provider
2. Create an account and get credentials
3. Update `.env` with credentials
4. Test by placing an order or submitting a form
5. Monitor logs to verify delivery
