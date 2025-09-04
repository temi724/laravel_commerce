<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Session;
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
        // Check if this is an API request
        if ($request->expectsJson() || $request->is('api/*')) {
            return $this->handleApiAuth($request, $next);
        }

        // Handle web authentication
        return $this->handleWebAuth($request, $next);
    }

    private function handleApiAuth(Request $request, Closure $next): Response
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

    private function handleWebAuth(Request $request, Closure $next): Response
    {
        // Check if admin is logged in via session
        if (!Session::get('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        // Verify admin still exists
        $adminId = Session::get('admin_id');
        if (!$adminId) {
            Session::flush();
            return redirect()->route('admin.login');
        }

        $admin = Admin::find($adminId);
        if (!$admin) {
            Session::flush();
            return redirect()->route('admin.login');
        }

        // Add admin to request for later use
        $request->merge(['authenticated_admin' => $admin]);

        // Ensure admin name is in session for tracking purposes
        if (!Session::get('admin_name')) {
            Session::put('admin_name', $admin->name);
        }

        return $next($request);
    }
}
