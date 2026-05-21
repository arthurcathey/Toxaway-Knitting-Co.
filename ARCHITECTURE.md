# Toxaway Laravel - Architecture & Design Document

**Purpose:** Detailed technical documentation of system design, data flow, and implementation patterns.

---

## 1. System Overview

### High-Level Architecture

```
┌────────────────────────────────────────────────────────────────┐
│                        CLIENT LAYER                             │
├─────────────────────────┬─────────────────────────┬────────────┤
│   Public Website        │   Admin Dashboard       │   Mobile   │
│   (Blade + Tailwind)    │   (Filament Panel)      │   App      │
└─────────────────────────┴─────────────────────────┴────────────┘
                                    ▲
                                    │ HTTP/HTTPS
                                    ▼
┌────────────────────────────────────────────────────────────────┐
│                    APPLICATION LAYER                            │
├────────────────────────────────────────────────────────────────┤
│  Laravel 11 Application Server                                  │
│  ├─ Routes (web.php, api.php)                                   │
│  ├─ Controllers (Business Logic)                                │
│  ├─ Middleware (Authentication, Authorization)                  │
│  ├─ Services (Domain Logic)                                     │
│  ├─ Models (Eloquent ORM)                                       │
│  └─ Requests/Responses                                          │
└────────────────────────────────────────────────────────────────┘
                                    ▲
                                    │
                                    ▼
┌────────────────────────────────────────────────────────────────┐
│                      DATA LAYER                                 │
├────────────────────────────────────────────────────────────────┤
│  MySQL Database (Primary)      Redis Cache (Secondary)          │
│  ├─ Customers                  ├─ Sessions                      │
│  ├─ Appointments               ├─ Query Cache                   │
│  ├─ Services                   └─ Real-time Data                │
│  ├─ Invoices                                                    │
│  └─ InvoiceItems                                                │
└────────────────────────────────────────────────────────────────┘
```

---

## 2. Database Schema Details

### 2.1 Customers Table

```sql
CREATE TABLE customers (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NULLABLE,
    phone VARCHAR(20) NULLABLE,
    notes TEXT NULLABLE,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    
    INDEXES: (email), (created_at)
);
```

**Purpose:** Core customer record for both direct sales and custom inquiries  
**Relationships:** 1 customer → many appointments, many invoices  
**Considerations:**
- Email unique but nullable (for anonymous custom jacket inquiries)
- Phone can be used for SMS notifications (future)
- Notes field for internal staff comments

### 2.2 Services Table

```sql
CREATE TABLE services (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    default_price DECIMAL(10, 2) NULLABLE,
    default_duration_minutes INT NULLABLE,
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    
    INDEXES: (is_active, created_at)
);
```

**Purpose:** Product/service catalog (sweaters, riding wear, custom consultations)  
**Examples:**
- "Wool Sweater - Heavyweight" (default_price: 89.99)
- "Riding Sweater - Merino" (default_price: 129.99)
- "Custom Jacket Consultation" (default_price: NULL, default_duration: 60)

**Considerations:**
- is_active flag for soft deletes / hiding discontinued items
- default_price can be NULL for quote-based services
- default_duration for appointment scheduling

### 2.3 Appointments Table

```sql
CREATE TABLE appointments (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    customer_id BIGINT UNSIGNED NOT NULL (FK → customers),
    service_id BIGINT UNSIGNED NULLABLE (FK → services),
    starts_at DATETIME NOT NULL,
    ends_at DATETIME NULLABLE,
    notes TEXT NULLABLE,
    status ENUM('requested', 'scheduled', 'completed', 'paid', 'canceled') DEFAULT 'requested',
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    
    INDEXES: (customer_id), (service_id), (status), (starts_at)
    FOREIGN KEYS: 
        customer_id → customers(id) ON DELETE CASCADE
        service_id → services(id) ON DELETE SET NULL
);
```

**Purpose:** Orders, consultations, or service bookings  
**Status Workflow:**
1. `requested` — Customer submits form or phones in
2. `scheduled` — Admin confirms availability, appointment locked in
3. `completed` — Service delivered, time slot ended
4. `paid` — Payment received (can jump from completed)
5. `canceled` — Cancelled by customer or staff

**Considerations:**
- service_id nullable for appointments not tied to specific service
- starts_at is required, ends_at computed from default_duration if NULL
- One appointment can produce multiple invoices (e.g., deposit + final)

### 2.4 Invoices Table

```sql
CREATE TABLE invoices (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    customer_id BIGINT UNSIGNED NOT NULL (FK → customers),
    appointment_id BIGINT UNSIGNED NULLABLE (FK → appointments),
    invoice_number VARCHAR(50) UNIQUE NOT NULL,
    status ENUM('draft', 'sent', 'paid', 'void') DEFAULT 'draft',
    issued_at DATE NULLABLE,
    due_at DATE NULLABLE,
    subtotal DECIMAL(10, 2) DEFAULT 0,
    tax_total DECIMAL(10, 2) DEFAULT 0,
    total DECIMAL(10, 2) DEFAULT 0,
    notes TEXT NULLABLE,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    
    INDEXES: (customer_id), (appointment_id), (status), (issued_at)
    FOREIGN KEYS:
        customer_id → customers(id) ON DELETE CASCADE
        appointment_id → appointments(id) ON DELETE SET NULL
);
```

**Purpose:** Billing document, can be:
- Auto-generated from appointment
- Created manually for consultation/quote
- Payment record

**invoice_number Format:** `TOX-2024-001`, `TOX-2024-002` (auto-incrementing)

**Status Meanings:**
- `draft` — Created but not sent to customer
- `sent` — Email sent to customer, awaiting payment
- `paid` — Payment received and verified
- `void` — Cancelled (cannot be deleted due to audit trail)

**Calculations:**
- `total = subtotal + tax_total` (computed before save)
- Auditing: never delete, only void

### 2.5 InvoiceItems Table

```sql
CREATE TABLE invoice_items (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    invoice_id BIGINT UNSIGNED NOT NULL (FK → invoices),
    service_id BIGINT UNSIGNED NULLABLE (FK → services),
    description VARCHAR(255) NOT NULL,
    quantity DECIMAL(10, 2) DEFAULT 1,
    unit_price DECIMAL(10, 2) NOT NULL,
    line_total DECIMAL(10, 2) NOT NULL,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    
    INDEXES: (invoice_id), (service_id)
    FOREIGN KEYS:
        invoice_id → invoices(id) ON DELETE CASCADE
        service_id → services(id) ON DELETE SET NULL
);
```

**Purpose:** Line items on an invoice (what was sold/delivered)

**Example:**
```
Invoice #001:
  Item 1: Wool Sweater (qty: 2, unit: $89.99, total: $179.98)
  Item 2: Shipping (qty: 1, unit: $15.00, total: $15.00)
  Subtotal: $194.98
  Tax: $15.60
  Total: $210.58
```

---

## 3. Eloquent Models & Relationships

### 3.1 Customer Model

```php
class Customer extends Model {
    protected $fillable = ['name', 'email', 'phone', 'notes'];
    
    public function appointments() {
        return $this->hasMany(Appointment::class);
    }
    
    public function invoices() {
        return $this->hasMany(Invoice::class);
    }
    
    // Computed properties
    public function getTotalSpentAttribute() {
        return $this->invoices()->where('status', 'paid')->sum('total');
    }
    
    public function getOpenInvoicesAttribute() {
        return $this->invoices()->whereIn('status', ['draft', 'sent'])->count();
    }
}
```

### 3.2 Service Model

```php
class Service extends Model {
    protected $fillable = ['name', 'default_price', 'default_duration_minutes', 'is_active'];
    protected $casts = ['default_price' => 'decimal:2', 'is_active' => 'boolean'];
    
    public function appointments() {
        return $this->hasMany(Appointment::class);
    }
    
    public function invoiceItems() {
        return $this->hasMany(InvoiceItem::class);
    }
    
    public function scopeActive($query) {
        return $query->where('is_active', true);
    }
}
```

### 3.3 Appointment Model

```php
class Appointment extends Model {
    protected $fillable = ['customer_id', 'service_id', 'starts_at', 'ends_at', 'notes', 'status'];
    protected $casts = ['starts_at' => 'datetime', 'ends_at' => 'datetime'];
    
    public function customer() {
        return $this->belongsTo(Customer::class);
    }
    
    public function service() {
        return $this->belongsTo(Service::class);
    }
    
    public function invoice() {
        return $this->hasOne(Invoice::class);
    }
    
    // Scopes for querying
    public function scopeUpcoming($query) {
        return $query->where('starts_at', '>', now())
                    ->where('status', '!=', 'canceled');
    }
    
    public function scopeOverdue($query) {
        return $query->where('status', 'requested')
                    ->where('starts_at', '<', now());
    }
}
```

### 3.4 Invoice Model

```php
class Invoice extends Model {
    protected $fillable = ['customer_id', 'appointment_id', 'invoice_number', 'status', 
                          'issued_at', 'due_at', 'subtotal', 'tax_total', 'total', 'notes'];
    protected $casts = ['issued_at' => 'date', 'due_at' => 'date', 
                        'subtotal' => 'decimal:2', 'tax_total' => 'decimal:2', 'total' => 'decimal:2'];
    
    public function customer() {
        return $this->belongsTo(Customer::class);
    }
    
    public function appointment() {
        return $this->belongsTo(Appointment::class);
    }
    
    public function items() {
        return $this->hasMany(InvoiceItem::class);
    }
    
    // Auto-compute totals
    public static function boot() {
        parent::boot();
        static::saving(function ($model) {
            $model->total = $model->subtotal + $model->tax_total;
        });
    }
    
    public function scopeUnpaid($query) {
        return $query->whereIn('status', ['draft', 'sent']);
    }
    
    public function generateInvoiceNumber() {
        $year = now()->year;
        $count = Invoice::where('invoice_number', 'like', "TOX-$year%")->count();
        return "TOX-$year-" . str_pad($count + 1, 3, '0', STR_PAD_LEFT);
    }
}
```

### 3.5 InvoiceItem Model

```php
class InvoiceItem extends Model {
    protected $fillable = ['invoice_id', 'service_id', 'description', 'quantity', 'unit_price', 'line_total'];
    protected $casts = ['quantity' => 'decimal:2', 'unit_price' => 'decimal:2', 'line_total' => 'decimal:2'];
    
    public function invoice() {
        return $this->belongsTo(Invoice::class);
    }
    
    public function service() {
        return $this->belongsTo(Service::class);
    }
    
    // Auto-compute line total on save
    public static function boot() {
        parent::boot();
        static::saving(function ($model) {
            $model->line_total = $model->quantity * $model->unit_price;
        });
    }
}
```

---

## 4. Authentication & Authorization

### 4.1 User Roles (via Spatie Permission)

```php
// Roles
super_admin   → Full system access
admin         → Limited CRUD access
// (customer role for future public account features)

// Permissions (examples)
manage_users
manage_customers
manage_appointments
manage_invoices
manage_services
view_reports
export_data
```

### 4.2 Middleware Chain

```
Request → Route Middleware
  ├─ Auth (is user logged in?)
  ├─ Verified (is email verified?)
  └─ Role (does user have required role?)
    └─ Permission (does user have required permission?)
```

### 4.3 Policy Example (Appointments)

```php
class AppointmentPolicy {
    public function view(User $user, Appointment $appointment) {
        // Super admin or admin can view any
        return $user->hasRole(['super_admin', 'admin']);
    }
    
    public function update(User $user, Appointment $appointment) {
        // Only super admin can update
        return $user->hasRole('super_admin');
    }
    
    public function delete(User $user, Appointment $appointment) {
        // Cannot delete completed appointments
        if ($appointment->status === 'completed') {
            return false;
        }
        return $user->hasRole('super_admin');
    }
}
```

---

## 5. API Design (Future)

### RESTful Endpoints

```
GET    /api/customers               → List all customers
POST   /api/customers               → Create customer
GET    /api/customers/{id}          → Get single customer
PUT    /api/customers/{id}          → Update customer
DELETE /api/customers/{id}          → Delete customer (soft delete)

GET    /api/invoices                → List invoices (paginated)
POST   /api/invoices                → Create invoice
GET    /api/invoices/{id}           → Get invoice with items
PUT    /api/invoices/{id}           → Update invoice
PUT    /api/invoices/{id}/send      → Send invoice to customer
PUT    /api/invoices/{id}/mark-paid → Mark as paid
DELETE /api/invoices/{id}           → Void invoice
```

### Response Format

```json
{
  "status": "success",
  "data": {
    "id": 1,
    "name": "John Doe",
    "email": "john@example.com"
  },
  "meta": {
    "timestamp": "2024-05-19T10:30:00Z"
  }
}
```

---

## 6. Error Handling

### Exception Strategy

```php
// Custom exceptions
throw new CustomerNotFoundException("Customer not found");
throw new InsufficientPermissionException("You lack permission");
throw new InvalidStatusTransitionException("Cannot go from draft to paid");

// Global exception handler
App\Exceptions\Handler::render() → Returns JSON with error details
```

### HTTP Status Codes

- `200 OK` — Success
- `201 Created` — Resource created
- `400 Bad Request` — Invalid input
- `401 Unauthorized` — Not logged in
- `403 Forbidden` — Lacks permission
- `404 Not Found` — Resource doesn't exist
- `422 Unprocessable Entity` — Validation failed
- `500 Internal Server Error` — Unexpected error

---

## 7. Caching Strategy

### Query Caching

```php
// Cache customer's total spent for 1 hour
$total = Cache::remember("customer.{$id}.total_spent", 3600, function() use ($id) {
    return Customer::find($id)->invoices()->where('status', 'paid')->sum('total');
});
```

### Session Storage

```php
// Shopping cart (Phase 3)
Session::put('cart', [
    ['service_id' => 1, 'quantity' => 2],
    ['service_id' => 3, 'quantity' => 1],
]);
```

---

## 8. File Structure & Naming Conventions

### Directory Organization

```
app/
├── Filament/Resources/        # Admin panel resources
│   ├── CustomerResource.php
│   └── InvoiceResource.php
├── Http/Controllers/          # Request handlers
│   ├── Admin/
│   ├── Api/
│   └── Web/
├── Http/Requests/             # Form validation
│   ├── StoreCustomerRequest.php
│   └── UpdateInvoiceRequest.php
├── Models/                    # Eloquent models
├── Services/                  # Business logic
├── Notifications/             # Email notifications
└── Exceptions/                # Custom exceptions
```

### Naming Conventions

- **Models:** Singular, PascalCase (Customer, Invoice)
- **Controllers:** PascalCase + "Controller" (CustomerController)
- **Migrations:** Descriptive snake_case (create_customers_table)
- **Routes:** kebab-case URLs (/api/customers, /custom-jacket)
- **Methods:** camelCase (getInvoiceTotal(), createFromAppointment())

---

## 9. Performance Considerations

### Database Optimization

```php
// ❌ N+1 Query Problem
$customers = Customer::all();
foreach ($customers as $customer) {
    echo $customer->invoices->count(); // Query for each!
}

// ✅ Solution: Eager Load
$customers = Customer::with('invoices')->get();
```

### Indexing Strategy

- Primary keys (id)
- Foreign keys (customer_id, service_id)
- Frequently queried columns (status, created_at, email)
- Composite indexes (customer_id + status)

### Query Limits

- Paginate large result sets: `->paginate(15)`
- Use `select()` to limit columns: `->select(['id', 'name'])`
- Add query timeout: default 30 seconds

---

## 10. Security Best Practices

### Input Validation

```php
// Form request validation
public function rules() {
    return [
        'email' => 'required|email|unique:customers',
        'name' => 'required|string|max:255',
        'phone' => 'nullable|regex:/^\+?[0-9\s-()]+$/',
    ];
}
```

### SQL Injection Prevention

- Always use Eloquent ORM (never raw queries)
- Use parameterized queries: `where('email', '=', $email)`
- Never concatenate user input into queries

### XSS Prevention

- All Blade output: `{{ $variable }}` (auto-escapes)
- Raw HTML only: `{!! $variable !!}` (with sanitization)

### CSRF Protection

- All POST forms include: `@csrf`
- Token verified by middleware

---

## 11. Testing Strategy

### Unit Tests
```php
// Test model logic
public function test_invoice_total_calculation() {
    $invoice = Invoice::factory()->create();
    $this->assertEquals($invoice->subtotal + $invoice->tax_total, $invoice->total);
}
```

### Feature Tests
```php
// Test full workflows
public function test_create_appointment_and_invoice() {
    $customer = Customer::factory()->create();
    // ...create appointment
    // ...verify invoice created
}
```

### Browser Tests (Future)
```php
// Simulate user actions
public function test_customer_checkout_flow() {
    // Login, add to cart, checkout, payment
}
```

---

## Conclusion

This architecture provides a scalable, maintainable foundation for Toxaway's business operations. The modular design allows for incremental feature additions without major refactoring.

---

**Architecture Version:** 1.0  
**Last Updated:** May 19, 2026  
**Next Review:** August 2026
