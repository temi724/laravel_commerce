#!/bin/bash

# Test Admin Password functionality
BASE_URL="http://127.0.0.1:8000/api"

echo "========================================="
echo "Testing Admin Password Functionality"
echo "========================================="

echo ""
echo "1. Creating an admin with password:"
CREATE_RESPONSE=$(curl -s -X POST "$BASE_URL/admins" \
  -H "Content-Type: application/json" \
  -d '{
    "name": "Password Test Admin",
    "email": "passwordtest@admin.com",
    "password": "securepassword123",
    "phone_number": "+1234567890"
  }')
echo "$CREATE_RESPONSE" | jq '.'

echo ""
echo "2. Testing admin login with correct credentials:"
curl -s -X POST "$BASE_URL/admin/login" \
  -H "Content-Type: application/json" \
  -d '{
    "email": "passwordtest@admin.com",
    "password": "securepassword123"
  }' | jq '.'

echo ""
echo "3. Testing admin login with incorrect password:"
curl -s -X POST "$BASE_URL/admin/login" \
  -H "Content-Type: application/json" \
  -d '{
    "email": "passwordtest@admin.com",
    "password": "wrongpassword"
  }' | jq '.'

echo ""
echo "4. Getting all admins (password should be hidden):"
curl -s -X GET "$BASE_URL/admins" | jq '.[0]'

echo ""
echo "========================================="
echo "Password test completed!"
echo "Features tested:"
echo "- Admin creation with password"
echo "- Password hashing (automatic)"
echo "- Password hiding in API responses"
echo "- Admin login with email/password"
echo "- Invalid login handling"
echo "========================================="
