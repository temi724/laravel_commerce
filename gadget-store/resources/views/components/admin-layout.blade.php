<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Admin Dashboard - Gadget Store</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="font-sans antialiased bg-gray-100">
    <div class="min-h-screen">
        <!-- Navigation -->
        <nav class="bg-white shadow-lg">
            <div class="max-w-7xl mx-auto px-4">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <h1 class="text-xl font-bold text-gray-800">
                                <span class="text-blue-600">Gadget Store</span> Admin
                            </h1>
                        </div>
                    </div>
                    <div class="flex items-center space-x-4">
                        <span class="text-gray-600 text-sm">Welcome, {{ session('admin_name', 'Admin') }}</span>
                        <a href="/" class="text-gray-600 hover:text-blue-600 font-medium">View Store</a>
                        <form method="POST" action="{{ route('admin.logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="text-gray-600 hover:text-red-600 font-medium">
                                Logout
                            </button>
                        </form>
                        <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center">
                            <span class="text-white text-sm font-medium">{{ substr(session('admin_name', 'A'), 0, 1) }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Admin Navigation Tabs -->
        <div class="bg-white border-b border-gray-200">
            <div class="max-w-7xl mx-auto px-4">
                <nav class="flex space-x-8" aria-label="Tabs">
                    <a href="{{ route('admin.dashboard') }}"
                       class="py-4 px-1 border-b-2 font-medium text-sm whitespace-nowrap {{ request()->routeIs('admin.dashboard*') ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                        <svg class="w-5 h-5 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2H3z"></path>
                        </svg>
                        Dashboard
                    </a>
                    <a href="{{ route('admin.products') }}"
                       class="py-4 px-1 border-b-2 font-medium text-sm whitespace-nowrap {{ request()->routeIs('admin.products*') ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                        <svg class="w-5 h-5 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                        Products
                    </a>
                    <a href="{{ route('admin.sales') }}"
                       class="py-4 px-1 border-b-2 font-medium text-sm whitespace-nowrap {{ request()->routeIs('admin.sales*') ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                        <svg class="w-5 h-5 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                        Sales
                    </a>
                    <a href="{{ route('admin.orders') }}"
                       class="py-4 px-1 border-b-2 font-medium text-sm whitespace-nowrap {{ request()->routeIs('admin.orders*') ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                        <svg class="w-5 h-5 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                        Orders
                    </a>
                </nav>
            </div>
        </div>

        <!-- Main Content -->
        <div class="py-8">
            {{ $slot }}
        </div>
    </div>

    @livewireScripts
</body>
</html>
