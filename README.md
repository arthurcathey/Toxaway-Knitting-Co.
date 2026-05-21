# Toxaway Knitting Company - Laravel Admin & Ecommerce Platform

A Laravel 11 + Filament application for managing a knitting company's ecommerce operations, customer relationships, and custom product lead capture.

---

## 📋 Project Overview

**Purpose:** Build a modern web platform for Toxaway Knitting Company combining:
- 🏢 **Admin Dashboard** — Customer, order, and invoice management
- 🛍️ **Public Ecommerce** — Sell standard products (sweaters, riding wear)
- 👔 **Custom Jacket Lead Capture** — Collect requirements for high-value custom items

**Technology Stack:**
- Laravel 11 (PHP framework)
- Filament 3 (Admin panel)
- Laravel Breeze (Authentication)
- Spatie Laravel Permission (Role-based access control)
- MySQL/PostgreSQL (Database)

---

## 🗂️ Architecture

### Database Schema

```
┌─────────────────────────────────────────────────────────────┐
│                      CUSTOMERS                              │
├─────────────────────────────────────────────────────────────┤
│ id (PK) | name | email | phone | notes | timestamps         │
└────────────────┬──────────────────────────────────────────┬──┘
                 │ 1:M                              1:M     │
      ┌──────────▼────────┐                ┌────────▼─────────┐
      │   APPOINTMENTS    │                │    INVOICES      │
      ├───────────────────┤                ├──────────────────┤
      │ id (PK)           │                │ id (PK)          │
      │ customer_id (FK)  │                │ customer_id (FK) │
      │ service_id (FK)   │                │ appointment_id   │
      │ starts_at         │                │ invoice_number   │
      │ ends_at           │                │ status (enum)    │
      │ status (enum)     │                │ subtotal, tax    │
      │ notes             │                │ total, timestamps│
      │ timestamps        │                └────────┬─────────┘
      └───┬────────────┬──┘                         │ 1:M
          │ FK         │ FK                         │
          │            │              ┌─────────────▼──────────┐
          │            └──────────────▶│   INVOICE_ITEMS       │
          │                            ├───────────────────────┤
      ┌───▼────────────────┐           │ id (PK)               │
      │     SERVICES       │           │ invoice_id (FK)       │
      ├────────────────────┤           │ service_id (FK, null) │
      │ id (PK)            │           │ description           │
      │ name               │           │ quantity, unit_price  │
      │ default_price      │           │ line_total            │
      │ default_duration   │           │ timestamps            │
      │ is_active          │           └───────────────────────┘
      │ timestamps         │
      └────────────────────┘
```

### Entity Relationships

| Entity | Relationships |
|--------|--------------|
| **Customer** | hasMany(Appointment), hasMany(Invoice) |
| **Service** | hasMany(Appointment), hasMany(InvoiceItem) |
| **Appointment** | belongsTo(Customer), belongsTo(Service), hasOne(Invoice) |
| **Invoice** | belongsTo(Customer), belongsTo(Appointment), hasMany(InvoiceItem) |
| **InvoiceItem** | belongsTo(Invoice), belongsTo(Service) |

### Status Workflows

**Appointment Status:**
- `requested` → New consultation request
- `scheduled` → Confirmed appointment
- `completed` → Service delivered
- `paid` → Payment received
- `canceled` → Cancelled or void

**Invoice Status:**
- `draft` → Not yet sent to customer
- `sent` → Sent to customer for payment
- `paid` → Payment received & reconciled
- `void` → Cancelled invoice

---

## 📁 Project Structure

```
toxaway-laravel/
├── app/
│   ├── Models/
│   │   ├── User.php                 # Authentication user
│   │   ├── Customer.php             # Customer entity
│   │   ├── Service.php              # Products/services catalog
│   │   ├── Appointment.php          # Orders/consultations
│   │   ├── Invoice.php              # Billing documents
│   │   └── InvoiceItem.php          # Invoice line items
│   ├── Http/
│   │   └── Controllers/             # Route controllers (TBD)
│   └── Filament/
│       └── Resources/               # Admin panel resources (TBD)
│
├── database/
│   ├── migrations/
│   │   ├── 2024_05_19_000001_create_customers_table.php
│   │   ├── 2024_05_19_000002_create_services_table.php
│   │   ├── 2024_05_19_000003_create_appointments_table.php
│   │   ├── 2024_05_19_000004_create_invoices_table.php
│   │   └── 2024_05_19_000005_create_invoice_items_table.php
│   └── seeders/
│       ├── DatabaseSeeder.php
│       ├── RolesAndPermissionsSeeder.php
│       └── UserSeeder.php
│
├── resources/
│   └── views/                       # Blade templates (TBD)
│       ├── layouts/
│       ├── shop/
│       └── pages/
│
├── routes/
│   ├── web.php                      # Web routes (TBD)
│   └── api.php                      # API routes (TBD)
│
├── config/
│   ├── app.php                      # App configuration
│   ├── database.php                 # DB config (TBD)
│   └── auth.php                     # Auth config (TBD)
│
├── composer.json                    # PHP dependencies
├── .env.example                     # Environment template
├── .gitignore                       # Git ignore patterns
└── README.md                        # This file
```

---

## 👥 User Roles & Permissions

### Super Admin
- Full system access
- Manage users and roles
- View all reports
- Manage all customers, invoices, appointments

### Admin
- Manage customers
- Manage appointments
- Manage invoices
- Create and edit services
- Cannot: manage users or roles

---

## 🚀 Getting Started

### Prerequisites
- PHP 8.2+
- Composer
- MySQL 8.0+ or PostgreSQL 12+
- Laravel 11

### Installation

```bash
# 1. Clone repository
git clone https://github.com/yourusername/toxaway-laravel.git
cd toxaway-laravel

# 2. Install dependencies
composer install

# 3. Setup environment
cp .env.example .env
php artisan key:generate

# 4. Configure database in .env
# DB_DATABASE=toxaway
# DB_USERNAME=root
# DB_PASSWORD=

# 5. Run migrations and seeders
php artisan migrate
php artisan db:seed

# 6. Create super admin user (if not using seeders)
php artisan tinker
>>> $user = User::create(['name' => 'Admin', 'email' => 'admin@toxaway.test', 'password' => bcrypt('password123')]);
>>> $user->assignRole('super_admin');

# 7. Start development server
php artisan serve
```

### Access Points
- **Public Site:** http://localhost:8000
- **Admin Panel:** http://localhost:8000/admin
- **Login:** admin@toxaway.test / password123

---

## 📊 Core Features

### Phase 1: Admin Foundation (Current)
- ✅ Database schema and models
- ✅ User authentication
- ✅ Role-based access control
- ⏳ Admin CRUD interfaces (Filament)
- ⏳ Dashboard & reports

### Phase 2: Public Marketing Site
- Story/heritage pages
- Craftsmanship showcase
- Sizing & care guides
- Contact form

### Phase 3: Ecommerce Catalog
- Product catalog with categories
- Product detail pages
- Shopping cart
- Checkout process
- Order confirmation emails

### Phase 4: Custom Jacket Lead Capture
- Custom build form
- Style/color/patch selection
- Size fitting guide
- Quote request submission
- Admin review workflow
- Lead-to-order conversion

---

## 🛠️ Development Workflow

### Adding New Features

1. **Create Migration** (database schema)
   ```bash
   php artisan make:migration create_feature_table
   ```

2. **Create Model** (business logic)
   ```bash
   php artisan make:model Feature
   ```

3. **Create Filament Resource** (admin interface)
   ```bash
   php artisan make:filament-resource Feature --generate
   ```

4. **Create Controller** (route logic)
   ```bash
   php artisan make:controller FeatureController
   ```

5. **Create Views** (templates)
   ```bash
   php artisan make:view feature.index
   ```

### Running Commands

```bash
# Database
php artisan migrate              # Run migrations
php artisan migrate:rollback     # Rollback last migration
php artisan db:seed              # Run seeders

# Development
php artisan serve                # Start dev server
php artisan tinker               # Interactive shell
php artisan test                 # Run tests

# Optimization
php artisan optimize             # Optimize for production
php artisan config:cache         # Cache config
```

---

## 📝 API Endpoints (Planned)

```
GET  /api/customers              # List customers
POST /api/customers              # Create customer
GET  /api/customers/{id}         # Get customer
PUT  /api/customers/{id}         # Update customer
DELETE /api/customers/{id}       # Delete customer

GET  /api/invoices               # List invoices
POST /api/invoices               # Create invoice
GET  /api/invoices/{id}          # Get invoice
PUT  /api/invoices/{id}          # Update invoice

GET  /api/appointments           # List appointments
POST /api/appointments           # Create appointment
PUT  /api/appointments/{id}      # Update appointment status
```

---

## 🔐 Authentication & Security

- Passwords hashed with bcrypt
- CSRF protection on all forms
- SQL injection protection via Eloquent ORM
- XSS prevention via Blade templating
- Rate limiting on login attempts

---

## 📚 Documentation

- [Project Plan](PROJECT_PLAN.md) — Detailed feature roadmap
- [Architecture](ARCHITECTURE.md) — Deep dive into design decisions
- [Setup Guide](SETUP.md) — Step-by-step installation
- [Audit Report](AUDIT_REPORT.md) — Project completeness checklist

---

## 🤝 Contributing

1. Create a feature branch: `git checkout -b feature/your-feature`
2. Commit changes: `git commit -m "Add your feature"`
3. Push to branch: `git push origin feature/your-feature`
4. Open a Pull Request

---

## 📄 License

MIT License — See LICENSE file for details

---

## 📞 Support

For questions or issues, contact the development team or open an issue on GitHub.

---

**Last Updated:** May 19, 2026  
**Current Version:** 1.0.0-alpha  
**Status:** Foundation Complete - Ready for Admin Development
