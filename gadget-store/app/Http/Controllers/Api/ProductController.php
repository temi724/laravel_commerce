<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    /**
     * @OA\Get(
     *     path="/products",
     *     summary="Get all products with pagination",
     *     description="Retrieve a paginated list of all products (public access)",
     *     operationId="getProducts",
     *     tags={"Products"},
     *     @OA\Parameter(
     *         name="page",
     *         in="query",
     *         description="Page number",
     *         required=false,
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Parameter(
     *         name="per_page",
     *         in="query",
     *         description="Items per page (max 100)",
     *         required=false,
     *         @OA\Schema(type="integer", example=15)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(ref="#/components/schemas/Product")
     *             ),
     *             @OA\Property(property="current_page", type="integer", example=1),
     *             @OA\Property(property="last_page", type="integer", example=5),
     *             @OA\Property(property="per_page", type="integer", example=15),
     *             @OA\Property(property="total", type="integer", example=75),
     *             @OA\Property(property="from", type="integer", example=1),
     *             @OA\Property(property="to", type="integer", example=15)
     *         )
     *     )
     * )
     */
    public function index(Request $request)
    {
        $perPage = min($request->get('per_page', 15), 100); // Max 100 items per page
        return Product::latest()->paginate($perPage);
    }

    /**
     * @OA\Post(
     *     path="/products",
     *     summary="Create a new product",
     *     description="Create a new product (requires admin authentication)",
     *     operationId="createProduct",
     *     tags={"Products"},
     *     security={{"AdminAuth": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         description="Product data",
     *         @OA\JsonContent(ref="#/components/schemas/ProductRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Product created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Product created successfully"),
     *             @OA\Property(property="product", ref="#/components/schemas/Product"),
     *             @OA\Property(property="created_by_admin", type="string", example="Admin Name")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized - Admin authentication required"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     )
     * )
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_name' => 'required|string',
            'category_id' => 'nullable|string|exists:categories,id',
            'price' => 'required|numeric',
            'overview' => 'nullable|string',
            'description' => 'nullable|string',
            'about' => 'nullable|string',
            'reviews' => 'nullable|array',
            'images_url' => 'nullable|array',
            'colors' => 'nullable|array',
            'colors.*.path' => 'required_with:colors|string',
            'colors.*.name' => 'required_with:colors|string',
            'what_is_included' => 'nullable|array',
            'specification' => 'nullable|array',
            'in_stock' => 'boolean'
        ]);

        $product = Product::create($validated);

        // Log the admin who created the product
        $admin = $request->get('authenticated_admin');
        Log::info('Product created by admin: ' . $admin->name . ' (ID: ' . $admin->id . ')');

        return response()->json([
            'message' => 'Product created successfully',
            'product' => $product,
            'created_by_admin' => $admin->name
        ], 201);
    }

    /**
     * @OA\Get(
     *     path="/products/{id}",
     *     summary="Get product by ID",
     *     description="Retrieve a specific product by its ID (public access)",
     *     operationId="getProductById",
     *     tags={"Products"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Product ID",
     *         required=true,
     *         @OA\Schema(type="string", example="68b74ba7002cda59000d800c")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/Product")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Product not found"
     *     )
     * )
     */
    public function show(string $id)
    {
        $product = Product::findOrFail($id);
        return response()->json($product);
    }

    /**
     * @OA\Put(
     *     path="/products/{id}",
     *     summary="Update product",
     *     description="Update an existing product (requires admin authentication)",
     *     operationId="updateProduct",
     *     tags={"Products"},
     *     security={{"AdminAuth": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Product ID",
     *         required=true,
     *         @OA\Schema(type="string", example="68b74ba7002cda59000d800c")
     *     ),
     *     @OA\RequestBody(
     *         description="Product data to update",
     *         @OA\JsonContent(ref="#/components/schemas/ProductRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Product updated successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Product updated successfully"),
     *             @OA\Property(property="product", ref="#/components/schemas/Product"),
     *             @OA\Property(property="updated_by_admin", type="string", example="Admin Name")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized - Admin authentication required"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Product not found"
     *     )
     * )
     */
    public function update(Request $request, string $id)
    {
        $product = Product::findOrFail($id);

        $validated = $request->validate([
            'product_name' => 'sometimes|string',
            'category_id' => 'sometimes|nullable|string|exists:categories,id',
            'price' => 'sometimes|numeric',
            'overview' => 'nullable|string',
            'description' => 'nullable|string',
            'about' => 'nullable|string',
            'reviews' => 'nullable|array',
            'images_url' => 'nullable|array',
            'colors' => 'nullable|array',
            'colors.*.path' => 'required_with:colors|string',
            'colors.*.name' => 'required_with:colors|string',
            'what_is_included' => 'nullable|array',
            'specification' => 'nullable|array',
            'in_stock' => 'boolean'
        ]);

        $product->update($validated);

        // Log the admin who updated the product
        $admin = $request->get('authenticated_admin');
        Log::info('Product updated by admin: ' . $admin->name . ' (ID: ' . $admin->id . ')');

        return response()->json([
            'message' => 'Product updated successfully',
            'product' => $product,
            'updated_by_admin' => $admin->name
        ]);
    }

    /**
     * @OA\Delete(
     *     path="/products/{id}",
     *     summary="Delete product",
     *     description="Delete a product (requires admin authentication)",
     *     operationId="deleteProduct",
     *     tags={"Products"},
     *     security={{"AdminAuth": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Product ID",
     *         required=true,
     *         @OA\Schema(type="string", example="68b74ba7002cda59000d800c")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Product deleted successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Product deleted successfully"),
     *             @OA\Property(property="deleted_product", type="string", example="iPhone 15 Pro"),
     *             @OA\Property(property="deleted_by_admin", type="string", example="Admin Name")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized - Admin authentication required"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Product not found"
     *     )
     * )
     */
    public function destroy(Request $request, string $id)
    {
        $product = Product::findOrFail($id);
        $productName = $product->product_name;
        $product->delete();

        // Log the admin who deleted the product
        $admin = $request->get('authenticated_admin');
        Log::info('Product "' . $productName . '" deleted by admin: ' . $admin->name . ' (ID: ' . $admin->id . ')');

        return response()->json([
            'message' => 'Product deleted successfully',
            'deleted_product' => $productName,
            'deleted_by_admin' => $admin->name
        ], 200);
    }

    /**
     * @OA\Get(
     *     path="/products/search",
     *     summary="Search products",
     *     description="Search products by name, description, or category with pagination",
     *     operationId="searchProducts",
     *     tags={"Products"},
     *     @OA\Parameter(
     *         name="q",
     *         in="query",
     *         description="Search query (searches in product name, description, overview, about fields)",
     *         required=true,
     *         @OA\Schema(type="string", example="iPhone")
     *     ),
     *     @OA\Parameter(
     *         name="category_id",
     *         in="query",
     *         description="Filter by category ID",
     *         required=false,
     *         @OA\Schema(type="string", example="68b74ba7002cda59000d800d")
     *     ),
     *     @OA\Parameter(
     *         name="min_price",
     *         in="query",
     *         description="Minimum price filter",
     *         required=false,
     *         @OA\Schema(type="number", format="float", example=100.00)
     *     ),
     *     @OA\Parameter(
     *         name="max_price",
     *         in="query",
     *         description="Maximum price filter",
     *         required=false,
     *         @OA\Schema(type="number", format="float", example=1000.00)
     *     ),
     *     @OA\Parameter(
     *         name="in_stock",
     *         in="query",
     *         description="Filter by stock status",
     *         required=false,
     *         @OA\Schema(type="boolean", example=true)
     *     ),
     *     @OA\Parameter(
     *         name="page",
     *         in="query",
     *         description="Page number",
     *         required=false,
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Parameter(
     *         name="per_page",
     *         in="query",
     *         description="Items per page (max 100)",
     *         required=false,
     *         @OA\Schema(type="integer", example=15)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Search results",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(ref="#/components/schemas/Product")
     *             ),
     *             @OA\Property(property="current_page", type="integer"),
     *             @OA\Property(property="last_page", type="integer"),
     *             @OA\Property(property="per_page", type="integer"),
     *             @OA\Property(property="total", type="integer"),
     *             @OA\Property(property="search_query", type="string"),
     *             @OA\Property(property="filters_applied", type="object")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error - search query required"
     *     )
     * )
     */
    public function search(Request $request)
    {
        $request->validate([
            'q' => 'required|string|min:1',
            'category_id' => 'nullable|string|exists:categories,id',
            'min_price' => 'nullable|numeric|min:0',
            'max_price' => 'nullable|numeric|min:0',
            'in_stock' => 'nullable|boolean',
            'page' => 'nullable|integer|min:1',
            'per_page' => 'nullable|integer|min:1|max:100'
        ]);

        $query = Product::query();

        // Search in multiple fields
        $searchTerm = $request->get('q');
        $query->where(function ($q) use ($searchTerm) {
            $q->where('product_name', 'LIKE', "%{$searchTerm}%")
              ->orWhere('description', 'LIKE', "%{$searchTerm}%")
              ->orWhere('overview', 'LIKE', "%{$searchTerm}%")
              ->orWhere('about', 'LIKE', "%{$searchTerm}%");
        });

        // Apply filters
        if ($request->has('category_id')) {
            $query->where('category_id', $request->get('category_id'));
        }

        if ($request->has('min_price')) {
            $query->where('price', '>=', $request->get('min_price'));
        }

        if ($request->has('max_price')) {
            $query->where('price', '<=', $request->get('max_price'));
        }

        if ($request->has('in_stock')) {
            $query->where('in_stock', $request->boolean('in_stock'));
        }

        // Pagination
        $perPage = min($request->get('per_page', 15), 100);
        $results = $query->latest()->paginate($perPage);

        // Add search metadata to response
        $results = $results->toArray();
        $results['search_query'] = $searchTerm;
        $results['filters_applied'] = [
            'category_id' => $request->get('category_id'),
            'min_price' => $request->get('min_price'),
            'max_price' => $request->get('max_price'),
            'in_stock' => $request->get('in_stock')
        ];

        return response()->json($results);
    }

    /**
     * @OA\Get(
     *     path="/products/category/{categoryId}",
     *     summary="Get products by category with pagination",
     *     description="Retrieve products from a specific category with pagination",
     *     operationId="getProductsByCategory",
     *     tags={"Products"},
     *     @OA\Parameter(
     *         name="categoryId",
     *         in="path",
     *         description="Category ID",
     *         required=true,
     *         @OA\Schema(type="string", example="68b74ba7002cda59000d800d")
     *     ),
     *     @OA\Parameter(
     *         name="page",
     *         in="query",
     *         description="Page number",
     *         required=false,
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Parameter(
     *         name="per_page",
     *         in="query",
     *         description="Items per page (max 100)",
     *         required=false,
     *         @OA\Schema(type="integer", example=15)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(ref="#/components/schemas/Product")
     *             ),
     *             @OA\Property(property="current_page", type="integer"),
     *             @OA\Property(property="last_page", type="integer"),
     *             @OA\Property(property="per_page", type="integer"),
     *             @OA\Property(property="total", type="integer"),
     *             @OA\Property(property="category_id", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Category not found"
     *     )
     * )
     */
    public function productsByCategory(Request $request, string $categoryId)
    {
        $perPage = min($request->get('per_page', 15), 100);
        $products = Product::byCategory($categoryId)->latest()->paginate($perPage);

        // Add category_id to response metadata
        $response = $products->toArray();
        $response['category_id'] = $categoryId;

        return response()->json($response);
    }
}
