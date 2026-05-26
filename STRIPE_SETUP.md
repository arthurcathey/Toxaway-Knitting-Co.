# Stripe Payment Integration Guide

## Overview

This guide covers the Stripe payment integration for Toxaway Knitting Co. The application uses Stripe to securely process credit card payments with PCI compliance.

## Features

- **Secure Card Processing**: Uses Stripe.js for client-side tokenization
- **Payment Intent Support**: Implements Stripe Payment Intents for enhanced security
- **Webhook Handling**: Listens to Stripe webhooks for real-time payment updates
- **Error Handling**: Comprehensive error logging and user-friendly messages
- **Test & Live Modes**: Easy switching between test and production keys

## Architecture

### Files Modified/Created

1. **app/Services/StripePaymentService.php** - Core payment service
2. **app/Http/Controllers/PaymentController.php** - Payment processing controller
3. **resources/views/checkout/payment.blade.php** - Payment form with Stripe.js
4. **resources/views/checkout/success.blade.php** - Order confirmation page
5. **resources/views/checkout/failure.blade.php** - Payment failure page
6. **config/services.php** - Stripe configuration
7. **.env** - Environment variables for API keys
8. **database/migrations/2026_05_26_add_payment_to_orders.php** - Payment-related columns

### Database Columns Added

```
user_id (nullable) - Link to authenticated user
full_name - Customer's full name
email - Customer's email address
phone - Customer's phone number
shipping_country - Customer's country
tax - Tax amount (decimal)
total_amount - Total order amount including shipping
payment_method - Payment method used (e.g., 'stripe')
stripe_charge_id - Stripe charge ID (unique)
paid_at - Timestamp when payment was received
status enum - Added new statuses: 'confirmed', 'failed', 'refunded'
```

## Setup Instructions

### 1. Get Stripe API Keys

1. Go to [https://dashboard.stripe.com](https://dashboard.stripe.com)
2. Sign in or create a new Stripe account
3. Navigate to **Developers** → **API keys**
4. You'll see:
   - **Publishable Key** (starts with `pk_test_` or `pk_live_`)
   - **Secret Key** (starts with `sk_test_` or `sk_live_`)
5. For testing, use the **Test** keys

### 2. Configure Environment Variables

Update your `.env` file with your Stripe keys:

```env
STRIPE_PUBLIC_KEY=pk_test_your_test_public_key_here
STRIPE_SECRET_KEY=sk_test_your_test_secret_key_here
STRIPE_WEBHOOK_SECRET=whsec_your_webhook_secret_here
```

### 3. Get Webhook Secret (Optional but Recommended)

For production:

1. In Stripe Dashboard, go to **Developers** → **Webhooks**
2. Click **Add endpoint**
3. Endpoint URL: `https://yourdomain.com/webhook/stripe`
4. Select events: `charge.succeeded`, `charge.failed`, `charge.refunded`
5. Copy the signing secret and add to `.env` as `STRIPE_WEBHOOK_SECRET`

## Payment Flow

### 1. Customer Initiates Checkout

- User views cart and clicks "Proceed to Checkout"
- Redirected to `/checkout/payment` (PaymentController@index)
- Cart items and total are displayed

### 2. Form Submission

- Customer enters billing/shipping information
- Stripe.js creates a payment method from card details
- Form data sent to `/checkout/payment` (PaymentController@process)

### 3. Payment Processing

The backend processes the payment:

1. Validates form input
2. Retrieves cart items
3. Calculates totals (subtotal + shipping)
4. Creates Order record with 'pending' status
5. Creates OrderItem records for each product
6. Calls `StripePaymentService::createCharge()`
7. Stripe processes the charge
8. If successful:
   - Updates Order status to 'confirmed'
   - Stores Stripe charge ID
   - Clears cart items
   - Sends order confirmation email
   - Returns order ID
9. If failed:
   - Rolls back database transaction
   - Returns error message

### 4. Success/Failure Pages

- **Success**: Displays at `/checkout/success?order_id=X` with order details
- **Failure**: Displays at `/checkout/failure?error=message` with troubleshooting tips

## Testing Payments

### Test Card Numbers

Stripe provides test card numbers for different scenarios:

**Visa - Successful Payment**
- Card: `4242 4242 4242 4242`
- Expiry: Any future date (e.g., 12/25)
- CVC: Any 3-digit number (e.g., 123)

**Visa - Insufficient Funds**
- Card: `4000 0000 0000 0002`

**Visa - Lost Card**
- Card: `4000 0000 0000 0069`

**Visa - Expired Card**
- Card: `4000 0000 0000 0069`

### Test Payment Steps

1. Go to `/checkout/payment`
2. Add test items to cart (or manually access the URL)
3. Enter any shipping information
4. Use a test card number from above
5. Submit form
6. Should see success or failure message

## Security Best Practices

### Implemented

✅ **PCI Compliance**: Card data never touches server (handled by Stripe.js)
✅ **HTTPS Required**: Production must use HTTPS (not tested locally)
✅ **CSRF Protection**: Laravel CSRF tokens on forms
✅ **Input Validation**: Server-side validation on all fields
✅ **Database Transactions**: Rollback on payment failure
✅ **Secure Storage**: Stripe charge ID stored, never card details
✅ **Error Logging**: Payment errors logged to Laravel logs

### For Production

1. **Obtain SSL Certificate** - Use Let's Encrypt (free) or commercial provider
2. **Update APP_URL** - Change from `http://localhost` to `https://yourdomain.com`
3. **Update STRIPE_PUBLIC_KEY** - Use live key (`pk_live_...`)
4. **Update STRIPE_SECRET_KEY** - Use live key (`sk_live_...`)
5. **Set STRIPE_WEBHOOK_SECRET** - Use production webhook secret
6. **Enable HTTPS Redirect** - Laravel automatic or nginx/Apache config

## StripePaymentService Methods

### createPaymentIntent()

Creates a Stripe Payment Intent for complex payment flows.

```php
$result = $stripe->createPaymentIntent(
    amount: 99.99,           // Amount in dollars
    currency: 'usd',
    metadata: ['order_id' => 123],
    description: 'Order for Toxaway Sweater'
);

// Response
[
    'success' => true,
    'client_secret' => 'pi_....',
    'payment_intent_id' => 'pi_....'
]
```

### retrievePaymentIntent()

Retrieves status of an existing Payment Intent.

```php
$result = $stripe->retrievePaymentIntent('pi_....');

// Response
[
    'success' => true,
    'status' => 'succeeded',
    'amount' => 99.99,
    'charge_id' => 'ch_....'
]
```

### createCharge()

Directly creates a charge (simplified flow, currently used).

```php
$result = $stripe->createCharge(
    paymentMethodId: 'pm_....',
    amountCents: 9999,       // Amount in cents
    currency: 'usd',
    metadata: ['order_id' => 123]
);

// Response
[
    'success' => true,
    'charge_id' => 'ch_....',
    'status' => 'succeeded',
    'amount' => 99.99
]
```

### verifyWebhookSignature()

Verifies authenticity of Stripe webhook.

```php
$isValid = StripePaymentService::verifyWebhookSignature(
    payload: $request->getContent(),
    signature: $request->header('Stripe-Signature')
);
```

## Webhook Events

The application handles three webhook event types:

### charge.succeeded

Triggered when payment is successfully captured.

**Handler**: `handleChargeSucceeded()`
**Action**: Updates Order status to 'confirmed', sets `paid_at` timestamp

### charge.failed

Triggered when charge is declined or fails.

**Handler**: `handleChargeFailed()`
**Action**: Updates Order status to 'failed'

### charge.refunded

Triggered when charge is refunded.

**Handler**: `handleChargeRefunded()`
**Action**: Updates Order status to 'refunded'

## Troubleshooting

### Issue: "Invalid API key"

**Solution**: 
- Verify `STRIPE_SECRET_KEY` is correct in `.env`
- Check that key matches your Stripe account (test vs. live)
- Reload application after .env changes

### Issue: "Card error" on checkout

**Solutions**:
- Verify card is in Stripe test cards list (if testing)
- Check card number, expiry, CVC are correct
- Verify form validation isn't preventing submission
- Check browser console for JavaScript errors

### Issue: Payment succeeds but order not created

**Likely Causes**:
- Database transaction rolled back (check logs)
- Validation error in form processing (check error message)
- Cart items cleared before checkout

**Solution**: Check `storage/logs/laravel.log` for detailed error messages

### Issue: Webhook not receiving events

**Solutions**:
1. Verify endpoint URL is publicly accessible (localhost doesn't work)
2. Check `STRIPE_WEBHOOK_SECRET` is correct
3. Check webhook is enabled in Stripe Dashboard
4. Review webhook delivery attempts in Stripe Dashboard
5. Check Laravel logs for webhook errors

### Issue: SSL certificate error in production

**Solution**: Obtain and install SSL certificate
- Free: Let's Encrypt with Certbot
- Commercial: Namecheap, GoDaddy, etc.

## Going Live Checklist

- [ ] Obtained SSL certificate (HTTPS)
- [ ] Updated .env with live Stripe keys (pk_live_, sk_live_)
- [ ] Updated APP_URL to production domain
- [ ] Tested multiple payment scenarios
- [ ] Configured webhook endpoint in Stripe Dashboard
- [ ] Added webhook secret to .env
- [ ] Tested webhook delivery in Stripe Dashboard
- [ ] Set up email notifications (order confirmations sending)
- [ ] Reviewed order confirmation emails
- [ ] Set up payment failure notifications
- [ ] Tested refund process
- [ ] Reviewed security settings
- [ ] Set up error monitoring (Sentry, etc.)
- [ ] Created runbook for payment issues
- [ ] Informed team of go-live procedures

## API Response Formats

### Successful Payment

```json
{
    "success": true,
    "order_id": 123,
    "message": "Payment successful! Your order has been confirmed."
}
```

### Failed Payment

```json
{
    "success": false,
    "error": "Your card was declined",
    "errors": {}
}
```

### Validation Errors

```json
{
    "success": false,
    "errors": {
        "email": ["The email field is required."],
        "payment_method_id": ["The payment method field is required."]
    }
}
```

## Performance Considerations

- **API Calls**: Each payment makes ~2 HTTP requests (createPaymentMethod, charge)
- **Webhook Processing**: Async, no impact on user experience
- **Database Transactions**: All-or-nothing prevents inconsistent states
- **Email Sending**: Queued (currently synchronous, can be async)

## Next Steps

1. **Test Thoroughly**: Use test cards to verify complete flow
2. **Monitor Logs**: Check `storage/logs/laravel.log` for errors
3. **Set Up Monitoring**: Integrate error tracking (Sentry, Bugsnag)
4. **Plan Go-Live**: Schedule production deployment
5. **Inform Customers**: Update checkout copy if needed
6. **Track Metrics**: Monitor payment success rate, average order value

## Additional Resources

- [Stripe Documentation](https://stripe.com/docs)
- [Stripe.js Reference](https://stripe.com/docs/js/card_element)
- [Payment Intent Guide](https://stripe.com/docs/payments/payment-intents)
- [Webhook Guide](https://stripe.com/docs/webhooks)
- [API Reference](https://stripe.com/docs/api)

## Support

For issues with the implementation:

1. Check Laravel logs: `storage/logs/laravel.log`
2. Check Stripe Dashboard for payment attempts
3. Review webhook delivery attempts in Stripe
4. Test with Stripe CLI: `stripe listen` and `stripe trigger`

For Stripe-specific issues, contact Stripe Support at [https://support.stripe.com](https://support.stripe.com)
