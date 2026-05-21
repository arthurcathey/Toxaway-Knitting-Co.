# Toxaway Knitting Company - Project Plan & Roadmap

**Project Name:** Toxaway Laravel Admin & Ecommerce Platform  
**Start Date:** May 19, 2026  
**Target Launch:** Q3 2026

---

## 📌 Executive Summary

This document outlines the phased development approach for transforming Toxaway Knitting Company's static website into a dynamic Laravel-based platform with admin capabilities and ecommerce functionality.

### Key Objectives
1. ✅ **Phase 1:** Build foundation with database, models, and admin authentication
2. ⏳ **Phase 2:** Implement admin dashboard for customer/order management
3. ⏳ **Phase 3:** Launch public ecommerce for standard products
4. ⏳ **Phase 4:** Launch custom jacket lead-capture workflow

### Success Metrics
- Admin can manage 100+ customers without performance issues
- Ecommerce checkout completes in <2 minutes
- Custom jacket lead capture shows >80% quote conversion
- System uptime: 99.5%

---

## 🎯 Phase 1: Foundation (CURRENT - May 2026)

### Status: ✅ 80% Complete

### Objectives
- [x] Design complete database schema
- [x] Create all core Eloquent models
- [x] Build migration files for 5 tables
- [x] Set up authentication & roles system
- [ ] Deploy to staging environment
- [ ] Create comprehensive documentation

### Deliverables

#### Database & Models ✅
- [x] Customers table + model
- [x] Services table + model
- [x] Appointments table + model
- [x] Invoices table + model
- [x] InvoiceItems table + model
- [x] Users table (schema TBD)

#### Authentication & Authorization ✅
- [x] User model with authentication
- [x] Roles: super_admin, admin
- [x] Permission structure designed
- [x] Seeder for test users

#### Documentation ✅
- [x] README.md with architecture
- [x] Database schema diagrams
- [x] API endpoint specs (draft)
- [x] Setup instructions

### Remaining Tasks
- [ ] Filament admin panel installation
- [ ] Create first admin resources (Filament)
- [ ] Create admin authentication UI
- [ ] Set up email notifications
- [ ] Deploy to staging

### Timeline
- **Duration:** 2 weeks
- **Team:** 1-2 developers
- **Dependencies:** PHP 8.2, Laravel 11, Composer packages

### Budget Estimate
- Development: 40-60 hours
- Infrastructure: Staging server (~$10-20/month)
- Third-party services: None yet

---

## 📊 Phase 2: Admin Dashboard & CRUD (June 2026)

### Objectives
- [ ] Build Filament admin panel
- [ ] Create CRUD interfaces for all entities
- [ ] Implement appointment scheduling calendar
- [ ] Add invoice generation & management
- [ ] Create admin-level reporting dashboards
- [ ] Set up email notifications

### Key Features

#### Customer Management
- [ ] List/search customers
- [ ] Add/edit/delete customer records
- [ ] View customer appointment history
- [ ] View customer invoice history
- [ ] Add/edit customer contact info

#### Appointment Management
- [ ] Calendar view of appointments
- [ ] Change appointment status workflow
- [ ] Link appointments to invoices
- [ ] Send appointment reminders via email
- [ ] Bulk status updates

#### Invoice Management
- [ ] Create invoices manually
- [ ] Auto-generate from appointments
- [ ] Invoice line-item editor
- [ ] Auto-calculate totals, tax, discounts
- [ ] Send invoice via email
- [ ] Mark as paid/void
- [ ] Generate PDF invoices

#### Service Catalog
- [ ] Add/edit/delete services
- [ ] Set pricing and default durations
- [ ] Mark services as active/inactive
- [ ] Add service descriptions

#### Admin Dashboard
- [ ] Revenue overview (current month/year)
- [ ] Pending appointments count
- [ ] Recent invoices
- [ ] Customer growth chart
- [ ] Admin audit logs

### Deliverables
- Filament admin panel configured
- 5 admin resources (Customer, Service, Appointment, Invoice, Dashboard)
- 50+ Blade templates for admin
- 10+ Controller classes
- Email notification system

### Timeline
- **Duration:** 3 weeks
- **Team:** 2 developers
- **Dependencies:** Filament 3, Laravel Breeze, Spatie Permissions

### Budget Estimate
- Development: 80-120 hours
- Testing & QA: 20 hours
- Email service (Mailtrap dev): Free tier

---

## 🛍️ Phase 3: Public Ecommerce Site (July-August 2026)

### Objectives
- [ ] Convert static HTML to Blade templates
- [ ] Build product catalog system
- [ ] Implement shopping cart functionality
- [ ] Create checkout/payment flow
- [ ] Add order confirmation emails
- [ ] Set up Stripe payment processing

### Key Features

#### Marketing Pages
- [ ] Homepage with hero and CTAs
- [ ] Our Story / Heritage page
- [ ] Craftsmanship / Supply Chain page
- [ ] Sizing & Care guide
- [ ] Contact form (CMS-enabled)

#### Product Catalog
- [ ] Category browsing (Sweaters, Riding Wear, etc.)
- [ ] Product detail pages
- [ ] Product images gallery
- [ ] Variant selection (size, color)
- [ ] Inventory tracking
- [ ] Product search & filtering

#### Shopping Cart
- [ ] Add to cart functionality
- [ ] View cart
- [ ] Update quantities
- [ ] Remove items
- [ ] Persistent cart (session-based)

#### Checkout
- [ ] Checkout form (customer info)
- [ ] Shipping address
- [ ] Billing address
- [ ] Stripe payment integration
- [ ] Order confirmation page
- [ ] Order confirmation email

#### Customer Portal (Optional)
- [ ] Order history
- [ ] Order tracking
- [ ] Account management
- [ ] Wishlist

### Deliverables
- 20+ public-facing Blade templates
- Product catalog with 50+ items
- Stripe payment integration
- Shopping cart system
- Order management system
- Email notification templates

### Timeline
- **Duration:** 4-5 weeks
- **Team:** 2-3 developers
- **Dependencies:** Stripe API, frontend framework (Tailwind/Bootstrap)

### Budget Estimate
- Development: 150-200 hours
- Stripe processing fees: 2.9% + $0.30 per transaction
- Payment gateway setup: $0

---

## 👔 Phase 4: Custom Jacket Lead Capture (September 2026)

### Objectives
- [ ] Build custom jacket builder form
- [ ] Implement multi-step lead capture flow
- [ ] Create admin review/quote workflow
- [ ] Send quote requests via email
- [ ] Track lead-to-order conversion

### Key Features

#### Custom Jacket Builder (Public)
- [ ] Step 1: Style selection (silhouette, sleeve type)
- [ ] Step 2: Colors (primary, secondary, trim)
- [ ] Step 3: Patches & embroidery
- [ ] Step 4: Personalization (name, initials)
- [ ] Step 5: Size fitting
- [ ] Step 6: Review & submit
- [ ] Form validation & error handling

#### Quote Request Submission
- [ ] Customer contact info collection
- [ ] Photo uploads for references
- [ ] Special instructions/notes
- [ ] Confirmation email to customer
- [ ] Admin notification email

#### Admin Quote Review Workflow
- [ ] Queue of pending quotes
- [ ] View full quote details
- [ ] Add quote pricing
- [ ] Send quote to customer via email
- [ ] Mark as "quoted" / "accepted" / "declined"
- [ ] Convert accepted quotes to orders
- [ ] Create associated invoice

#### Lead Analytics
- [ ] Quote request volume (chart)
- [ ] Quote conversion rate (%)
- [ ] Average quote value
- [ ] Lead source attribution
- [ ] Funnel metrics

### Deliverables
- Custom builder form (5-6 Blade templates)
- CustomJacketRequest model & migration
- Admin custom jacket resource (Filament)
- Quote PDF template
- Email notification system (4+ templates)
- Lead analytics dashboard

### Timeline
- **Duration:** 3-4 weeks
- **Team:** 2 developers
- **Dependencies:** Form validation, file upload handling

### Budget Estimate
- Development: 100-150 hours
- File storage (AWS S3): ~$5-10/month
- Email service (SendGrid): ~$20/month

---

## 🎨 Design & UX Considerations

### Phase 1-2 (Admin)
- Clean, professional Filament default theme
- Keyboard shortcuts for power users
- Mobile-responsive admin panels
- Dark mode support

### Phase 3-4 (Public)
- Match Toxaway brand identity
- Consistent with existing website design
- Fast load times (<2s initial)
- Mobile-first responsive design
- Accessibility (WCAG 2.1 AA)

---

## 🔐 Security Roadmap

### Phase 1
- [x] Password hashing (bcrypt)
- [x] Role-based access control
- [x] SQL injection prevention
- [x] CSRF protection

### Phase 2
- [ ] Admin 2FA (two-factor authentication)
- [ ] Audit logging for all admin actions
- [ ] Rate limiting on sensitive endpoints
- [ ] Admin IP whitelisting (optional)

### Phase 3
- [ ] PCI DSS compliance for Stripe
- [ ] SSL/TLS for all traffic
- [ ] Input validation on all forms
- [ ] Output encoding for all templates

### Phase 4
- [ ] GDPR compliance for customer data
- [ ] Data encryption for sensitive fields
- [ ] Automated security scanning

---

## 📈 Performance Targets

| Metric | Target | Current |
|--------|--------|---------|
| Page load time | <2s | TBD |
| Database queries per request | <5 | TBD |
| Admin panel response time | <500ms | TBD |
| Uptime | 99.5% | N/A |
| Concurrent users | 100+ | TBD |

---

## 💰 Budget Summary

| Phase | Development | Infrastructure | Third-party | Total |
|-------|-------------|-----------------|------------|-------|
| Phase 1 | $2,000-3,000 | $100 | $0 | $2,100-3,100 |
| Phase 2 | $4,000-6,000 | $100 | $0 | $4,100-6,100 |
| Phase 3 | $7,500-10,000 | $200 | $500 | $8,200-10,700 |
| Phase 4 | $5,000-7,500 | $200 | $300 | $5,500-8,000 |
| **TOTAL** | **$18,500-26,500** | **$600** | **$800** | **$19,900-27,900** |

*Assumes $100/hour developer rate and 2-developer team*

---

## 🚧 Risk Assessment

| Risk | Probability | Impact | Mitigation |
|------|-------------|--------|-----------|
| Scope creep | High | High | Weekly scope reviews, strict requirement docs |
| Payment processing issues | Low | High | Early Stripe integration testing, sandbox env |
| Performance bottlenecks | Medium | Medium | Database indexing, caching strategy, load testing |
| Data loss | Low | Critical | Daily automated backups, disaster recovery plan |
| Security vulnerabilities | Medium | High | Security audits, penetration testing, 2FA |
| Team turnover | Low | Medium | Documentation, code comments, knowledge sharing |

---

## ✅ Success Criteria

### Phase 1 Complete When:
- [x] All 5 database tables created and tested
- [x] All 5 models with relationships functional
- [x] Authentication working (login/logout)
- [x] Role-based access control implemented
- [ ] Project deployed to staging
- [ ] Documentation complete and reviewed

### Phase 2 Complete When:
- [ ] All CRUD operations working for 5 entities
- [ ] Admin dashboard shows KPIs
- [ ] Email notifications sending correctly
- [ ] Admin portal has <500ms response time
- [ ] 90%+ test coverage on models/controllers

### Phase 3 Complete When:
- [ ] Product catalog shows 50+ items
- [ ] Customers can browse and add to cart
- [ ] Stripe integration processing payments
- [ ] Order confirmation emails sending
- [ ] Public site has <2s load time

### Phase 4 Complete When:
- [ ] Custom jacket form working end-to-end
- [ ] Quote requests saved and notifying admin
- [ ] Quote PDF generation working
- [ ] Conversion tracking showing metrics
- [ ] Lead funnel analytics dashboard live

---

## 📅 Overall Timeline

```
May 2026        June 2026        July 2026         Sept 2026
|               |                |                 |
Phase 1 ────────▶ Phase 2 ────────▶ Phase 3 ────────▶ Phase 4
Foundation       Admin Dashboard   Ecommerce        Lead Capture
(2 weeks)        (3 weeks)         (5 weeks)        (4 weeks)

Total Project Duration: ~14 weeks (3.5 months)
```

---

## 👥 Team Structure

- **Project Manager:** 1 (oversight, stakeholder communication)
- **Lead Developer:** 1 (architecture, code review)
- **Developers:** 2-3 (feature implementation)
- **QA/Tester:** 1 (testing, bug reports)
- **UI/UX Designer:** 1 (mockups, visual design) [shared]

---

## 📞 Communication & Feedback

### Weekly Standups
- Mondays 10am: 30-min sync on progress and blockers

### Sprint Reviews
- Every 2 weeks: Demo completed features to stakeholders

### Change Requests
- Submit via GitHub Issues with `[REQUEST]` prefix
- Prioritize by business value + implementation cost

---

## 🔗 Related Documents

- [README.md](README.md) — Project overview & setup
- [ARCHITECTURE.md](ARCHITECTURE.md) — Technical deep dive
- [AUDIT_REPORT.md](AUDIT_REPORT.md) — Project status checklist
- [SETUP.md](SETUP.md) — Installation guide

---

**Document Version:** 1.0  
**Last Updated:** May 19, 2026  
**Status:** Active Development
