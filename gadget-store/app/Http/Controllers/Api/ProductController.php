<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Product::latest()->get();
    }

    /**
     * Store a newly created resource in storage.
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
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Product::findOrFail($id);
        return response()->json($product);
    }

    /**
     * Update the specified resource in storage.
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
     * Remove the specified resource from storage.
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
