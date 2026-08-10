# Upload to Bluehost via cPanel File Manager

## Quick Start: Upload via cPanel

### Step 1: Log Into cPanel
1. Go to: https://toxawayknittingcompany.com/cpanel
   - OR go to your Bluehost account → Click **cPanel**
2. Enter your username and password
3. You're in the cPanel dashboard

---

### Step 2: Open File Manager
1. In cPanel, find **File Manager**
2. Click it
3. Navigate to **public_html** (this is your website root)

---

### Step 3: Create Database First (IMPORTANT!)

**Before uploading, create your database:**

1. In cPanel, find **MySQL Databases**
2. Click it
3. **Create New Database:**
   - Name: `toxaway_production`
   - Click **Create Database**
4. **Create New User:**
   - Username: `toxaway_user`
   - Password: Generate strong password (save this!)
   - Click **Create User**
5. **Add User to Database:**
   - Select the user and database
   - Click **Add**
   - Check **ALL PRIVILEGES**
   - Click **Make Changes**

✅ Save these credentials:
```
Database: toxaway_production
Username: toxaway_user
Password: [YOUR_PASSWORD]
```

---

### Step 4: Create .env File in cPanel

1. Still in **File Manager**, right-click in `public_html`
2. Click **Create New File**
3. Name it: `.env` (exactly)
4. Click **Create**
5. Right-click the `.env` file
6. Click **Edit** (or **Code Edit**)
7. Copy and paste this content:

```
APP_NAME="Toxaway Knitting Co."
APP_ENV=production
APP_KEY=base64:GuSaL/smL60wJMXXyMKzS1mSSPVZPMPPUFSMpQ3ECnk=
APP_DEBUG=false
APP_URL=https://toxawayknittingcompany.com

CACHE_DRIVER=file
SESSION_DRIVER=file
QUEUE_CONNECTION=sync

DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=toxaway_production
DB_USERNAME=toxaway_user
DB_PASSWORD=YOUR_PASSWORD_FROM_STEP_3

MAIL_MAILER=smtp
MAIL_HOST=smtp.bluehost.com
MAIL_PORT=465
MAIL_USERNAME=hello@toxawayknittingcompany.com
MAIL_PASSWORD=YOUR_EMAIL_PASSWORD
MAIL_FROM_ADDRESS=hello@toxawayknittingcompany.com
MAIL_FROM_NAME="Toxaway Knitting Co."
```

**REPLACE:**
- `YOUR_PASSWORD_FROM_STEP_3` - database password
- `YOUR_EMAIL_PASSWORD` - your email password (or leave blank for now)

8. Click **Save** or **Close**

---

### Step 5: Upload Files via cPanel File Manager

#### Step 5A: Create Compressed Archive (RECOMMENDED - Much Faster!)

**On your computer:**

1. Open **File Explorer**
2. Navigate to: `C:\Users\arthu\OneDrive\Desktop\WEB-213\toxaway-laravel-fresh`
3. Select these folders/files:
   - `app/`
   - `bootstrap/`
   - `config/`
   - `database/`
   - `public/`
   - `resources/`
   - `routes/`
   - `storage/`
   - `vendor/`
   - `artisan`
   - `composer.json`
   - `composer.lock`

4. Right-click → **Send to → Compressed (zipped) folder**
5. Name it: `toxaway-upload.zip`
6. Wait for compression (this may take 2-3 minutes due to `vendor/` size)

#### Step 5B: Upload .zip File via cPanel

1. Open **File Manager** in cPanel (should still be open)
2. Make sure you're in `public_html`
3. Click **Upload** button (top toolbar)
4. Drag and drop `toxaway-upload.zip` into the upload area
   - OR click to browse and select the file
5. Wait for upload to complete (may take 5-10 minutes)

#### Step 5C: Extract .zip File

1. After upload completes, right-click `toxaway-upload.zip`
2. Click **Extract** 
3. Click **Extract File(s)**
4. Wait for extraction to complete

✅ All your files are now in `public_html/`!

---

### Step 6: Run Laravel Setup Commands via cPanel Terminal

1. In cPanel, find and click **Terminal**
2. You should see a black terminal window
3. Run these commands one at a time:

```bash
cd public_html
```

```bash
composer install --optimize-autoloader --no-dev
```

```bash
php artisan key:generate
```

```bash
php artisan migrate --force
```

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

```bash
chmod -R 755 storage bootstrap/cache
```

✅ Each command should show success messages

---

### Step 7: Set Proper Permissions

Still in Terminal:

```bash
chmod 644 .env
chmod 755 public
chmod -R 755 storage
chmod -R 755 bootstrap/cache
```

---

### Step 8: Test Your Website

1. Open browser
2. Visit: **https://toxawayknittingcompany.com**
3. Check:
   - ✅ Page loads without errors
   - ✅ Styling is visible (CSS applied)
   - ✅ Images display
   - ✅ Navigation works

---

### Step 9: Verify All Features Work

Test these on the live site:

✅ **Homepage** - https://toxawayknittingcompany.com
✅ **Shop** - https://toxawayknittingcompany.com/shop
✅ **Product Page** - https://toxawayknittingcompany.com/shop/riding-sweater-merino
✅ **Cart** - https://toxawayknittingcompany.com/cart
✅ **Add to Cart** - Select color/size and add item
✅ **Remove from Cart** - Click remove button

---

## If You Get Errors...

### Error: "500 Internal Server Error"

1. In cPanel **Terminal**, run:
```bash
tail -50 storage/logs/laravel.log
```

2. Look for the error message
3. Common issues:
   - Wrong database password
   - Missing `.env` file
   - Database doesn't exist

### Error: "Database Connection Error"

1. Check `.env` has correct:
   - `DB_DATABASE=toxaway_production`
   - `DB_USERNAME=toxaway_user`
   - `DB_PASSWORD=YOUR_PASSWORD`

2. In cPanel Terminal, test:
```bash
mysql -u toxaway_user -p toxaway_production
```
(Enter password when prompted)

If it connects → `mysql>` shows, your DB is OK

### Error: "Page Not Found" / 404

Ensure `.htaccess` exists in `public_html`:

1. In File Manager, make sure you see `.htaccess` in `public_html`
2. If not, create it:
   - Right-click → **Create New File**
   - Name: `.htaccess`
   - Edit and paste:

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

## Summary of cPanel Tools You'll Use

| Tool | Purpose |
|------|---------|
| **File Manager** | Upload and manage files |
| **MySQL Databases** | Create database and user |
| **Terminal** | Run Laravel commands |
| **Error Log** | Debug problems |

---

## Typical Timeline

| Step | Time | Notes |
|------|------|-------|
| Create database | 2 min | Quick in cPanel |
| Create .env | 5 min | Copy-paste |
| Compress files | 5-15 min | Depends on internet speed |
| Upload .zip | 5-15 min | Depends on file size |
| Extract | 2-5 min | Automatic |
| Run commands | 3-5 min | Automatic |
| **Total** | **25-60 min** | All steps |

---

## QUICK REFERENCE

**Terminal Commands to Remember:**

```bash
# Check if everything is working
php artisan tinker
>>> exit

# View errors
tail -50 storage/logs/laravel.log

# Clear all caches
php artisan cache:clear && php artisan config:clear

# Fix permissions
chmod -R 755 storage bootstrap/cache
```

---

**You're ready! Start with Step 1 and follow each step carefully.** 👍
