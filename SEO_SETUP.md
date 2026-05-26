# SEO & Meta Tags Implementation Guide

## Overview

The Toxaway Knitting Co. application now includes comprehensive SEO and social media optimization with:

- **Dynamic Meta Tags** - Page-specific titles, descriptions, and keywords
- **Open Graph Tags** - Optimized for social media sharing (Facebook, LinkedIn, etc.)
- **Twitter Card Tags** - Enhanced Twitter sharing with rich previews
- **JSON-LD Structured Data** - Schema.org markup for search engines
- **XML Sitemap** - Auto-generated sitemap for search engines
- **Robots.txt** - Proper crawling instructions
- **Canonical Tags** - Prevent duplicate content issues

## File Structure

```
app/
  Services/
    SeoService.php              # Core SEO service for managing meta tags
  Http/
    Middleware/
      InitializeSeo.php         # Middleware to initialize SEO service for all views
    Controllers/
      ProductController.php     # Updated with SEO data for products
      SitemapController.php     # Generates XML sitemap

resources/views/
  sitemap/
    index.blade.php             # XML sitemap template
  layouts/
    app.blade.php               # Updated layout with SEO meta tags

public/
  robots.txt                    # Updated with proper directives

routes/
  web.php                       # Routes with SEO data (home, heritage, craftsmanship, contact, sitemap)
```

## How It Works

### 1. SEO Service (`SeoService.php`)

The core service provides methods to set and retrieve SEO data:

```php
$seo = new SeoService()
  ->setTitle('Product Name | Toxaway Knitting Co.')
  ->setDescription('Product description...')
  ->setUrl(route('product.show', $product->slug))
  ->setImage(asset('images/products/product.png'))
  ->setKeywords(['keyword1', 'keyword2', 'keyword3'])
  ->setType('product')
  ->setStructuredData(SeoService::productSchema($product));
```

### 2. Middleware (`InitializeSeo.php`)

Automatically initializes a default SEO service instance for all views. Controllers can override with specific data using `view()->share('seo', $customSeo)`.

### 3. Layout (`app.blade.php`)

The layout renders:
- Meta tags (description, keywords, theme color)
- Open Graph tags (social sharing)
- Twitter Card tags (Twitter sharing)
- Canonical tag (for duplicate content prevention)
- JSON-LD structured data

### 4. Routes

Each route sets appropriate SEO data:

```php
Route::get('/', function () {
  view()->share('seo', (new SeoService())
    ->setTitle('...')
    ->setDescription('...')
    ->setUrl(...)
    ->setKeywords([...])
    ->setStructuredData(...)
  );
  return view('home');
})->name('home');
```

## SEO Data Per Page

### Homepage
- **Title**: Toxaway Knitting Co. | Handmade American Knitwear
- **Type**: website
- **Structured Data**: Organization schema

### Shop Page
- **Title**: Shop | Toxaway Knitting Co.
- **Type**: website
- **Keywords**: knitwear, handmade sweaters, custom jackets, etc.

### Product Pages
- **Title**: Product Name | Toxaway Knitting Co.
- **Type**: product
- **Structured Data**: Product schema with price, availability, brand
- **Dynamic Image**: Product image for social sharing

### Heritage Page
- **Title**: Our Heritage | Toxaway Knitting Co.
- **Description**: Brand story and commitment
- **Type**: website

### Craftsmanship Page
- **Title**: Our Craftsmanship | Toxaway Knitting Co.
- **Description**: Production approach and materials
- **Type**: website

### Contact Page
- **Title**: Contact Us | Toxaway Knitting Co.
- **Description**: Support and inquiry information
- **Type**: website

### Custom Jacket Page
- **Title**: Custom Jacket Builder | Toxaway Knitting Co.
- **Description**: Personalized jacket ordering
- **Type**: website

## XML Sitemap

**Route**: `/sitemap.xml`

Automatically generated with:
- Homepage (priority 1.0)
- All main pages (priority 0.7-0.9)
- All in-stock products with last modified date
- Change frequency indicators (daily, weekly, monthly)

## Robots.txt

Located at `/public/robots.txt`

Directives:
- Allows all search engines to crawl public pages
- Disallows: `/admin/`, `/cart/`, `/checkout/`, `/order/`, `/dashboard/`
- Points to sitemap
- Crawl delay: 1 second

## Structured Data (JSON-LD)

### Organization Schema

Every page includes organization information:
```json
{
  "@context": "https://schema.org",
  "@type": "Organization",
  "name": "Toxaway Knitting Co.",
  "url": "https://toxawayknitting.com",
  "logo": "...",
  "address": {...},
  "contactPoint": {...},
  "sameAs": ["facebook", "instagram", "twitter"]
}
```

### Product Schema

Product pages include:
```json
{
  "@context": "https://schema.org/",
  "@type": "Product",
  "name": "Product Name",
  "description": "...",
  "image": "...",
  "price": "99.99",
  "priceCurrency": "USD",
  "availability": "InStock",
  "brand": {...}
}
```

## Open Graph Tags

Generates tags for all social media platforms:

```html
<meta property="og:type" content="website">
<meta property="og:title" content="Page Title">
<meta property="og:description" content="Page Description">
<meta property="og:url" content="https://...">
<meta property="og:image" content="https://...">
<meta property="og:site_name" content="Toxaway Knitting Co.">
```

## Twitter Card Tags

Optimizes Twitter sharing:

```html
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="Page Title">
<meta name="twitter:description" content="Description">
<meta name="twitter:image" content="Image URL">
```

## Customizing SEO for New Pages

When adding a new page or view:

1. **Set SEO data in route**:
```php
Route::get('/new-page', function () {
  view()->share('seo', (new SeoService())
    ->setTitle('New Page | Toxaway Knitting Co.')
    ->setDescription('Page description...')
    ->setUrl(route('new-page'))
    ->setKeywords(['keyword1', 'keyword2'])
  );
  return view('new-page');
})->name('new-page');
```

2. **Or in controller**:
```php
public function index() {
  view()->share('seo', (new SeoService())
    ->setTitle('...')
    ->setDescription('...')
    // ... more settings
  );
  return view('index');
}
```

## Testing SEO

### Local Testing

1. **View Meta Tags**: Right-click → Inspect → head section
2. **Check Sitemap**: Visit `http://localhost:8000/sitemap.xml`
3. **Check Robots.txt**: Visit `http://localhost:8000/robots.txt`
4. **Social Preview**: Use [Meta Tag Checker](https://www.metatags.io/) tool

### Production Verification

1. **Google Search Console**:
   - Submit sitemap URL
   - Check indexing status
   - Monitor search appearance

2. **Facebook Sharing Debugger**:
   - Test Open Graph tags
   - Preview how posts appear

3. **Twitter Card Validator**:
   - Verify Twitter Card tags
   - Preview Twitter appearance

4. **Google Rich Results Test**:
   - Validate structured data
   - Check for rich results eligibility

## Best Practices

1. **Descriptions**: Keep 155-160 characters for optimal display in search results
2. **Keywords**: Use 5-10 relevant keywords per page
3. **Titles**: Include brand name and primary keyword
4. **Images**: Use high-quality images (at least 1200×630px for social)
5. **Canonicals**: Already implemented to prevent duplicates
6. **Schema**: Use appropriate schema types (Product, Organization, etc.)

## Common Issues

### Sitemap not generating
- Ensure products exist in database
- Check file permissions on storage directory
- Verify route is registered in `routes/web.php`

### Meta tags not appearing
- Clear Laravel cache: `php artisan config:cache`
- Verify middleware is registered in `bootstrap/app.php`
- Check view file has proper layout inheritance

### Robots.txt not found
- File is in `public/robots.txt` (web root)
- Update absolute URLs if hosting on subdirectory
- Test with `curl https://domain.com/robots.txt`

## Next Steps

1. Submit sitemap to Google Search Console
2. Add social media handles to organization schema
3. Create additional content for target keywords
4. Monitor search console for issues
5. Optimize images for web performance
6. Add breadcrumb schema for better navigation in search results

## Resources

- [Schema.org Documentation](https://schema.org/)
- [Google Search Central](https://developers.google.com/search)
- [Open Graph Protocol](https://ogp.me/)
- [Twitter Card Documentation](https://developer.twitter.com/en/docs/twitter-for-websites/cards/overview/abouts-cards)
