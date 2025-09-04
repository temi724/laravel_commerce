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

        <!-- Main Content -->
        <div class="py-8">
            {{ $slot }}
        </div>
    </div>

    @livewireScripts
</body>
</html>
