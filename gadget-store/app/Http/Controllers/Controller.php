<?php

namespace App\Http\Controllers;

/**
 * @OA\Info(
 *     version="1.0.0",
 *     title="Laravel Commerce API",
 *     description="API documentation for Laravel Commerce application with product management, sales tracking, categories, and admin authentication",
 *     @OA\Contact(
 *         email="admin@laravelcommerce.com"
 *     ),
 *     @OA\License(
 *         name="MIT",
 *         url="https://opensource.org/licenses/MIT"
 *     )
 * )
 * @OA\Server(
 *     description="Local Development Server",
 *     url="http://127.0.0.1:8000/api"
 * )
 * @OA\SecurityScheme(
 *     securityScheme="AdminAuth",
 *     type="apiKey",
 *     in="header",
 *     name="Admin-ID",
 *     description="Admin ID for authentication (required for create, update, delete operations)"
 * )
 */
abstract class Controller
{
    //
}
