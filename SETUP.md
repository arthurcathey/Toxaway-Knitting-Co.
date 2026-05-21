# Toxaway Laravel Setup - Next Steps

## Current Status
- ✅ Composer installed locally at `../composer-bin/composer.phar`  
- ✅ Project directory scaffolded: `toxaway-laravel/`
- ❌ **SSL Certificate Issue**: PHP/Composer cannot verify HTTPS certificates due to system configuration or antivirus interference (Avast mentioned)

## Immediate Actions Required

### Option A: Fix SSL Certificate Issue (RECOMMENDED)
This enables you to use `composer require` normally going forward.

#### For Windows with Avast/Security Software:
1. **Temporarily disable** antivirus/firewall SSL inspection:
   - Avast: Settings → Privacy → Web Shield → Disable "SSL certificate verification"
   - Windows Defender: Settings → Virus & threat protection → Manage settings → Turn OFF Real-time protection temporarily

2. **Re-run Composer** from `toxaway-laravel/`:
   ```bash
   cd /c/Users/arthu/OneDrive/Desktop/WEB-213/toxaway-laravel
   php ../composer-bin/composer.phar install
   php ../composer-bin/composer.phar require laravel/framework laravel/breeze filament/filament spatie/laravel-permission
   ```

#### Alternative: Update PHP Certificate Bundle
```bash
php -r "print_r(openssl_get_cert_locations());"
```
Then download updated cacert.pem from https://curl.se/ca/cacert.pem and place in PHP folder.

---

### Option B: Manual Package Installation (If SSL Cannot Be Fixed)
Once SSL is resolved or in parallel:

```bash
cd /c/Users/arthu/OneDrive/Desktop/WEB-213/toxaway-laravel

# All commands use full composer path
php ../composer-bin/composer.phar install
php ../composer-bin/composer.phar require laravel/framework:^11
php ../composer-bin/composer.phar require laravel/breeze
php ../composer-bin/composer.phar require filament/filament
php ../composer-bin/composer.phar require spatie/laravel-permission
```

---

## Core Directory Structure (Created ✅)
```
toxaway-laravel/
├── app/
│   ├── Models/          → Eloquent models (Customer, Service, etc.)
│   ├── Http/
│   │   └── Controllers/ → Route controllers
│   ├── Filament/
│   │   └── Resources/   → Admin panel resources
│   └── Policies/        → Authorization policies
├── database/
│   ├── migrations/      → Database migrations
│   └── seeders/         → Database seeders
├── resources/
│   └── views/           → Blade templates
├── routes/
├── storage/
│   └── logs/
├── public/
├── composer.json        → Dependencies (will be populated by composer install)
├── .env.example         → Configuration template ✅
└── README.md
```

---

## Next Steps (In Order)

### 1️⃣ Resolve SSL Issue
- Follow **Option A** above
- Test: `php ../composer-bin/composer.phar update` should complete without SSL errors

### 2️⃣ Install Core Dependencies
```bash
php ../composer-bin/composer.phar install
```

### 3️⃣ Generate App Key
```bash
php artisan key:generate
```

### 4️⃣ Create Database Migrations
```bash
php artisan make:migration create_customers_table --create=customers
php artisan make:migration create_services_table --create=services
php artisan make:migration create_appointments_table --create=appointments
php artisan make:migration create_invoices_table --create=invoices
php artisan make:migration create_invoice_items_table --create=invoice_items
```

### 5️⃣ Create Models
```bash
php artisan make:model Customer
php artisan make:model Service
php artisan make:model Appointment
php artisan make:model Invoice
php artisan make:model InvoiceItem
```

### 6️⃣ Install Filament Admin
```bash
php artisan filament:install --panels
php artisan filament:make-admin
```

### 7️⃣ Create Filament Resources
```bash
php artisan make:filament-resource Customer --generate
php artisan make:filament-resource Service --generate
php artisan make:filament-resource Appointment --generate
php artisan make:filament-resource Invoice --generate
```

---

## Quick Test (After SSL Fixed)
```bash
cd /c/Users/arthu/OneDrive/Desktop/WEB-213/toxaway-laravel
cp .env.example .env
php ../composer-bin/composer.phar install
php artisan key:generate
php artisan serve
```
Then visit: `http://localhost:8000`

---

## Troubleshooting

**"Cannot find composer in PATH"**
→ Always use full path: `php ../composer-bin/composer.phar`

**"SQLSTATE[HY000]: General error: 1"**
→ Database not configured. Set `DB_*` in `.env` and run `php artisan migrate`

**"SSL certificate verification failed"**
→ See **Option A** in "Immediate Actions Required"

---

## What's in This Skeleton
- ✅ `.env.example` with all config keys
- ✅ Directory structure for Models, Controllers, Filament Resources, Migrations
- ✅ Ready for `composer install` once SSL is resolved

Once Composer works, all dependencies (Laravel framework, Filament, Breeze, permissions) will be installed automatically.
