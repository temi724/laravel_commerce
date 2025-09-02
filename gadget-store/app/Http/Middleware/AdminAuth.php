<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Admin;

class AdminAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check for admin_id in headers or request
        $adminId = $request->header('Admin-ID') ?? $request->get('admin_id');

        if (!$adminId) {
            return response()->json([
                'error' => 'Admin authentication required',
                'message' => 'Please provide Admin-ID in headers or admin_id in request'
            ], 401);
        }

        // Verify admin exists
        $admin = Admin::find($adminId);
        if (!$admin) {
            return response()->json([
                'error' => 'Invalid admin credentials',
                'message' => 'Admin not found'
            ], 401);
        }

        // Add admin to request for later use
        $request->merge(['authenticated_admin' => $admin]);

        return $next($request);
    }
}
