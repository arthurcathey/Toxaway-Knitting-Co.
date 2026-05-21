# Toxaway Knitting Co. - REST API Documentation

## Base URL
```
http://localhost:8000/api
```

## Authentication
- **Products API**: Public (no authentication required)
- **Cart API**: Public (session-based, no authentication required)
- **Custom Jacket API**: Requires Laravel Sanctum token authentication
- **Admin API**: Requires admin role (available in separate controller)

---

## Public Endpoints

### Products API

#### List All Products
```
GET /api/products
```

**Query Parameters:**
- `search` (string) - Search by product name or description
- `in_stock` (boolean) - Filter by stock status (1=in stock, 0=out of stock)
- `sort` (string) - Sort field: `name`, `price`, `created_at`, `quantity_available`
- `order` (string) - Sort order: `asc` or `desc` (default: desc)
- `per_page` (integer) - Results per page (max 100, default: 15)

**Example Requests:**
```bash
# Get all products
curl http://localhost:8000/api/products

# Search for varsity jackets in stock, sorted by price
curl "http://localhost:8000/api/products?search=varsity&in_stock=1&sort=price&order=asc"

# Get products with custom pagination
curl "http://localhost:8000/api/products?per_page=25&sort=created_at"
```

**Success Response (200):**
```json
{
  "data": [
    {
      "id": 1,
      "name": "Classic Varsity Jacket",
      "description": "Traditional wool blend jacket...",
      "price": 89.99,
      "quantity_available": 15,
      "in_stock": true,
      "image_url": "http://localhost:8000/storage/products/jacket.jpg",
      "created_at": "2026-05-21T10:00:00Z",
      "updated_at": "2026-05-21T10:00:00Z"
    }
  ],
  "links": {
    "first": "http://localhost:8000/api/products?page=1",
    "last": "http://localhost:8000/api/products?page=2",
    "prev": null,
    "next": "http://localhost:8000/api/products?page=2"
  },
  "meta": {
    "current_page": 1,
    "from": 1,
    "last_page": 2,
    "per_page": 15,
    "to": 15,
    "total": 27
  }
}
```

---

#### Get Single Product
```
GET /api/products/{id}
```

**Example Request:**
```bash
curl http://localhost:8000/api/products/1
```

**Success Response (200):**
```json
{
  "data": {
    "id": 1,
    "name": "Classic Varsity Jacket",
    "description": "Traditional wool blend jacket...",
    "price": 89.99,
    "quantity_available": 15,
    "in_stock": true,
    "image_url": "http://localhost:8000/storage/products/jacket.jpg",
    "created_at": "2026-05-21T10:00:00Z",
    "updated_at": "2026-05-21T10:00:00Z"
  }
}
```

**Error Response (404):**
```json
{
  "message": "No query results for model [App\\Models\\Product]"
}
```

---

### Cart API

#### Get Current Cart
```
GET /api/cart
```

**Example Request:**
```bash
curl http://localhost:8000/api/cart
```

**Success Response (200):**
```json
{
  "items": [
    {
      "product_id": 1,
      "name": "Classic Varsity Jacket",
      "price": 89.99,
      "quantity": 2,
      "subtotal": 179.98
    }
  ],
  "item_count": 1,
  "total_quantity": 2,
  "total_price": 179.98
}
```

**Empty Cart Response (200):**
```json
{
  "items": [],
  "item_count": 0,
  "total_quantity": 0,
  "total_price": 0
}
```

---

#### Add Product to Cart
```
POST /api/cart/add
```

**Request Body:**
```json
{
  "product_id": 1,
  "quantity": 2
}
```

**Example Request:**
```bash
curl -X POST http://localhost:8000/api/cart/add \
  -H "Content-Type: application/json" \
  -d '{"product_id": 1, "quantity": 2}'
```

**Success Response (201):**
```json
{
  "message": "Product added to cart",
  "product": "Classic Varsity Jacket",
  "quantity": 2
}
```

**Validation Error (422):**
```json
{
  "message": "The product id field is required.",
  "errors": {
    "product_id": ["The product id field is required."]
  }
}
```

**Insufficient Stock (422):**
```json
{
  "message": "Insufficient stock available",
  "available": 5
}
```

---

#### Update Cart Item Quantity
```
PUT /api/cart/{product_id}/update
```

**Request Body:**
```json
{
  "quantity": 3
}
```

**Example Request:**
```bash
curl -X PUT http://localhost:8000/api/cart/1/update \
  -H "Content-Type: application/json" \
  -d '{"quantity": 3}'
```

**Success Response (200):**
```json
{
  "message": "Cart updated",
  "quantity": 3
}
```

**Remove from Cart (quantity = 0):**
```json
{
  "message": "Product removed from cart"
}
```

---

#### Remove Product from Cart
```
DELETE /api/cart/{product_id}/remove
```

**Example Request:**
```bash
curl -X DELETE http://localhost:8000/api/cart/1/remove
```

**Success Response (200):**
```json
{
  "message": "Product removed from cart"
}
```

---

#### Clear Entire Cart
```
POST /api/cart/clear
```

**Example Request:**
```bash
curl -X POST http://localhost:8000/api/cart/clear
```

**Success Response (200):**
```json
{
  "message": "Cart cleared"
}
```

---

## Protected Endpoints (Requires Authentication)

### Custom Jacket Requests API

**Authentication:** Laravel Sanctum token in header
```
Authorization: Bearer {token}
```

---

#### List User's Custom Jacket Requests
```
GET /api/custom-jackets
```

**Example Request:**
```bash
curl -H "Authorization: Bearer your_token_here" \
  http://localhost:8000/api/custom-jackets
```

**Success Response (200):**
```json
{
  "data": [
    {
      "id": 1,
      "user_id": 5,
      "full_name": "John Doe",
      "email": "john@example.com",
      "phone": "555-0100",
      "base_style": "Varsity Jacket",
      "primary_color": "Navy Blue",
      "secondary_color": "Gold",
      "material": "Wool Blend",
      "front_text": "JD",
      "custom_details": "Add my initials on the back",
      "inspiration_image_url": "http://localhost:8000/storage/custom-jackets/jacket_ref.jpg",
      "quoted_price": null,
      "status": "pending",
      "admin_notes": null,
      "quoted_at": null,
      "approved_at": null,
      "created_at": "2026-05-21T14:30:00Z",
      "updated_at": "2026-05-21T14:30:00Z"
    }
  ],
  "links": {
    "first": "http://localhost:8000/api/custom-jackets?page=1",
    "last": "http://localhost:8000/api/custom-jackets?page=1",
    "prev": null,
    "next": null
  },
  "meta": {
    "current_page": 1,
    "from": 1,
    "last_page": 1,
    "per_page": 10,
    "to": 1,
    "total": 1
  }
}
```

---

#### Get Specific Custom Jacket Request
```
GET /api/custom-jackets/{id}
```

**Example Request:**
```bash
curl -H "Authorization: Bearer your_token_here" \
  http://localhost:8000/api/custom-jackets/1
```

**Success Response (200):**
```json
{
  "data": {
    "id": 1,
    "user_id": 5,
    "full_name": "John Doe",
    "email": "john@example.com",
    "phone": "555-0100",
    "base_style": "Varsity Jacket",
    "primary_color": "Navy Blue",
    "secondary_color": "Gold",
    "material": "Wool Blend",
    "front_text": "JD",
    "custom_details": "Add my initials on the back",
    "inspiration_image_url": "http://localhost:8000/storage/custom-jackets/jacket_ref.jpg",
    "quoted_price": null,
    "status": "pending",
    "admin_notes": null,
    "quoted_at": null,
    "approved_at": null,
    "created_at": "2026-05-21T14:30:00Z",
    "updated_at": "2026-05-21T14:30:00Z"
  }
}
```

**Unauthorized (403):**
```json
{
  "message": "Not authorized to view this request."
}
```

---

#### Submit Custom Jacket Request
```
POST /api/custom-jackets
```

**Request Body (multipart/form-data for file upload):**
```json
{
  "full_name": "Jane Smith",
  "email": "jane@example.com",
  "phone": "555-0200",
  "base_style": "Varsity Jacket",
  "primary_color": "Black",
  "secondary_color": "Cream",
  "material": "Wool Blend",
  "front_text": "JS",
  "custom_details": "I want classic styling with modern colors",
  "inspiration_image": "[file]"
}
```

**Validation Rules:**
- `full_name` - required, string, max 255 chars
- `email` - required, valid email, max 255 chars
- `phone` - required, string, max 20 chars
- `base_style` - required, one of: Varsity Jacket, Letterman, Bomber, Windbreaker
- `primary_color` - required, one of: Black, Navy Blue, Forest Green, Burgundy, Cream, Charcoal Gray
- `secondary_color` - required, one of: Black, Navy Blue, Forest Green, Burgundy, Cream, Charcoal Gray
- `material` - required, one of: Wool Blend, Fleece, Cotton, Polyester, Leather
- `front_text` - optional, max 50 chars
- `custom_details` - optional, max 1000 chars
- `inspiration_image` - optional, image file, max 5MB

**Example Request (cURL with file):**
```bash
curl -X POST http://localhost:8000/api/custom-jackets \
  -H "Authorization: Bearer your_token_here" \
  -F "full_name=Jane Smith" \
  -F "email=jane@example.com" \
  -F "phone=555-0200" \
  -F "base_style=Varsity Jacket" \
  -F "primary_color=Black" \
  -F "secondary_color=Cream" \
  -F "material=Wool Blend" \
  -F "front_text=JS" \
  -F "custom_details=Classic styling" \
  -F "inspiration_image=@/path/to/image.jpg"
```

**Success Response (201):**
```json
{
  "message": "Custom jacket request submitted successfully",
  "data": {
    "id": 2,
    "user_id": 5,
    "full_name": "Jane Smith",
    "email": "jane@example.com",
    "phone": "555-0200",
    "base_style": "Varsity Jacket",
    "primary_color": "Black",
    "secondary_color": "Cream",
    "material": "Wool Blend",
    "front_text": "JS",
    "custom_details": "Classic styling",
    "inspiration_image_url": "http://localhost:8000/storage/custom-jackets/1716282600_abc123def.jpg",
    "quoted_price": null,
    "status": "pending",
    "admin_notes": null,
    "quoted_at": null,
    "approved_at": null,
    "created_at": "2026-05-21T15:30:00Z",
    "updated_at": "2026-05-21T15:30:00Z"
  }
}
```

**Validation Error (422):**
```json
{
  "message": "The given data was invalid.",
  "errors": {
    "email": ["The email must be a valid email address."],
    "base_style": ["The base style must be one of: Varsity Jacket, Letterman, Bomber, Windbreaker."]
  }
}
```

---

## Rate Limiting

All endpoints are rate limited to prevent abuse:

- **Public endpoints** (products, cart): 60 requests per minute
- **Protected endpoints** (custom jackets): 120 requests per minute
- **Create/POST custom jackets**: 5 requests per minute (strict to prevent spam)

**Rate Limit Response (429):**
```json
{
  "message": "Too many requests. Please try again later."
}
```

Response headers include:
- `RateLimit-Limit`: Maximum requests allowed
- `RateLimit-Remaining`: Requests remaining
- `RateLimit-Reset`: Unix timestamp when limit resets

---

## Error Responses

### 400 Bad Request
```json
{
  "message": "Invalid request"
}
```

### 401 Unauthorized
```json
{
  "message": "Unauthenticated"
}
```

### 403 Forbidden
```json
{
  "message": "Not authorized"
}
```

### 404 Not Found
```json
{
  "message": "Resource not found"
}
```

### 422 Unprocessable Entity (Validation Error)
```json
{
  "message": "The given data was invalid.",
  "errors": {
    "field_name": ["Error message"]
  }
}
```

### 429 Too Many Requests
```json
{
  "message": "Too many requests"
}
```

### 500 Internal Server Error
```json
{
  "message": "Internal server error"
}
```

---

## Testing Examples

### JavaScript/Fetch API

**Get Products:**
```javascript
fetch('http://localhost:8000/api/products?in_stock=1&sort=price')
  .then(res => res.json())
  .then(data => console.log(data));
```

**Add to Cart:**
```javascript
fetch('http://localhost:8000/api/cart/add', {
  method: 'POST',
  headers: { 'Content-Type': 'application/json' },
  body: JSON.stringify({ product_id: 1, quantity: 2 })
})
  .then(res => res.json())
  .then(data => console.log(data));
```

**Submit Custom Jacket (with auth):**
```javascript
const formData = new FormData();
formData.append('full_name', 'John Doe');
formData.append('email', 'john@example.com');
formData.append('phone', '555-0100');
formData.append('base_style', 'Varsity Jacket');
formData.append('primary_color', 'Navy Blue');
formData.append('secondary_color', 'Gold');
formData.append('material', 'Wool Blend');
formData.append('front_text', 'JD');
formData.append('custom_details', 'Add my initials');

fetch('http://localhost:8000/api/custom-jackets', {
  method: 'POST',
  headers: { 'Authorization': 'Bearer your_token_here' },
  body: formData
})
  .then(res => res.json())
  .then(data => console.log(data));
```

---

## Integration Tips

1. **Session/CSRF**: Cart API uses Laravel sessions. Include `withCredentials: true` in fetch for cookie handling.
2. **CORS**: Configure CORS in `config/cors.php` if accessing from a different domain.
3. **Pagination**: Use `page` query param to navigate results: `/api/products?page=2`.
4. **File Uploads**: Use `multipart/form-data` and FormData for image uploads.
5. **Authentication**: Use Laravel Sanctum tokens for protected endpoints.

---

**API Version:** 1.0.0  
**Last Updated:** May 21, 2026
