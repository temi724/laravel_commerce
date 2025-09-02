#!/bin/bash

# Test admin authentication for product operations
ADMIN_ID="68b74ba7002cda59000d800c"  # First admin from our list
BASE_URL="http://127.0.0.1:8000/api"

echo "========================================="
echo "Testing Product Authorization"
echo "========================================="

echo ""
echo "1. Testing PUBLIC access - Get all products (should work):"
curl -s -X GET "$BASE_URL/products" | head -c 200
echo ""

echo ""
echo "2. Testing UNAUTHORIZED product creation (should fail):"
curl -s -X POST "$BASE_URL/products" \
  -H "Content-Type: application/json" \
  -d '{
    "product_name": "Test Product",
    "price": 299.99,
    "in_stock": true
  }' | jq '.'

echo ""
echo "3. Testing AUTHORIZED product creation (should work):"
curl -s -X POST "$BASE_URL/products" \
  -H "Content-Type: application/json" \
  -H "Admin-ID: $ADMIN_ID" \
  -d '{
    "product_name": "Authorized Test Product",
    "price": 399.99,
    "overview": "Created by admin",
    "in_stock": true
  }' | jq '.'

echo ""
echo "4. Testing UNAUTHORIZED product update (should fail):"
curl -s -X PUT "$BASE_URL/products/1" \
  -H "Content-Type: application/json" \
  -d '{
    "product_name": "Updated Without Auth",
    "price": 199.99
  }' | jq '.'

echo ""
echo "5. Testing UNAUTHORIZED product deletion (should fail):"
curl -s -X DELETE "$BASE_URL/products/1" | jq '.'

echo ""
echo "========================================="
echo "Test completed!"
echo "========================================="
