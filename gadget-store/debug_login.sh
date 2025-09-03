#!/bin/bash

# Debug Admin Login Issues
BASE_URL="http://127.0.0.1:8000/api"

echo "========================================="
echo "Debugging Admin Login"
echo "========================================="

echo ""
echo "1. First, let's create a fresh admin account for testing:"
echo ""

CREATE_RESPONSE=$(curl -s -X POST "$BASE_URL/admins" \
  -H "Content-Type: application/json" \
  -d '{
    "name": "Debug Test Admin",
    "email": "debug@test.com",
    "password": "testpass123",
    "phone_number": "+1234567890"
  }')

echo "Create admin response:"
echo "$CREATE_RESPONSE" | jq '.'

echo ""
echo "2. Now testing login with the credentials we just created:"
echo "Email: debug@test.com"
echo "Password: testpass123"
echo ""

LOGIN_RESPONSE=$(curl -s -X POST "$BASE_URL/admin/login" \
  -H "Content-Type: application/json" \
  -d '{
    "email": "debug@test.com",
    "password": "testpass123"
  }')

echo "Login response:"
echo "$LOGIN_RESPONSE" | jq '.'

echo ""
echo "3. Testing with wrong password:"
echo ""

WRONG_LOGIN_RESPONSE=$(curl -s -X POST "$BASE_URL/admin/login" \
  -H "Content-Type: application/json" \
  -d '{
    "email": "debug@test.com",
    "password": "wrongpassword"
  }')

echo "Wrong password response:"
echo "$WRONG_LOGIN_RESPONSE" | jq '.'

echo ""
echo "========================================="
echo "Debug test completed!"
echo "========================================="
