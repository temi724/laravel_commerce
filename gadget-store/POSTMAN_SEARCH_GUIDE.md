# Postman Testing Guide - Product Search API

## Server Information
- **Base URL**: `http://127.0.0.1:8000/api`
- **Search Endpoint**: `/products/search`
- **Method**: `GET`

## 🔍 Basic Search Tests

### 1. Simple Product Search
**Request:**
```
GET http://127.0.0.1:8000/api/products/search?q=phone
```

**Expected Response:**
```json
{
    "current_page": 1,
    "data": [
        {
            "id": "68b73da1002c6dee007b1f5e",
            "product_name": "iPhone 15 Pro Max(temi-oo)",
            "description": "Latest iPhone model...",
            "price": 1200.00,
            "in_stock": true,
            // ... other fields
        }
    ],
    "first_page_url": "http://127.0.0.1:8000/api/products/search?page=1",
    "from": 1,
    "last_page": 1,
    "last_page_url": "http://127.0.0.1:8000/api/products/search?page=1",
    "links": [...],
    "next_page_url": null,
    "path": "http://127.0.0.1:8000/api/products/search",
    "per_page": 15,
    "prev_page_url": null,
    "to": 2,
    "total": 2,
    "search_query": "phone",
    "filters_applied": {
        "category_id": null,
        "min_price": null,
        "max_price": null,
        "in_stock": null
    }
}
```

### 2. Search with Pagination
**Request:**
```
GET http://127.0.0.1:8000/api/products/search?q=product&per_page=3&page=1
```

### 3. Search with Price Range Filter
**Request:**
```
GET http://127.0.0.1:8000/api/products/search?q=product&min_price=100&max_price=500
```

### 4. Search with Stock Filter (In Stock Only)
**Request:**
```
GET http://127.0.0.1:8000/api/products/search?q=product&in_stock=true
```

### 5. Search with Category Filter
**Request:**
```
GET http://127.0.0.1:8000/api/products/search?q=product&category_id=68b73da1002c6dee007b1f5f
```

### 6. Advanced Search (All Filters)
**Request:**
```
GET http://127.0.0.1:8000/api/products/search?q=phone&category_id=68b73da1002c6dee007b1f5f&min_price=500&max_price=1500&in_stock=true&per_page=5
```

## 🧪 Testing Scenarios in Postman

### Setting Up the Collection

1. **Create a new Collection** called "Laravel Commerce API"

2. **Add Environment Variables:**
   - `base_url` = `http://127.0.0.1:8000/api`
   - `category_id` = `68b73da1002c6dee007b1f5f` (get this from GET /categories)

### Test Cases to Create

#### Test 1: Basic Search
- **Name**: Search Products - Basic
- **Method**: GET
- **URL**: `{{base_url}}/products/search?q=phone`
- **Tests Script**:
```javascript
pm.test("Status code is 200", function () {
    pm.response.to.have.status(200);
});

pm.test("Response has search_query", function () {
    var jsonData = pm.response.json();
    pm.expect(jsonData).to.have.property('search_query');
    pm.expect(jsonData.search_query).to.eql('phone');
});

pm.test("Response has pagination data", function () {
    var jsonData = pm.response.json();
    pm.expect(jsonData).to.have.property('current_page');
    pm.expect(jsonData).to.have.property('total');
    pm.expect(jsonData).to.have.property('data');
});

pm.test("Response has filters_applied", function () {
    var jsonData = pm.response.json();
    pm.expect(jsonData).to.have.property('filters_applied');
});
```

#### Test 2: Search with Price Filter
- **Name**: Search Products - Price Filter
- **Method**: GET
- **URL**: `{{base_url}}/products/search?q=product&min_price=100&max_price=500`
- **Tests Script**:
```javascript
pm.test("Status code is 200", function () {
    pm.response.to.have.status(200);
});

pm.test("Price filters are applied", function () {
    var jsonData = pm.response.json();
    pm.expect(jsonData.filters_applied.min_price).to.eql("100");
    pm.expect(jsonData.filters_applied.max_price).to.eql("500");
});

pm.test("All products are within price range", function () {
    var jsonData = pm.response.json();
    jsonData.data.forEach(function(product) {
        pm.expect(product.price).to.be.at.least(100);
        pm.expect(product.price).to.be.at.most(500);
    });
});
```

#### Test 3: Search Validation (Missing Query)
- **Name**: Search Products - Validation Error
- **Method**: GET
- **URL**: `{{base_url}}/products/search` (no query parameter)
- **Tests Script**:
```javascript
pm.test("Status code is 422", function () {
    pm.response.to.have.status(422);
});

pm.test("Validation error for missing query", function () {
    var jsonData = pm.response.json();
    pm.expect(jsonData).to.have.property('message');
    pm.expect(jsonData).to.have.property('errors');
    pm.expect(jsonData.errors).to.have.property('q');
});
```

#### Test 4: Search with Stock Filter
- **Name**: Search Products - Stock Filter
- **Method**: GET
- **URL**: `{{base_url}}/products/search?q=product&in_stock=true`
- **Tests Script**:
```javascript
pm.test("Status code is 200", function () {
    pm.response.to.have.status(200);
});

pm.test("Stock filter is applied", function () {
    var jsonData = pm.response.json();
    pm.expect(jsonData.filters_applied.in_stock).to.be.true;
});

pm.test("All products are in stock", function () {
    var jsonData = pm.response.json();
    jsonData.data.forEach(function(product) {
        pm.expect(product.in_stock).to.be.true;
    });
});
```

#### Test 5: Search with Pagination
- **Name**: Search Products - Pagination
- **Method**: GET
- **URL**: `{{base_url}}/products/search?q=product&per_page=2&page=1`
- **Tests Script**:
```javascript
pm.test("Status code is 200", function () {
    pm.response.to.have.status(200);
});

pm.test("Pagination is working", function () {
    var jsonData = pm.response.json();
    pm.expect(jsonData.per_page).to.eql(2);
    pm.expect(jsonData.current_page).to.eql(1);
    pm.expect(jsonData.data.length).to.be.at.most(2);
});
```

## 🎯 Quick Test Commands

### Get Category ID for Testing
First, get a category ID to use in your tests:
```
GET http://127.0.0.1:8000/api/categories
```

### All Query Parameters
The search endpoint supports these query parameters:

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| `q` | string | Yes | Search query (searches in product_name, description, overview, about) |
| `category_id` | string | No | Filter by category ID |
| `min_price` | number | No | Minimum price filter |
| `max_price` | number | No | Maximum price filter |
| `in_stock` | boolean | No | Filter by stock status (true/false) |
| `page` | integer | No | Page number (default: 1) |
| `per_page` | integer | No | Items per page (max: 100, default: 15) |

## 🔧 Sample URLs for Quick Testing

Copy these URLs directly into Postman:

```
# Basic search
http://127.0.0.1:8000/api/products/search?q=phone

# Search with pagination
http://127.0.0.1:8000/api/products/search?q=product&per_page=3

# Search with price range
http://127.0.0.1:8000/api/products/search?q=product&min_price=100&max_price=1000

# Search in-stock products only
http://127.0.0.1:8000/api/products/search?q=product&in_stock=true

# Search out-of-stock products only
http://127.0.0.1:8000/api/products/search?q=product&in_stock=false

# Combined filters
http://127.0.0.1:8000/api/products/search?q=phone&min_price=500&max_price=1500&in_stock=true&per_page=5
```

## 📋 Response Fields Explanation

- `search_query`: The search term that was used
- `filters_applied`: Object showing which filters were applied
- `current_page`: Current page number
- `data`: Array of product results
- `total`: Total number of products matching the search
- `per_page`: Number of items per page
- `last_page`: Last page number
- `from`, `to`: Range of results shown
- Links for pagination navigation

## ⚠️ Common Issues

1. **422 Error**: Make sure to include the `q` parameter
2. **Empty Results**: Try broader search terms like "product" or "phone"
3. **Server Not Running**: Ensure Laravel server is running on port 8000
4. **Invalid Category ID**: Get valid category IDs from `/api/categories` endpoint first

## 🚀 Pro Tips

1. Use Postman's **Environment Variables** for base URL and common IDs
2. Set up **Pre-request Scripts** to get fresh category IDs
3. Use **Collection Runner** to run all tests at once
4. Save **different search scenarios** as separate requests
5. Use **Tests tab** to validate response structure and data
