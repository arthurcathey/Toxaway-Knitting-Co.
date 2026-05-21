# Toxaway Knitting Company - Laravel Ecommerce & Custom Orders Platform

A Laravel 11 web application for Toxaway Knitting Company's ecommerce store, admin dashboard, and custom varsity jacket ordering system.

---

## 📋 Project Overview

**Purpose:** Build a modern web platform for Toxaway Knitting Company combining:
-  **Public Ecommerce** — Browse and purchase standard products (sweaters, riding wear, etc.)
-  **Custom Jacket System** — Submit custom varsity jacket requests with design specifications
-  **Admin Dashboard** — Manage products, process custom orders, and track quotes
-  **Security & Performance** — Rate limiting, input sanitization, security headers, optimized assets

**Technology Stack:**
- Laravel 11.53.1 (PHP framework)
- Tailwind CSS v3 (Utility-first styling)
- Vite v6.4.2 (Asset bundling with hot reload)
- SQLite (Database)
- Custom Authentication (manual implementation without Filament)

---

## 🗂️ Architecture

### Database Schema

```
┌──────────────────────────────────────────────────────────┐
│                      USERS                               │
├──────────────────────────────────────────────────────────┤
│ id (PK) | name | email | password | is_admin | timestamps│
└────────────────────────────────────────────────────────┬─┘
                                                         │ 1:M
                                     ┌───────────────────▼──────────────┐
                                     │  CUSTOM_JACKET_REQUESTS          │
                                     ├──────────────────────────────────┤
                                     │ id (PK)                          │
                                     │ user_id (FK, nullable)           │
                                     │ full_name, email, phone          │
                                     │ base_style, primary_color        │
                                     │ secondary_color, material        │
                                     │ front_text, custom_details       │
                                     │ inspiration_image (nullable)     │
                                     │ quoted_price (nullable)          │
                                     │ status (enum)                    │
                                     │ admin_notes (nullable)           │
                                     │ quoted_at, approved_at           │
                                     │ created_at, updated_at           │
                                     └──────────────────────────────────┘

┌──────────────────────────────────────────────────────────┐
│                     PRODUCTS                             │
├──────────────────────────────────────────────────────────┤
│ id (PK) | name | description | price | image            │
│ is_featured | timestamps                                 │
└──────────────────────────────────────────────────────────┘
```

### Core Models

| Model | Purpose | Relationships |
|-------|---------|---------------|
| **User** | Authentication & authorization | hasMany(CustomJacketRequest) |
| **Product** | Standard products catalog | (public browsing) |
| **CustomJacketRequest** | Custom jacket quote requests | belongsTo(User, nullable) |

### Status Workflows

**CustomJacketRequest Status:**
- `pending` — Submitted, awaiting admin review
- `quoted` — Quote generated and sent to customer
- `approved` — Customer approved, ready for production
- `in_production` — Jacket is being made
- `completed` — Finished and shipped
- `cancelled` — Cancelled by customer or admin

---

## 📁 Project Structure

```
toxaway-laravel-fresh/
├── app/
│   ├── Models/
│   │   ├── User.php                           # Authentication & authorization
│   │   ├── Product.php                        # Ecommerce products
│   │   └── CustomJacketRequest.php            # Custom jacket requests
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── AuthController.php             # Login/Register
│   │   │   ├── ProductController.php          # Product listing
│   │   │   ├── CartController.php             # Shopping cart AJAX
│   │   │   ├── CustomJacketController.php     # Custom jacket form & submission
│   │   │   └── Admin/ProductAdminController.php # Product admin CRUD
│   │   ├── Middleware/
│   │   │   ├── IsAdmin.php                    # Admin route protection with audit logging
│   │   │   └── AddSecurityHeaders.php         # Security headers middleware
│   │   └── Requests/                          # Form request validation (TBD)
│   ├── Mail/
│   │   ├── CustomJacketConfirmation.php       # Customer quote confirmation email
│   │   └── CustomJacketQuoteRequested.php     # Admin notification email
│   └── Traits/                                # Reusable logic (TBD)
│
├── database/
│   ├── migrations/
│   │   ├── 0001_01_01_000000_create_users_table.php
│   │   ├── 0001_01_01_000001_create_cache_table.php
│   │   ├── 0001_01_01_000002_create_jobs_table.php
│   │   ├── 2024_03_15_000001_create_products_table.php
│   │   └── 2026_05_21_193748_create_custom_jacket_requests_table.php
│   └── seeders/
│       ├── DatabaseSeeder.php
│       ├── UserSeeder.php
│       └── ProductSeeder.php
│
├── resources/
│   ├── css/
│   │   └── app.css                            # Tailwind CSS entry point
│   ├── js/
│   │   └── app.js                             # JavaScript entry point (scroll-to-top, cart, delete confirmation)
│   └── views/
│       ├── layouts/
│       │   └── app.blade.php                  # Master layout with navigation
│       ├── auth/
│       │   ├── login.blade.php
│       │   └── register.blade.php
│       ├── shop/
│       │   ├── index.blade.php                # Product catalog
│       │   └── show.blade.php                 # Product detail
│       ├── custom-jacket/
│       │   └── builder.blade.php              # Custom jacket order form
│       ├── emails/
│       │   ├── custom-jacket-confirmation.blade.php
│       │   └── custom-jacket-admin-notification.blade.php
│       ├── admin/
│       │   ├── dashboard.blade.php
│       │   └── products/
│       │       ├── index.blade.php
│       │       ├── create.blade.php
│       │       └── edit.blade.php
│       ├── contact.blade.php
│       ├── custom.blade.php
│       ├── story.blade.php
│       └── cart.blade.php
│
├── routes/
│   ├── web.php                                # All web routes
│   └── api.php                                # API routes (cart endpoints)
│
├── config/
│   ├── app.php
│   ├── database.php                           # SQLite configured
│   ├── mail.php
│   └── filesystems.php                        # Public disk for storage
│
├── storage/
│   ├── app/
│   │   └── public/
│   │       ├── products/                      # Product images
│   │       └── custom-jackets/                # Custom jacket reference images
│   └── logs/
│
├── bootstrap/
│   └── app.php                                # Application bootstrap with middleware registration
│
├── public/
│   ├── index.php                              # App entry point
│   ├── css/                                   # Compiled CSS
│   └── js/                                    # Compiled JavaScript
│
├── vite.config.js                             # Vite bundler config
├── tailwind.config.js                         # Tailwind CSS config
├── composer.json                              # PHP dependencies
├── package.json                               # Node.js dependencies
├── .env.example                               # Environment template
├── .gitignore
└── README.md                                  # This file
```

---

##  User Roles & Authorization

### User Types

**Regular User**
- Browse products and shop
- Submit custom jacket requests
- Receive order confirmations and updates
- No admin access

**Admin User**
- All regular user permissions plus:
- Product CRUD (create, edit, delete products)
- View custom jacket requests
- Generate and send quotes
- Update order status
- View all orders and submissions
- Access admin dashboard at `/admin`

### Authentication

- Manual implementation (no Filament)
- Password hashing with `bcrypt`
- Session-based authentication
- `is_admin` boolean flag on users table
- IsAdmin middleware protection with audit logging for unauthorized access

---

##  Getting Started

### Prerequisites
- PHP 8.2+
- Composer
- Node.js 18+
- npm or yarn
- Laravel 11

### Installation

```bash
# 1. Clone repository
git clone https://github.com/yourusername/toxaway-laravel-fresh.git
cd toxaway-laravel-fresh

# 2. Install PHP dependencies
composer install

# 3. Install Node dependencies
npm install

# 4. Setup environment
cp .env.example .env
php artisan key:generate

# 5. Create SQLite database (automatically created in database/ directory)
touch database/database.sqlite

# 6. Run migrations
php artisan migrate

# 7. Seed sample data (optional)
php artisan db:seed

# 8. Create storage symlink for file uploads
php artisan storage:link

# 9. Build assets
npm run build

# 10. Start development servers (in separate terminals)
# Terminal 1 - Vite dev server (for hot reload)
npm run dev

# Terminal 2 - Laravel development server
php artisan serve
```

### Access Points
- **Public Site:** http://localhost:8000
- **Admin Dashboard:** http://localhost:8000/admin
- **Custom Jacket Form:** http://localhost:8000/custom-jacket
- **Shop:** http://localhost:8000/shop

### Demo Account
Default admin account created by seeder:
- **Email:** admin@toxaway.test
- **Password:** password
- **Access:** /admin

Regular user account:
- **Email:** user@toxaway.test
- **Password:** password

---

## 📊 Core Features

### ✅ Completed Features

#### 1. Authentication & Authorization
- User login/register system
- Password hashing with bcrypt
- Session-based authentication
- Admin role verification
- IsAdmin middleware with security audit logging

#### 2. Public Site
- Home page with hero section
- Story/heritage pages (Story, Craft, Contact)
- Responsive navigation with mobile menu
- Scroll-to-top smooth button functionality
- CSRF protection on all forms

#### 3. Ecommerce Store
- Product catalog with search/filtering
- Product detail pages
- Session-based shopping cart with AJAX endpoints
- Add/remove/update cart items via API
- Cart count display in navigation
- Responsive product grid

#### 4. Custom Varsity Jacket System
- **Form Builder Page** (`/custom-jacket`)
  - 8-field order form (contact info, design specs, personalization)
  - Enum dropdown validation (styles, colors, materials)
  - Optional reference image upload (5MB max)
  - Process explanation (6-step guide)
  - Timeline & FAQ sections
  - Real-time form error display
  - Session value preservation on error
  
- **Backend Processing**
  - Form validation with specific enum values
  - Input sanitization (strip HTML tags)
  - Secure file uploads with random filename generation
  - Database entry creation with status tracking
  
- **Email Notifications**
  - Customer confirmation email with order summary
  - Admin notification with full specifications
  - Automatic email routing via Laravel Mail
  
- **Admin Management** (Database fields for admin workflow)
  - quoted_price field for cost estimation
  - admin_notes field for internal notes
  - Status tracking: pending → quoted → approved → in_production → completed/cancelled
  - quoted_at & approved_at timestamps

#### 5. Admin Dashboard
- Product management (CRUD)
- Secure file uploads for product images
- Admin route protection (IsAdmin middleware)
- Custom jacket request viewing
- Unauthorized access audit logging with IP tracking

#### 6. Security & Performance
- **Rate Limiting:**
  - Login: 5 attempts per minute
  - Register: 3 attempts per minute
  
- **Security Headers:**
  - X-Content-Type-Options: nosniff
  - X-Frame-Options: SAMEORIGIN
  - X-XSS-Protection: 1; mode=block
  - Referrer-Policy: strict-origin-when-cross-origin
  - Permissions-Policy: camera/microphone/geolocation disabled
  - Strict-Transport-Security: HSTS enabled
  
- **Input Protection:**
  - CSRF tokens on all forms
  - Input sanitization (strip_tags)
  - Server-side enum validation
  - File type & size validation
  
- **Audit Logging:**
  - Unauthorized access logging with user ID, IP, path, method
  - Email error logging
  
- **Asset Optimization:**
  - Vite bundling with production minification
  - CSS/JS hot reload in development
  - Tailwind CSS utility compilation

###  Recent Improvements
- Moved delete confirmation from inline JavaScript to external event handler
- Refactored controllers for consistent Auth facade usage
- Added scroll-to-top button with smooth animation
- Security header middleware globally registered
- Custom jacket feature fully implemented with email notifications

---

##  Development Workflow

### Common Commands

**Database:**
```bash
php artisan migrate              # Run pending migrations
php artisan migrate:rollback     # Rollback last migration batch
php artisan migrate:fresh        # Drop all tables and re-run migrations
php artisan db:seed              # Run database seeders
php artisan tinker               # Interactive shell for testing
```

**Development:**
```bash
npm run dev                       # Start Vite dev server with hot reload
php artisan serve                # Start Laravel development server (port 8000)
php artisan test                 # Run test suite (when tests are added)
```

**Asset Building:**
```bash
npm run build                     # Build assets for production
npm run dev                       # Build assets with hot reload for development
```

**File Management:**
```bash
php artisan storage:link         # Create symlink for public file storage
php artisan view:clear           # Clear compiled views
php artisan cache:clear          # Clear application cache
php artisan config:cache         # Cache configuration
```

### Adding New Features

1. **Create Migration** (database schema)
   ```bash
   php artisan make:migration create_feature_table
   ```

2. **Create Model** (business logic)
   ```bash
   php artisan make:model Feature -m  # -m flag creates migration too
   ```

3. **Create Controller** (route logic)
   ```bash
   php artisan make:controller FeatureController
   ```

4. **Create Views** (Blade templates)
   ```bash
   mkdir -p resources/views/feature
   # Create .blade.php files manually
   ```

5. **Add Routes** (in routes/web.php)
   ```php
   Route::resource('feature', FeatureController::class);
   ```

### Code Organization Principles

- **Controllers:** Business logic, validation, database interaction
- **Models:** Database relationships, attribute casting, model scopes
- **Views:** User interface, Tailwind CSS styling
- **Middleware:** Request/response filtering (auth, CORS, security headers)
- **Mail Classes:** Email content and configuration
- **Routes:** Clean, RESTful endpoint definitions

### Security Checklist

- [ ] CSRF tokens on all forms (@csrf in Blade)
- [ ] Input validation with specific rules
- [ ] Input sanitization (strip_tags for text)
- [ ] File uploads: type & size validation, random filenames
- [ ] Rate limiting on authentication routes
- [ ] Middleware protection on sensitive routes
- [ ] Security headers globally applied
- [ ] Error logging without exposing sensitive data
- [ ] No hardcoded credentials or secrets

---

##  API Endpoints

### Public Endpoints

```
GET    /                          # Home page
GET    /shop                       # Product catalog
GET    /shop/{id}                  # Product detail
GET    /story                      # Brand story page
GET    /craft                      # Craftsmanship page
GET    /contact                    # Contact page
GET    /custom-jacket              # Custom jacket form (GET - shows form)
POST   /custom-jacket              # Submit custom jacket request
GET    /login                      # Login page
GET    /register                   # Registration page
POST   /login                      # Process login (with throttle:5,1)
POST   /register                   # Process registration (with throttle:3,1)
POST   /logout                     # Logout (requires auth)
```

### Cart API (AJAX)

```
POST   /cart/add                   # Add item to cart
POST   /cart/remove                # Remove item from cart
POST   /cart/update                # Update cart quantity
POST   /cart/clear                 # Clear entire cart
```

### Admin Endpoints (Protected by IsAdmin middleware)

```
GET    /admin                      # Admin dashboard
GET    /admin/products             # Product list
GET    /admin/products/create      # Create product form
POST   /admin/products             # Store new product
GET    /admin/products/{id}/edit   # Edit product form
PUT    /admin/products/{id}        # Update product
DELETE /admin/products/{id}        # Delete product
GET    /admin/custom-jackets       # View all jacket requests (TBD)
GET    /admin/custom-jackets/{id}  # View jacket details (TBD)
PUT    /admin/custom-jackets/{id}  # Update quote/status (TBD)
```

---

##  Authentication & Security

### Authentication
- Custom session-based authentication (no external packages)
- Passwords hashed with bcrypt
- Login/register validation with rate limiting
- Protected admin routes with IsAdmin middleware

### Security Features
- **CSRF Protection:** All forms include @csrf token
- **SQL Injection Prevention:** Eloquent ORM with parameterized queries
- **XSS Prevention:** Blade template escaping with {{ }} syntax
- **Input Sanitization:** strip_tags() on text inputs, enum validation
- **File Upload Security:** 
  - Type validation (images only for custom jacket)
  - Size limits (5MB for reference images, 2MB for product images)
  - Random filename generation to prevent directory traversal
  - Files stored in public disk with proper permissions
- **Rate Limiting:**
  - Login: 5 attempts per minute per IP
  - Register: 3 attempts per minute per IP
- **Security Headers:**
  - X-Content-Type-Options: nosniff (MIME sniffing prevention)
  - X-Frame-Options: SAMEORIGIN (clickjacking prevention)
  - X-XSS-Protection: 1; mode=block (legacy XSS protection)
  - Referrer-Policy: strict-origin-when-cross-origin
  - Permissions-Policy: camera=(), microphone=(), geolocation=()
  - Strict-Transport-Security: HSTS enabled
- **Audit Logging:** Unauthorized access logged with user ID, IP, request path/method
- **Email Error Handling:** Email failures logged but don't break user experience

---

##  Documentation

- [README.md](README.md) — This file with complete project overview
- [Latest Commit History](https://github.com/yourusername/toxaway-laravel-fresh) — View all changes
- Custom Jacket Feature — See `resources/views/custom-jacket/builder.blade.php` for form implementation
- Admin Dashboard — See `resources/views/admin/` directory
- Email Templates — See `resources/views/emails/` directory

### Database Tables

#### users
| Field | Type | Details |
|-------|------|---------|
| id | int | Primary key |
| name | string | User's name |
| email | string unique | Email address |
| password | string | Hashed password |
| is_admin | boolean | Admin flag (default: false) |
| created_at | timestamp | Account creation |
| updated_at | timestamp | Last update |

#### products
| Field | Type | Details |
|-------|------|---------|
| id | int | Primary key |
| name | string | Product name |
| description | text | Long description (sanitized) |
| price | decimal | Product price |
| image | string nullable | Image file path |
| is_featured | boolean | Feature flag for homepage |
| created_at | timestamp | Creation date |
| updated_at | timestamp | Last update |

#### custom_jacket_requests
| Field | Type | Details |
|-------|------|---------|
| id | int | Primary key |
| user_id | int nullable | Associated user |
| full_name | string | Customer name |
| email | string | Contact email |
| phone | string | Phone number |
| base_style | enum | Style choice |
| primary_color | enum | Body color |
| secondary_color | enum | Sleeve color |
| material | enum | Material choice |
| front_text | string | Embroidery text |
| custom_details | text nullable | Additional specs |
| inspiration_image | string nullable | Reference image path |
| quoted_price | decimal nullable | Admin quote |
| status | enum | Order status |
| admin_notes | text nullable | Internal notes |
| quoted_at | timestamp nullable | When quoted |
| approved_at | timestamp nullable | When approved |
| created_at | timestamp | Submission date |
| updated_at | timestamp | Last update |

---

##  Contributing

1. Create a feature branch: `git checkout -b feature/your-feature`
2. Make your changes
3. Test thoroughly
4. Commit with descriptive message: `git commit -m "Add: your feature description"`
5. Push to branch: `git push origin feature/your-feature`
6. Open a Pull Request

### Commit Message Format
```
Type: Brief description

- Detailed bullet point 1
- Detailed bullet point 2

Fixes #123 (if applicable)
```

Types: Add, Fix, Refactor, Improve, Remove, Docs

---

##  License

MIT License — See LICENSE file for details

---

##  Support & Contact

For questions or issues:
1. Check existing GitHub issues
2. Create a new issue with detailed description
3. Contact the development team

---

##  Deployment

### Production Checklist
- [ ] Set `APP_ENV=production` and `APP_DEBUG=false` in .env
- [ ] Set unique `APP_KEY` via `php artisan key:generate`
- [ ] Configure database (MySQL/PostgreSQL recommended for production)
- [ ] Configure mail driver for email notifications
- [ ] Run migrations: `php artisan migrate --force`
- [ ] Optimize application: `php artisan optimize`
- [ ] Cache configuration: `php artisan config:cache`
- [ ] Build assets: `npm run build`
- [ ] Verify storage symlink exists
- [ ] Set proper file permissions on storage/ and bootstrap/cache/
- [ ] Enable HTTPS
- [ ] Configure HSTS headers
- [ ] Set up regular backups

---

**Last Updated:** May 21, 2026  
**Current Version:** 1.0.0  
**Status:** Core Features Complete - Ecommerce & Custom Orders Ready  
**Laravel Version:** 11.53.1  
**Node Version:** 18+
