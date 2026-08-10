# Toxaway Knitting Co. - Bluehost Deployment Checklist

## Your Bluehost Account Info
- **Domain:** toxawayknittingcompany.com
- **Temporary URL:** http://hqk.mwg.mybluehost.me/website_83332210
- **Access:** cPanel + PHPMyAdmin available

---

## ✅ STEP 1: Get FTP Credentials

**In Bluehost cPanel:**
1. Go to **FTP Accounts** or **FTP Connections**
2. Look for your main FTP account (usually `toxawayknittingcompany`)
3. Note down:
   - **FTP Host:** (something like `ftpXXX.bluehost.com`)
   - **FTP Username:** (usually your primary account user)
   - **FTP Password:** (your Bluehost password)
   - **Port:** 21 (standard FTP)

---

## ✅ STEP 2: Create Database via cPanel

**In Bluehost cPanel:**
1. Go to **MySQL Databases**
2. Click **Create New Database**
3. Database name: `toxaway_production`
4. Click **Create Database**
5. Go to **MySQL Users**
6. Create new user:
   - Username: `toxaway_user`
   - Password: (generate strong password)
7. Add user to database with ALL privileges
8. **SAVE THESE CREDENTIALS** - you'll need them in `.env`

---

## ✅ STEP 3: Prepare Production Environment File

Create a text file with these contents (save as `env-production.txt`):

```
APP_NAME="Toxaway Knitting Co."
APP_ENV=production
APP_KEY=base64:GuSaL/smL60wJMXXyMKzS1mSSPVZPMPPUFSMpQ3ECnk=
APP_DEBUG=false
APP_URL=https://toxawayknittingcompany.com

CACHE_DRIVER=file
SESSION_DRIVER=file
QUEUE_CONNECTION=sync

BROADCAST_DRIVER=log

DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=toxaway_production
DB_USERNAME=toxaway_user
DB_PASSWORD=[PASSWORD_FROM_STEP_2]

MAIL_MAILER=smtp
MAIL_HOST=smtp.bluehost.com
MAIL_PORT=465
MAIL_USERNAME=[YOUR_EMAIL@toxawayknittingcompany.com]
MAIL_PASSWORD=[YOUR_EMAIL_PASSWORD]
MAIL_FROM_ADDRESS=hello@toxawayknittingcompany.com
MAIL_FROM_NAME="Toxaway Knitting Co."
```

**Replace:**
- `[PASSWORD_FROM_STEP_2]` with the database user password
- `[YOUR_EMAIL@toxawayknittingcompany.com]` with your email
- `[YOUR_EMAIL_PASSWORD]` with email password (or skip if not sending emails yet)

---

## ✅ STEP 4: Upload Files via FTP

**Download FileZilla:**
- https://filezilla-project.org/

**Upload Process:**

1. **Open FileZilla**
2. **File → Site Manager → New Site**
3. Enter FTP credentials from Step 1:
   - Host: `ftpXXX.bluehost.com`
   - Username: Your FTP username
   - Password: Your FTP password
   - Port: 21
4. **Connect**
5. Navigate to `public_html` folder (right pane)

**Upload these folders/files:**

✅ Upload (from left pane to right pane):
```
app/
bootstrap/
config/
database/
public/           (includes build/ with minified assets)
resources/
routes/
storage/
vendor/
artisan
composer.json
composer.lock
package.json
index.php
.htaccess
```

❌ DO NOT upload:
```
.env                (you'll create on server)
node_modules/
.git/
.gitignore
```

---

## ✅ STEP 5: Create .env File on Server

**Option A: Using Bluehost File Manager**
1. Go to cPanel → **File Manager**
2. Navigate to `public_html`
3. Right-click → **Create New File**
4. Name: `.env`
5. Right-click → **Edit**
6. Paste the contents from Step 3
7. Save

**Option B: Using SSH (if available)**
1. In cPanel, go to **Terminal**
2. Run:
```bash
cd public_html
nano .env
```
3. Paste contents from Step 3
4. Press Ctrl+X, Y, Enter

---

## ✅ STEP 6: Run Setup Commands

**In Bluehost cPanel → Terminal:**

```bash
# Navigate to your site
cd public_html

# Install Laravel dependencies
composer install --optimize-autoloader --no-dev

# Generate Laravel encryption key
php artisan key:generate

# Create necessary tables
php artisan migrate --force

# Seed database with products (optional)
php artisan db:seed --force

# Cache configuration (improves performance)
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Set proper permissions
chmod -R 755 storage
chmod -R 755 bootstrap/cache
```

---

## ✅ STEP 7: Verify Website is Live

1. Visit: `https://toxawayknittingcompany.com`
2. Check:
   - ✅ Homepage loads
   - ✅ Styling/CSS visible
   - ✅ Navigation works
   - ✅ Products display
   - ✅ Cart functionality works

---

## ✅ STEP 8: Enable HTTPS/SSL

**In Bluehost cPanel:**
1. Go to **SSL/TLS Status**
2. Find `toxawayknittingcompany.com`
3. Verify SSL is **installed** (should be auto with AutoSSL)
4. Go to **Redirects**
5. Redirect HTTP to HTTPS:
   - From: `http://toxawayknittingcompany.com`
   - To: `https://toxawayknittingcompany.com`

---

## 🔧 Troubleshooting

### **500 Internal Server Error**
1. Check error log: cPanel → **Error Log**
2. Or via SSH: `tail -100 storage/logs/laravel.log`
3. Common issues:
   - Wrong database credentials
   - Missing `.env` file
   - Incorrect file permissions

### **Database Connection Error**
```bash
# Test from SSH:
mysql -u toxaway_user -p -h localhost toxaway_production

# Should show: mysql>
```

### **CSS/Images Not Loading**
```bash
# Run from SSH:
php artisan config:cache
php artisan optimize
```

### **Page Not Found / 404 Errors**
Ensure `.htaccess` is in `public_html/`:
```apache
<IfModule mod_rewrite.c>
    <IfModule mod_negotiation.c>
        Options -MultiViews -Indexes
    </IfModule>

    RewriteEngine On

    RewriteCond %{HTTP:Authorization} .
    RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]

    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_URI} (.+)/$
    RewriteRule ^ %1 [L,R=301]

    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^ index.php [L]
</IfModule>
```

---

## 📋 Quick Reference: Commands

```bash
# SSH into account (from Terminal/Command Prompt)
ssh username@toxawayknittingcompany.com

# Navigate to site
cd public_html

# View Laravel logs
tail -f storage/logs/laravel.log

# Clear all caches
php artisan cache:clear
php artisan config:clear

# Restart queue (if using jobs)
php artisan queue:restart

# Check PHP version
php -v

# Check Laravel status
php artisan tinker
>>> exit
```

---

## 🎯 Next Steps

1. **Today:**
   - [ ] Get FTP credentials from cPanel
   - [ ] Create database via cPanel
   - [ ] Prepare `.env` file

2. **Tomorrow:**
   - [ ] Upload files via FileZilla
   - [ ] Create `.env` on server
   - [ ] Run migration commands

3. **Verification:**
   - [ ] Test website at domain
   - [ ] Test all functionality
   - [ ] Check error logs

---

**Questions?** Check:
- Laravel Docs: https://laravel.com/docs
- Bluehost Support: https://www.bluehost.com/contact-us
