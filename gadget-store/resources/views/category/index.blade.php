<x-layout>
    <x-slot name="title">{{ $category }} - GadgetStore</x-slot>

    <!-- Category Header -->
    <section class="py-16 bg-gradient-to-r from-blue-600 to-purple-600">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">{{ $category }}</h1>
            <p class="text-xl text-blue-100 mb-6">Discover the latest {{ strtolower($category) }} at unbeatable prices</p>
        </div>
    </section>

    <!-- Products Grid -->
    <section class="py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-8 flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">All {{ $category }}</h2>
                    <p class="text-gray-600 mt-1">
                        @php
                            $productCount = $categoryModel->products()->count();
                        @endphp
                        {{ $productCount }} {{ Str::plural('product', $productCount) }} available
                    </p>
                </div>

                <!-- Sort Options -->
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" class="flex items-center gap-2 px-4 py-2 bg-white border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                        <span>Sort by</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div x-show="open" @click.outside="open = false" x-transition class="absolute right-0 mt-2 w-48 bg-white border border-gray-200 rounded-lg shadow-lg z-10">
                        <div class="py-1">
                            <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Price: Low to High</a>
                            <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Price: High to Low</a>
                            <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Newest First</a>
                            <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Most Popular</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Products Grid -->
            @if($categoryModel->products()->count() > 0)
                <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-3 sm:gap-6">
                    @foreach($categoryModel->products as $product)
                        <div class="bg-white rounded-xl border border-gray-100 overflow-hidden product-card group">
                            <div class="relative">
                                <a href="{{ route('product.show', $product->id) }}">
                                    <img src="{{ $product->image_url }}"
                                         alt="{{ $product->name }}"
                                         class="w-full h-48 sm:h-64 object-cover group-hover:scale-105 transition-transform duration-300">
                                </a>

                                @if($product->stock <= 0)
                                    <div class="absolute inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center">
                                        <span class="bg-red-500 text-white px-3 py-1 rounded-full text-sm font-semibold">Out of Stock</span>
                                    </div>
                                @endif

                                <!-- Quick view button -->
                                <button onclick="window.location.href='{{ route('product.show', $product->id) }}'"
                                        title="View product"
                                        class="absolute top-2 right-2 bg-white/90 hover:bg-white text-gray-700 hover:text-blue-600 w-8 h-8 sm:w-10 sm:h-10 rounded-full flex items-center justify-center transition-all duration-200 opacity-0 group-hover:opacity-100 shadow-lg">
                                    <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                </button>
                            </div>

                            <div class="p-3 sm:p-4">
                                <a href="{{ route('product.show', $product->id) }}">
                                    <h3 class="font-semibold text-gray-900 mb-2 text-sm sm:text-base line-clamp-2 group-hover:text-blue-600 transition-colors">
                                        {{ $product->name }}
                                    </h3>
                                </a>

                                <div class="flex items-center justify-between">
                                    <div>
                                        <span class="text-lg sm:text-xl font-bold text-blue-600">
                                            ₦{{ number_format($product->price, 0) }}
                                        </span>
                                    </div>

                                    <!-- Cart icon with navigation -->
                                    <button onclick="window.location.href='{{ route('product.show', $product->id) }}'"
                                            title="View product"
                                            class="bg-blue-600 hover:bg-blue-700 text-white w-8 h-8 sm:w-10 sm:h-10 rounded-full flex items-center justify-center transition-colors duration-200 shadow-md hover:shadow-lg">
                                        @if($product->stock <= 0)
                                            <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                        @else
                                            <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                        @endif
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-16">
                    <div class="mb-4">
                        <svg class="w-16 h-16 mx-auto text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">No products found</h3>
                    <p class="text-gray-600 mb-4">We don't have any {{ strtolower($category) }} available at the moment.</p>
                    <a href="{{ url('/') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Back to Home
                    </a>
                </div>
            @endif
        </div>
    </section>

    <!-- Newsletter Section -->
    <section class="py-16 bg-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Stay Updated</h2>
            <p class="text-gray-600 mb-8">Get notified about new {{ strtolower($category) }} and exclusive deals!</p>

            <form class="max-w-md mx-auto flex gap-4">
                <input type="email" placeholder="Enter your email" class="flex-1 px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                <button type="submit" class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                    Subscribe
                </button>
            </form>
        </div>
    </section>

    <style>
        .product-card {
            transition: all 0.3s ease;
        }

        .product-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }
    </style>
</x-layout>
