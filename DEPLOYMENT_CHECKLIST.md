# 🚀 Production Deployment Checklist - Bluehost

**Project**: Toxaway Knitting Co. E-Commerce  
**Date**: May 26, 2026  
**Status**: Ready for Bluehost deployment

---

## ✅ Phase 1: Pre-Deployment (Do First)

### Requirements
- [ ] Domain name (yourdomain.com)
- [ ] Bluehost account active
- [ ] cPanel access working
- [ ] Git repository (https://github.com/arthurcathey/Toxaway-Knitting-Co.)

### Get Live Stripe Keys
- [ ] Go to https://dashboard.stripe.com
- [ ] Developers → API Keys
- [ ] Toggle "View test data" OFF
- [ ] Copy: Publishable Key (pk_live_...)
- [ ] Copy: Secret Key (sk_live_...)
- [ ] Save in secure location

---

## ✅ Phase 2: Bluehost Setup (30 min)

- [ ] Log into Bluehost cPanel
- [ ] Create addon domain (if needed)
- [ ] Enable AutoSSL certificate
- [ ] Wait for SSL certificate (10-30 min)
- [ ] Verify: `https://yourdomain.com` loads
- [ ] Create MySQL database: `toxaway_db`
- [ ] Create MySQL user: `toxaway_user` (strong password!)
- [ ] Add user to database with ALL privileges
- [ ] Create FTP account (for file uploads)

---

## ✅ Phase 3: Deploy Code (20 min)

**Via SSH (Recommended):**
```bash
cd /public_html
mkdir toxaway-knitting
cd toxaway-knitting
git clone https://github.com/YOUR_USERNAME/toxaway-knitting-co.git .
composer install --optimize-autoloader --no-dev
npm install && npm run build
```

**Via FTP:**
- [ ] Download FileZilla
- [ ] Connect to `ftp.yourdomain.com` with FTP account
- [ ] Upload all files to `/public_html/toxaway-knitting/`
- [ ] Skip: `node_modules/`, `vendor/`, `.git/`
- [ ] On Bluehost, run `composer install` and `npm run build`

---

## ✅ Phase 4: Configure Environment (10 min)

Edit `/public_html/toxaway-knitting/.env`:

```
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com

DB_HOST=localhost
DB_DATABASE=toxaway_db
DB_USERNAME=toxaway_user
DB_PASSWORD=<strong-password>

STRIPE_PUBLIC_KEY=pk_live_XXXXX
STRIPE_SECRET_KEY=sk_live_XXXXX
STRIPE_WEBHOOK_SECRET=whsec_XXXXX

MAIL_MAILER=mailgun
MAIL_FROM_ADDRESS=support@yourdomain.com
```

---

## ✅ Phase 5: Database & Caches (10 min)

```bash
cd /public_html/toxaway-knitting

# Run migrations
php artisan migrate --force

# Clear all caches
php artisan config:cache
php artisan view:cache
php artisan route:cache
php artisan cache:clear

# Set permissions
chmod 755 .
chmod -R 755 storage
chmod -R 755 bootstrap/cache
chmod 644 .env
```

---

## ✅ Phase 6: Configure Stripe Webhook (5 min)

1. Stripe Dashboard → Developers → Webhooks
2. Click "Add Endpoint"
3. **URL**: `https://yourdomain.com/webhook/stripe`
4. **Events**: 
   - charge.succeeded
   - charge.failed
   - charge.refunded
5. Copy "Signing secret" → Update `.env` as `STRIPE_WEBHOOK_SECRET`

---

## ✅ Phase 7: Set Up Email (5 min)

**Option A: Mailgun (Recommended)**
1. Sign up at https://www.mailgun.com (free: 5,000/month)
2. Add domain: yourdomain.com
3. Verify domain (add DNS records in Bluehost cPanel)
4. Get SMTP credentials
5. Update `.env` with MAIL_* values

**Option B: Bluehost SendGrid**
- Bluehost may include SendGrid - check cPanel

---

## ✅ Phase 8: Final Testing (15 min)

### Test 1: Browse Website
- [ ] Open `https://yourdomain.com`
- [ ] Padlock icon shows (HTTPS working)
- [ ] Homepage loads
- [ ] Products display
- [ ] No errors in console

### Test 2: Add to Cart
- [ ] Click "Add to Cart"
- [ ] Item appears in cart
- [ ] Proceed to checkout

### Test 3: Payment Form
- [ ] Form loads at `/checkout/payment`
- [ ] All fields present
- [ ] Stripe card element loads

### Test 4: Process Payment
- [ ] Fill form with test data
- [ ] Use test card: `4242 4242 4242 4242`
- [ ] Click Pay
- [ ] Success page appears
- [ ] Order number visible
- [ ] Email sent to test address

### Test 5: Database Verify
```bash
# SSH into server:
cd /public_html/toxaway-knitting
php -r "
\$db = new PDO('mysql:host=localhost;dbname=toxaway_db', 'toxaway_user', 'PASSWORD');
\$stmt = \$db->query('SELECT COUNT(*) as count FROM orders WHERE status = \"confirmed\"');
\$result = \$stmt->fetch();
echo 'Confirmed orders: ' . \$result['count'] . PHP_EOL;
"
```

### Test 6: Check Logs
```bash
tail -50 storage/logs/laravel.log
# Should show: Mail sent, no errors
```

---

## ✅ Phase 9: Production Launch Checklist

### Before Going Live
- [ ] All tests pass
- [ ] HTTPS working (padlock icon)
- [ ] SSL certificate valid
- [ ] Database migrated
- [ ] Stripe live keys active
- [ ] Webhook configured
- [ ] Email sends successfully
- [ ] No errors in logs
- [ ] Permissions set correctly (755, 644)
- [ ] .env file has production values

### Go Live!
- [ ] Remove any test/demo products
- [ ] Update contact information
- [ ] Verify support email works
- [ ] Announce launch! 🎉

---

## ✅ Post-Launch Tasks (Week 1)

- [ ] Monitor logs for errors
- [ ] Check Stripe dashboard for transactions
- [ ] Verify payments are processing
- [ ] Test declined card (4000 0000 0000 0002)
- [ ] Set up automated database backups
- [ ] Monitor email delivery
- [ ] Check page load times

---

## 🚨 Common Issues & Fixes

| Issue | Fix |
|-------|-----|
| 404 on homepage | Set Document Root to `/public` in cPanel |
| "Command not found: git" | Use FTP upload instead |
| Database connection fails | Verify credentials match cPanel MySQL settings |
| SSL certificate not installed | Wait 30 min for AutoSSL to process |
| Emails not sending | Check Mailgun DNS records, verify credentials |
| Stripe returns errors | Ensure live keys (pk_live_, sk_live_), not test keys |
| White blank page | Check `storage/logs/laravel.log` for PHP errors |

---

## 📞 Support Contacts

- **Bluehost Support**: 24/7 live chat in cPanel
- **Stripe Support**: https://support.stripe.com
- **Mailgun Support**: https://support.mailgun.com
- **Your App Logs**: `storage/logs/laravel.log`

---

## 🎯 Timeline Estimate

- **Phase 1-3**: 1 hour (setup + deploy)
- **Phase 4-6**: 30 minutes (config + database)
- **Phase 7**: 15 minutes (email setup)
- **Phase 8**: 15 minutes (testing)
- **Total**: ~2 hours for complete production deployment

---

## 📝 Important Notes

1. **Do NOT skip HTTPS** - Stripe requires it for live keys
2. **Database password** - Use strong, unique password
3. **Stripe keys** - Separate test vs live - never mix them
4. **Email setup** - Don't skip this, customers need confirmations
5. **Backups** - Enable Bluehost automated backups
6. **Logs** - Monitor `storage/logs/laravel.log` daily first week

---

## ✅ You're Ready!

Your payment system is tested and working. Follow this checklist step-by-step to go live on Bluehost.

**Estimated time**: 2-3 hours  
**Difficulty**: Intermediate (mostly configuration)  
**Support**: Available 24/7 if issues arise

