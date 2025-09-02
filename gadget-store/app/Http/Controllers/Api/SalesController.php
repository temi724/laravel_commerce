<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Sales;
use Illuminate\Http\Request;

class SalesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Sales::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|string',
            'email_address' => 'required|email',
            'phone_number' => 'required|string',
            'location' => 'required|string',
            'state' => 'required|string',
            'city' => 'required|string',
            'product_ids' => 'required|array',
        ]);

        $sale = Sales::create($validated);
        return response()->json($sale, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $sale = Sales::findOrFail($id);
        return response()->json($sale);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $sale = Sales::findOrFail($id);

        $validated = $request->validate([
            'username' => 'sometimes|string',
            'email_address' => 'sometimes|email',
            'phone_number' => 'sometimes|string',
            'location' => 'sometimes|string',
            'state' => 'sometimes|string',
            'city' => 'sometimes|string',
            'product_ids' => 'sometimes|array',
        ]);

        $sale->update($validated);
        return response()->json($sale);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $sale = Sales::findOrFail($id);
        $sale->delete();
        return response()->json(null, 204);
    }
}
