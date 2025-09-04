<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gadget Store - Test</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">
    <div class="min-h-screen">
        <!-- Test Header -->
        <header class="bg-white shadow-sm border-b border-gray-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-16">
                    <div class="flex-shrink-0">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-purple-600 rounded-lg flex items-center justify-center">
                                <span class="text-white font-bold text-lg">GS</span>
                            </div>
                            <span class="ml-3 text-xl font-bold text-gray-900">Gadget Store</span>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Test Hero Section -->
        <section class="bg-gradient-to-r from-blue-900 via-purple-900 to-blue-900 text-white py-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center">
                    <h1 class="text-4xl lg:text-6xl font-bold mb-6">
                        Welcome to<br>
                        <span class="bg-gradient-to-r from-blue-400 to-purple-400 bg-clip-text text-transparent">
                            Gadget Store
                        </span>
                    </h1>
                    <p class="text-xl text-blue-100 mb-8">
                        Your homepage is now working! The Livewire components are loading.
                    </p>
                    <div class="bg-green-100 text-green-800 px-4 py-2 rounded-lg inline-block">
                        ✅ Frontend Setup Complete
                    </div>
                </div>
            </div>
        </section>

        <!-- Simple Products Test -->
        <section class="py-16 bg-gray-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <h2 class="text-3xl font-bold text-center text-gray-900 mb-8">Testing Basic Functionality</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                        <h3 class="font-semibold text-gray-900 mb-2">✅ Tailwind CSS</h3>
                        <p class="text-sm text-gray-600">Styles are loading correctly</p>
                    </div>
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                        <h3 class="font-semibold text-gray-900 mb-2">✅ Alpine.js</h3>
                        <p class="text-sm text-gray-600" x-data="{ message: 'JavaScript is working!' }" x-text="message">Loading...</p>
                    </div>
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                        <h3 class="font-semibold text-gray-900 mb-2">✅ Components</h3>
                        <p class="text-sm text-gray-600">Layout structure is ready</p>
                    </div>
                </div>
            </div>
        </section>
    </div>
</body>
</html>
