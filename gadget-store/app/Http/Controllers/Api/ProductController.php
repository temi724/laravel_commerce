<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

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
            'price' => 'required|numeric',
            'overview' => 'nullable|string',
            'description' => 'nullable|string',
            'about' => 'nullable|string',
            'reviews' => 'nullable|array',
            'images_url' => 'nullable|array',
            'what_is_included' => 'nullable|array',
            'specification' => 'nullable|array',
            'in_stock' => 'boolean'
        ]);

        $product = Product::create($validated);
        return response()->json($product, 201);
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
            'price' => 'sometimes|numeric',
            'overview' => 'nullable|string',
            'description' => 'nullable|string',
            'about' => 'nullable|string',
            'reviews' => 'nullable|array',
            'images_url' => 'nullable|array',
            'what_is_included' => 'nullable|array',
            'specification' => 'nullable|array',
            'in_stock' => 'boolean'
        ]);

        $product->update($validated);
        return response()->json($product);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        return response()->json(null, 204);
    }
}
