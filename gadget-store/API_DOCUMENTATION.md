# API Documentation - Laravel Commerce

## 📚 **Swagger/OpenAPI Documentation**

Your Laravel Commerce API now includes comprehensive Swagger documentation!

### **How to Access Swagger Documentation:**

1. **Start your Laravel server:**
   ```bash
   php artisan serve
   ```

2. **Open Swagger UI in your browser:**
   ```
   http://127.0.0.1:8000/api/documentation
   ```

### **What's Documented:**

#### **🔐 Authentication Endpoints:**
- `POST /api/admin/login` - Admin login with email/password
- `POST /api/admins` - Create new admin account

#### **👥 Admin Management:**
- `GET /api/admins` - List all admins
- `GET /api/admins/{id}` - Get specific admin
- `PUT /api/admins/{id}` - Update admin
- `DELETE /api/admins/{id}` - Delete admin

#### **📦 Product Management:**
- `GET /api/products` - List all products (public)
- `GET /api/products/{id}` - Get specific product (public)
- `POST /api/products` - Create product (🔒 Admin only)
- `PUT /api/products/{id}` - Update product (🔒 Admin only)
- `DELETE /api/products/{id}` - Delete product (🔒 Admin only)

### **🔑 Authentication in Swagger:**

For endpoints that require admin authentication:

1. **Login first** using `/api/admin/login`
2. **Copy the `admin_id` from the response**
3. **Click "Authorize" in Swagger UI**
4. **Enter the admin_id in the "AdminAuth" field**
5. **Now you can test protected endpoints!**

### **📋 API Features Documented:**

✅ **Complete Request/Response schemas**
✅ **Authentication requirements clearly marked**
✅ **Validation rules and examples**
✅ **Error response formats**
✅ **MongoDB-like ObjectId examples**
✅ **JSON field structures (colors, specifications, etc.)**

### **🛠 Swagger Configuration:**

- **Config File:** `config/l5-swagger.php`
- **Generated JSON:** `storage/api-docs/api-docs.json`
- **Annotations:** Added to controllers and models

### **Commands:**

```bash
# Regenerate documentation after changes
php artisan l5-swagger:generate

# Publish config (already done)
php artisan vendor:publish --provider="L5Swagger\L5SwaggerServiceProvider"
```

### **Example Usage:**

1. **Create Admin:**
   ```json
   POST /api/admins
   {
     "name": "John Admin",
     "email": "john@admin.com",
     "password": "password123",
     "phone_number": "+1234567890"
   }
   ```

2. **Login:**
   ```json
   POST /api/admin/login
   {
     "email": "john@admin.com",
     "password": "password123"
   }
   ```

3. **Use admin_id from login response to access protected endpoints!**

---

**🎉 Your API documentation is now live and interactive!**

Visit: http://127.0.0.1:8000/api/documentation
