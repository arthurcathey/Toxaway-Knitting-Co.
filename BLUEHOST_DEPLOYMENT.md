# Bluehost Deployment Guide for Toxaway Knitting Co.

## Pre-Deployment Checklist

- [ ] Verify Bluehost hosting plan supports PHP and MySQL
- [ ] Get FTP/SFTP credentials from Bluehost cPanel
- [ ] Get database credentials (Host, Username, Password, Database name)
- [ ] Get domain name information

## Step 1: Prepare Production Environment

### Update .env for Production
```bash
APP_DEBUG=false
APP_ENV=production
APP_URL=https://yourdomain.com  # Replace with your actual domain

# Database (from Bluehost cPanel)
DB_CONNECTION=mysql
DB_HOST=localhost  # or your database host
DB_PORT=3306
DB_DATABASE=your_db_name
DB_USERNAME=your_db_user
DB_PASSWORD=your_db_password

# Mail (optional)
MAIL_MAILER=smtp
MAIL_HOST=smtp.bluehost.com
MAIL_PORT=465
MAIL_USERNAME=your_email
MAIL_PASSWORD=your_email_password
MAIL_FROM_ADDRESS=hello@yourdomain.com
```

## Step 2: Production Build

Run the production build before uploading:

```bash
npm run build
```

This creates optimized assets in `public/build/`.

## Step 3: Upload Files via FTP/SFTP

### Files to Upload to `public_html/` or your domain folder:

**Root Files:**
- `app/`
- `bootstrap/`
- `config/`
- `database/`
- `resources/`
- `routes/`
- `storage/`
- `vendor/`
- `.env` (create on server, don't upload from local)
- `artisan`
- `composer.json`
- `composer.lock`
- `package.json`
- `package-lock.json`

**Public Files (upload to public_html/):**
- `index.php`
- `.htaccess` (Laravel requires this)
- `build/` (compiled assets)
- `favicon.svg`
- All other public assets

### Files to SKIP (don't upload):
- `.git/`
- `node_modules/`
- `.env.local`
- `.env.*.local`
- `storage/logs/`

## Step 4: Server Configuration (Bluehost cPanel)

### 1. Create MySQL Database
- Go to cPanel → MySQL Databases
- Create new database
- Create database user
- Assign all privileges to user
- Note credentials for .env

### 2. Create .env file on server
- SSH into server OR use File Manager
- Navigate to application root
- Create `.env` file with production settings (see Step 1)

### 3. Run Laravel Setup
SSH into your hosting account:

```bash
cd public_html

# Install composer dependencies (if not already vendor/ folder)
composer install --optimize-autoloader --no-dev

# Generate Laravel key
php artisan key:generate

# Run migrations
php artisan migrate --force

# Seed database (if needed)
php artisan db:seed --force

# Clear caches
php artisan config:cache
php artisan view:cache
php artisan route:cache

# Set permissions
chmod -R 755 storage
chmod -R 755 bootstrap/cache
```

### 4. Configure .htaccess
Create/verify `.htaccess` in `public_html/`:

```apache
<IfModule mod_rewrite.c>
    <IfModule mod_negotiation.c>
        Options -MultiViews -Indexes
    </IfModule>

    RewriteEngine On

    # Handle Authorization Header
    RewriteCond %{HTTP:Authorization} .
    RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]

    # Redirect Trailing Slashes If Not A Folder...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_URI} (.+)/$
    RewriteRule ^ %1 [L,R=301]

    # Send Requests To Front Controller...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^ index.php [L]
</IfModule>
```

### 5. Enable HTTPS
- Go to cPanel → SSL/TLS
- Install free SSL certificate (AutoSSL)
- Verify it's enabled for your domain

### 6. Set Proper PHP Version
- Go to cPanel → Select PHP Version
- Choose PHP 8.2 or higher

## Step 5: Upload via FTP (FileZilla)

### Download FileZilla
- https://filezilla-project.org/

### Connection Details from Bluehost:
1. Open FileZilla
2. File → Site Manager
3. Enter:
   - Host: Your FTP hostname (from Bluehost)
   - Username: Your FTP username
   - Password: Your FTP password
   - Port: 21 (FTP) or 22 (SFTP)

4. Connect and navigate to `public_html/`
5. Upload all files except those listed in "Files to SKIP"

## Step 6: Verify Installation

1. Visit your domain: `https://yourdomain.com`
2. Check if site loads correctly
3. Test key functionality:
   - Homepage loads
   - Navigation works
   - Product pages display
   - Cart functionality works
   - Add/remove items works

## Troubleshooting

### 500 Internal Server Error
- Check `storage/logs/laravel.log` for errors
- Verify `.env` database credentials
- Ensure PHP version is 8.2+
- Check file permissions (775 for storage/bootstrap)

### Database Connection Error
- Verify DB credentials in `.env`
- Confirm database exists in cPanel
- Check database user has proper permissions

### CSS/JS Not Loading
- Run `php artisan optimize`
- Verify `public/build/` directory uploaded
- Check `.htaccess` is present

### Asset Path Issues
- Verify `APP_URL` in `.env` matches domain
- Run `php artisan config:cache`

## Post-Deployment

1. **Monitor Logs**: Check `storage/logs/laravel.log` regularly
2. **Set Up Email**: Configure SMTP in `.env` for transactional emails
3. **SSL Certificate**: Verify HTTPS works and redirect HTTP to HTTPS
4. **Backups**: Set up automatic backups in Bluehost cPanel
5. **Performance**: Monitor Lighthouse score on production domain

## Important Security Notes

- Never commit `.env` to git
- Always use HTTPS
- Keep APP_DEBUG=false in production
- Regularly update Laravel and dependencies
- Use strong database passwords
- Enable two-factor authentication on Bluehost account

---

**Need Help?**
- Bluehost Support: https://www.bluehost.com/contact-us
- Laravel Docs: https://laravel.com/docs
- SSH Commands: Use Bluehost Terminal in cPanel
