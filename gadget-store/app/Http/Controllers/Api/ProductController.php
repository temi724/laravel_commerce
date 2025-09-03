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
     *     summary="Get all products",
     *     description="Retrieve a list of all products (public access)",
     *     operationId="getProducts",
     *     tags={"Products"},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Product")
     *         )
     *     )
     * )
     */
    public function index()
    {
        return Product::latest()->get();
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

    public function productsByCategory(string $categoryId)
    {
        $products = Product::byCategory($categoryId)->get();
        return response()->json($products);
    }
}
