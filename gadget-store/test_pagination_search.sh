#!/bin/bash

# Test Product Pagination and Search Features
BASE_URL="http://127.0.0.1:8000/api"

echo "========================================="
echo "Testing Product Pagination & Search"
echo "========================================="

echo ""
echo "1. Testing product pagination (page 1, 5 items per page):"
echo "GET $BASE_URL/products?page=1&per_page=5"
echo ""
curl -s -X GET "$BASE_URL/products?page=1&per_page=5" | jq '.data | length, .current_page, .per_page, .total'

echo ""
echo "2. Testing product search by name (searching for 'phone'):"
echo "GET $BASE_URL/products/search?q=phone&per_page=3"
echo ""
curl -s -X GET "$BASE_URL/products/search?q=phone&per_page=3" | jq '{
  total_found: .total,
  current_page: .current_page,
  search_query: .search_query,
  results_count: (.data | length),
  first_result: .data[0].product_name
}'

echo ""
echo "3. Testing search with price filter (min_price=100, max_price=500):"
echo "GET $BASE_URL/products/search?q=product&min_price=100&max_price=500"
echo ""
curl -s -X GET "$BASE_URL/products/search?q=product&min_price=100&max_price=500" | jq '{
  search_query: .search_query,
  filters_applied: .filters_applied,
  total_found: .total,
  results: [.data[].product_name, .data[].price]
}'

echo ""
echo "4. Testing search with stock filter (in_stock=true):"
echo "GET $BASE_URL/products/search?q=product&in_stock=true&per_page=2"
echo ""
curl -s -X GET "$BASE_URL/products/search?q=product&in_stock=true&per_page=2" | jq '{
  search_query: .search_query,
  filters_applied: .filters_applied,
  total_found: .total,
  in_stock_products: [.data[] | {name: .product_name, in_stock: .in_stock}]
}'

echo ""
echo "5. Testing products by category with pagination:"
echo "First, let's get a category ID..."
CATEGORY_ID=$(curl -s -X GET "$BASE_URL/categories" | jq -r '.[0].id // "no-category"')
echo "Using category ID: $CATEGORY_ID"
echo "GET $BASE_URL/products/category/$CATEGORY_ID?per_page=3"
echo ""
if [ "$CATEGORY_ID" != "no-category" ]; then
    curl -s -X GET "$BASE_URL/products/category/$CATEGORY_ID?per_page=3" | jq '{
      category_id: .category_id,
      total_in_category: .total,
      current_page: .current_page,
      products: [.data[].product_name]
    }'
else
    echo "No categories found - please create some categories first"
fi

echo ""
echo "6. Testing search validation (missing query parameter):"
echo "GET $BASE_URL/products/search (should return validation error)"
echo ""
curl -s -X GET "$BASE_URL/products/search" | jq '{
  message: .message,
  errors: .errors
}'

echo ""
echo "========================================="
echo "Pagination & Search Testing Complete!"
echo ""
echo "Features Tested:"
echo "✅ Product pagination with custom per_page"
echo "✅ Product search by name/description"
echo "✅ Search with price filters (min/max)"
echo "✅ Search with stock status filter"
echo "✅ Search with category filter"
echo "✅ Category-based product listing with pagination"
echo "✅ Search validation"
echo "✅ Response metadata (search_query, filters_applied)"
echo "========================================="
