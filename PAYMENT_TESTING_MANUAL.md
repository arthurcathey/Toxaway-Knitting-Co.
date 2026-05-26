# 🧪 Toxaway Stripe Payment System - Manual Testing Guide

## Test Environment
- **Date**: May 26, 2026
- **Mode**: Test (no real charges)
- **Stripe Test Keys**: ✅ Configured
- **App URL**: http://localhost:8000
- **Test Card**: 4242 4242 4242 4242 (always succeeds in test mode)

## Pre-Test Verification

### ✅ Step 1: Verify Configuration
```bash
# Check .env has keys
cat .env | grep STRIPE_

# Expected output:
# STRIPE_PUBLIC_KEY=pk_test_51TbO5ePwRPw95srm...
# STRIPE_SECRET_KEY=sk_test_51TbO5ePwRPw95srm...
# STRIPE_WEBHOOK_SECRET=whsec_test_placeholder
```

### ✅ Step 2: Verify Database
```bash
# Check if orders table has payment columns
sqlite3 database/database.sqlite "PRAGMA table_info(orders);" | grep -E "user_id|stripe_charge_id|paid_at"

# Expected: Should show columns like: user_id, stripe_charge_id, paid_at, payment_method
```

### ✅ Step 3: Check Routes
- GET `/checkout/payment` - Payment form
- POST `/checkout/payment` - Process payment
- GET `/checkout/success` - Success page
- GET `/checkout/failure` - Failure page
- POST `/webhook/stripe` - Webhook handler

## Manual Test Steps

### 📝 Test 1: Browse Payment Form

1. **Clear Session** (to start fresh)
   ```bash
   rm -f storage/framework/sessions/*
   ```

2. **Navigate to Shop**
   - Open: http://localhost:8000/shop
   - Verify products display

3. **Add Item to Cart**
   - Click "Add to Cart" on any product
   - Select size if applicable
   - Verify item added to cart

4. **Go to Cart**
   - Click "View Cart"
   - Verify cart displays item(s)
   - Click "Proceed to Checkout"

5. **Payment Form**
   - Should display at: http://localhost:8000/checkout/payment
   - Verify form elements:
     - ✓ Order summary showing items and total
     - ✓ Shipping $15.00 added
     - ✓ Full name field
     - ✓ Email field
     - ✓ Phone field
     - ✓ Address fields (street, city, state, zip, country)
     - ✓ Card element (Stripe Elements)
     - ✓ Submit button

### 💳 Test 2: Test Successful Payment

**Fill Form with Test Data:**
```
Full Name:     John Doe
Email:         john+test@example.com
Phone:         555-123-4567
Address:       123 Main Street
City:          Asheville
State:         NC
Zip:           28801
Country:       United States
```

**Card Information (Test Card):**
```
Card Number:   4242 4242 4242 4242
Expiry:        Any future date (e.g., 12/25)
CVC:           Any 3 digits (e.g., 123)
```

**Expected Results:**
- ✓ Form validates
- ✓ Card element accepts input
- ✓ "Submit Payment" button processes
- ✓ Redirects to success page
- ✓ Order created in database with `status: 'confirmed'`
- ✓ Confirmation email sent

### 📊 Test 3: Verify Database Changes

After successful payment:

```bash
# View all orders
sqlite3 database/database.sqlite "SELECT id, status, total_amount, stripe_charge_id, paid_at FROM orders ORDER BY id DESC LIMIT 5;"

# View order items
sqlite3 database/database.sqlite "SELECT order_id, product_id, quantity, price FROM order_items WHERE order_id = <YOUR_ORDER_ID>;"

# Verify columns exist
sqlite3 database/database.sqlite ".schema orders" | grep -A5 "CREATE TABLE"
```

**Expected:**
- Order record with `status = 'confirmed'`
- `stripe_charge_id` populated with Stripe charge ID
- `paid_at` timestamp set
- `total_amount` matches form total
- Associated order_items entries

### 📧 Test 4: Check Email Sent

Since MAIL_DRIVER=log in development:

```bash
# Check mail log
tail -100 storage/logs/laravel.log | grep -i "orderconfirmation\|to:\|subject:"
```

**Expected:**
- Mail driver: log
- Email goes to: john+test@example.com
- Subject: Something about "Order Confirmation"
- Body contains: Order number, items, total, shipping address

### ❌ Test 5: Test Failed Payment Scenarios

**Card that declines (in test mode):**
- Card: `4000 0000 0000 0002` (Insufficient funds)
- Expected: Error message displayed, order NOT created

**Validation failures:**
- Leave Name field blank → Should show validation error
- Invalid email → Should show validation error
- Empty cart → Should redirect to shop

### 🔔 Test 6: Webhook Handling

Webhooks won't work in local development without ngrok. For production:

```bash
# Configure Stripe Dashboard Webhook
URL: https://yourdomain.com/webhook/stripe
Events: charge.succeeded, charge.failed, charge.refunded
```

## Success Criteria

✅ **All tests pass if:**
1. Payment form displays with empty cart redirect
2. Payment form loads properly with cart items
3. Form validates all fields
4. Test card payment succeeds
5. Order created in database
6. Email sent (appears in laravel.log)
7. Confirmation page displays order details
8. Failed card is declined
9. Navigation links work

❌ **Blockers if:**
- Stripe keys not working
- Database not migrated
- Email not sent
- Order not created
- PaymentController has errors

## Debugging Tips

**If payment form doesn't load:**
```bash
curl -s http://localhost:8000/checkout/payment
# Should NOT be a redirect (means cart is empty)
# Should show HTML form
```

**If Stripe errors:**
```bash
tail -100 storage/logs/laravel.log | grep -i "stripe\|payment\|error"
```

**If database issues:**
```bash
sqlite3 database/database.sqlite "SELECT name FROM sqlite_master WHERE type='table';"
# Should show: orders, order_items, products, etc.
```

**If email not sent:**
- Check MAIL_MAILER=log is set in .env
- Check OrderConfirmation mail class exists
- Check storage/logs/laravel.log for mail entries

## Next Steps After Testing

1. ✅ **All tests pass** → Ready for production HTTPS setup
2. ❌ **Some tests fail** → Debug and fix before launch
3. 🔔 **Webhook needed** → Set up ngrok or production server

