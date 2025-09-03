<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
    /**
     * @OA\Get(
     *     path="/admins",
     *     summary="Get all admins",
     *     description="Retrieve a list of all administrators",
     *     operationId="getAdmins",
     *     tags={"Admins"},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Admin")
     *         )
     *     )
     * )
     */
    public function index(): JsonResponse
    {
        $admins = Admin::all();
        return response()->json($admins);
    }

    /**
     * @OA\Post(
     *     path="/admins",
     *     summary="Create a new admin",
     *     description="Create a new administrator account",
     *     operationId="createAdmin",
     *     tags={"Admins"},
     *     @OA\RequestBody(
     *         required=true,
     *         description="Admin data",
     *         @OA\JsonContent(
     *             required={"name", "email", "password", "phone_number"},
     *             @OA\Property(property="name", type="string", maxLength=255, example="John Smith"),
     *             @OA\Property(property="email", type="string", format="email", example="john.smith@admin.com"),
     *             @OA\Property(property="password", type="string", minLength=6, example="password123"),
     *             @OA\Property(property="phone_number", type="string", maxLength=20, example="+1234567890")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Admin created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Admin")
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="The given data was invalid."),
     *             @OA\Property(property="errors", type="object")
     *         )
     *     )
     * )
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:admins,email',
            'password' => 'required|string|min:6',
            'phone_number' => 'required|string|max:20',
        ]);

        $admin = Admin::create($validated);

        return response()->json($admin, 201);
    }

    /**
     * @OA\Get(
     *     path="/admins/{id}",
     *     summary="Get admin by ID",
     *     description="Retrieve a specific administrator by their ID",
     *     operationId="getAdminById",
     *     tags={"Admins"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Admin ID",
     *         required=true,
     *         @OA\Schema(type="string", example="68b74ba7002cda59000d800c")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/Admin")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Admin not found"
     *     )
     * )
     */
    public function show(string $id): JsonResponse
    {
        $admin = Admin::findOrFail($id);
        return response()->json($admin);
    }

    /**
     * @OA\Put(
     *     path="/admins/{id}",
     *     summary="Update admin",
     *     description="Update an existing administrator",
     *     operationId="updateAdmin",
     *     tags={"Admins"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Admin ID",
     *         required=true,
     *         @OA\Schema(type="string", example="68b74ba7002cda59000d800c")
     *     ),
     *     @OA\RequestBody(
     *         description="Admin data to update",
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string", maxLength=255, example="John Smith Updated"),
     *             @OA\Property(property="email", type="string", format="email", example="john.updated@admin.com"),
     *             @OA\Property(property="password", type="string", minLength=6, example="newpassword123"),
     *             @OA\Property(property="phone_number", type="string", maxLength=20, example="+1987654321")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Admin updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Admin")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Admin not found"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     )
     * )
     */
    public function update(Request $request, string $id): JsonResponse
    {
        $admin = Admin::findOrFail($id);

        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|email|unique:admins,email,' . $id,
            'password' => 'sometimes|required|string|min:6',
            'phone_number' => 'sometimes|required|string|max:20',
        ]);

        $admin->update($validated);

        return response()->json($admin);
    }

    /**
     * @OA\Delete(
     *     path="/admins/{id}",
     *     summary="Delete admin",
     *     description="Delete an administrator",
     *     operationId="deleteAdmin",
     *     tags={"Admins"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Admin ID",
     *         required=true,
     *         @OA\Schema(type="string", example="68b74ba7002cda59000d800c")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Admin deleted successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Admin deleted successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Admin not found"
     *     )
     * )
     */
    public function destroy(string $id): JsonResponse
    {
        $admin = Admin::findOrFail($id);
        $admin->delete();

        return response()->json(['message' => 'Admin deleted successfully']);
    }

    /**
     * @OA\Post(
     *     path="/admin/login",
     *     summary="Admin login",
     *     description="Authenticate admin with email and password",
     *     operationId="adminLogin",
     *     tags={"Authentication"},
     *     @OA\RequestBody(
     *         required=true,
     *         description="Login credentials",
     *         @OA\JsonContent(
     *             required={"email", "password"},
     *             @OA\Property(property="email", type="string", format="email", example="admin@test.com"),
     *             @OA\Property(property="password", type="string", example="password123")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Login successful",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Login successful"),
     *             @OA\Property(property="admin", ref="#/components/schemas/Admin"),
     *             @OA\Property(property="admin_id", type="string", example="68b74ba7002cda59000d800c")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Invalid credentials",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Invalid credentials"),
     *             @OA\Property(property="message", type="string", example="Email or password is incorrect")
     *         )
     *     )
     * )
     */
    public function login(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        // Find admin by email
        $admin = Admin::where('email', $validated['email'])->first();

        // Debug: Log the attempt
        Log::info('Login attempt for email: ' . $validated['email']);

        if (!$admin) {
            Log::info('Admin not found for email: ' . $validated['email']);
            return response()->json([
                'error' => 'Invalid credentials',
                'message' => 'Email or password is incorrect'
            ], 401);
        }

        Log::info('Admin found: ' . $admin->name . ', checking password...');

        // Check password
        $passwordCheck = $admin->checkPassword($validated['password']);
        Log::info('Password check result: ' . ($passwordCheck ? 'SUCCESS' : 'FAILED'));

        if (!$passwordCheck) {
            return response()->json([
                'error' => 'Invalid credentials',
                'message' => 'Email or password is incorrect'
            ], 401);
        }

        Log::info('Login successful for admin: ' . $admin->name);

        return response()->json([
            'message' => 'Login successful',
            'admin' => $admin,
            'admin_id' => $admin->id
        ]);
    }
}
