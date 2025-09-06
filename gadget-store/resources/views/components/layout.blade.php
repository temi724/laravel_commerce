<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $title ?? 'Gadget Store - Premium Electronics & Gadgets' }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@200;300;400;500;600;700;800&display=swap" rel="stylesheet">

        <!-- Styles -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles
    </head>
    <body class="bg-gray-50 font-sans antialiased">
        <!-- Header -->
        <header class="bg-white shadow-sm border-b border-gray-200 sticky top-0 z-50">
            <!-- Top Bar -->
            <div class="bg-blue-900 text-white text-sm">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between items-center py-2">
                        <div class="flex items-center space-x-6">
                            <span>🚚 Free shipping on orders over ₦50,000</span>
                            <span>📞 1-800-GADGETS</span>
                        </div>
                        <div class="flex items-center space-x-4">
                            <a href="#" class="hover:text-blue-200 transition">Account</a>
                            <a href="#" class="hover:text-blue-200 transition">Track Order</a>
                            <a href="#" class="hover:text-blue-200 transition">Help</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Header -->
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Mobile Header Layout -->
                <div class="block md:hidden">
                    <!-- Top row: Logo and icons -->
                    <div class="flex items-center justify-between h-16">
                        <!-- Logo -->
                        <div class="flex-shrink-0">
                            <a href="/" class="flex items-center">
                                <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-purple-600 rounded-lg flex items-center justify-center">
                                    <span class="text-white font-bold text-lg">GS</span>
                                </div>
                                <span class="ml-3 text-xl font-bold text-gray-900">Gadget Store</span>
                            </a>
                        </div>

                        <!-- Right Section -->
                        <div class="flex items-center space-x-4">
                            <!-- Cart -->
                            <a href="{{ route('cart.index') }}" @click.prevent="$dispatch('open-cart')" class="flex items-center space-x-1 text-gray-700 hover:text-blue-600 transition">
                                <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M7.5 7.67001V6.70001C7.5 4.45001 9.31 2.24001 11.56 2.03001C14.24 1.77001 16.5 3.88001 16.5 6.51001V7.89001" stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M9.00006 22H15.0001C19.0201 22 19.7401 20.39 19.9501 18.43L20.7001 12.43C20.9701 9.99 20.2701 8 16.0001 8H8.00006C3.73006 8 3.03006 9.99 3.30006 12.43L4.05006 18.43C4.26006 20.39 4.98006 22 9.00006 22Z" stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M15.4955 12H15.5045" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M8.49451 12H8.50349" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                <span id="cart-counter" class="bg-red-500 text-white text-xs rounded-full px-2 py-1 ml-1" data-initial-count="@php
                                        $cart = session()->get('cart', []);
                                        $count = 0;
                                        foreach($cart as $item) {
                                            $count += is_array($item) ? ($item['quantity'] ?? 0) : $item;
                                        }
                                        echo $count;
                                    @endphp">
                                    @php
                                        $cart = session()->get('cart', []);
                                        $count = 0;
                                        foreach($cart as $item) {
                                            $count += is_array($item) ? ($item['quantity'] ?? 0) : $item;
                                        }
                                        echo $count;
                                    @endphp
                                </span>
                            </a>

                            <!-- User Menu -->
                            <div class="relative" x-data="{ open: false }">
                                <button @click="open = !open" class="flex items-center space-x-1 text-gray-700 hover:text-blue-600 transition">
                                    <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M12 12C14.7614 12 17 9.76142 17 7C17 4.23858 14.7614 2 12 2C9.23858 2 7 4.23858 7 7C7 9.76142 9.23858 12 12 12Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M20.5899 22C20.5899 18.13 16.7399 15 11.9999 15C7.25991 15 3.40991 18.13 3.40991 22" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Search Bar Row for Mobile -->
                    <div class="pb-4">
                        <livewire:search-bar />
                    </div>
                </div>

                <!-- Desktop Header Layout -->
                <div class="hidden md:flex items-center justify-between h-16">
                    <!-- Logo -->
                    <div class="flex-shrink-0">
                        <a href="/" class="flex items-center">
                            <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-purple-600 rounded-lg flex items-center justify-center">
                                <span class="text-white font-bold text-lg">GS</span>
                            </div>
                            <span class="ml-3 text-xl font-bold text-gray-900">Gadget Store</span>
                        </a>
                    </div>

                    <!-- Search Bar -->
                    <div class="flex-1 max-w-2xl mx-8">
                        <livewire:search-bar />
                    </div>

                    <!-- Right Section -->
                    <div class="flex items-center space-x-6">
                        <!-- Cart -->
                        <a href="{{ route('cart.index') }}" @click.prevent="$dispatch('open-cart')" class="flex items-center space-x-1 text-gray-700 hover:text-blue-600 transition">
                            <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M7.5 7.67001V6.70001C7.5 4.45001 9.31 2.24001 11.56 2.03001C14.24 1.77001 16.5 3.88001 16.5 6.51001V7.89001" stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M9.00006 22H15.0001C19.0201 22 19.7401 20.39 19.9501 18.43L20.7001 12.43C20.9701 9.99 20.2701 8 16.0001 8H8.00006C3.73006 8 3.03006 9.99 3.30006 12.43L4.05006 18.43C4.26006 20.39 4.98006 22 9.00006 22Z" stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M15.4955 12H15.5045" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M8.49451 12H8.50349" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            <span class="hidden sm:block">Cart</span>
                            <span id="cart-counter" class="bg-red-500 text-white text-xs rounded-full px-2 py-1 ml-1" data-initial-count="@php
                                    $cart = session()->get('cart', []);
                                    $count = 0;
                                    foreach($cart as $item) {
                                        $count += is_array($item) ? ($item['quantity'] ?? 0) : $item;
                                    }
                                    echo $count;
                                @endphp">
                                @php
                                    $cart = session()->get('cart', []);
                                    $count = 0;
                                    foreach($cart as $item) {
                                        $count += is_array($item) ? ($item['quantity'] ?? 0) : $item;
                                    }
                                    echo $count;
                                @endphp
                            </span>
                        </a>

                        <!-- User Menu -->
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="flex items-center space-x-1 text-gray-700 hover:text-blue-600 transition">
                                <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M12 12C14.7614 12 17 9.76142 17 7C17 4.23858 14.7614 2 12 2C9.23858 2 7 4.23858 7 7C7 9.76142 9.23858 12 12 12Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M20.5899 22C20.5899 18.13 16.7399 15 11.9999 15C7.25991 15 3.40991 18.13 3.40991 22" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                <span class="hidden sm:block">Account</span>
                            </button>

                            <div x-show="open" @click.away="open = false" x-transition class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50">
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Sign In</a>
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Create Account</a>
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Orders</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Navigation -->
                <nav class="border-t border-gray-200">
                    <div class="flex items-center justify-between py-3">
                        <div class="flex items-center space-x-8">
                            <!-- Categories Dropdown -->
                            <div class="relative" x-data="{ open: false }">
                                <button @click="open = !open" class="flex items-center space-x-2 text-gray-700 hover:text-blue-600 transition">
                                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M3 7H21" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                                        <path d="M3 12H21" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                                        <path d="M3 17H21" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                                    </svg>
                                    <span>Categories</span>
                                    <svg class="w-4 h-4 transition-transform" :class="{ 'rotate-180': open }" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M19.9201 8.95001L13.4001 15.47C12.6301 16.24 11.3701 16.24 10.6001 15.47L4.08008 8.95001" stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </button>

                                <!-- Categories Dropdown Menu -->
                                <div x-show="open" @click.away="open = false" x-transition class="absolute left-0 mt-2 w-56 bg-white rounded-md shadow-lg py-2 z-50 border border-gray-200">
                                    @php
                                        $categories = \App\Models\Category::all();
                                    @endphp

                                    <a href="/" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition">
                                        <span class="font-medium">All Products</span>
                                    </a>
                                    <div class="border-t border-gray-100 my-1"></div>

                                    @foreach($categories as $category)
                                        <a href="#"
                                           onclick="filterByCategory('{{ $category->id }}')"
                                           class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition">
                                            {{ $category->name }}
                                        </a>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Quick Category Links - Hidden on mobile -->
                            <div class="hidden sm:flex space-x-4">
                                <a href="#" onclick="filterByCategory('')" class="text-gray-700 hover:text-blue-600 transition">All</a>
                                <a href="#" onclick="filterByCategoryName('Smartphones')" class="text-gray-700 hover:text-blue-600 transition">Smartphones</a>
                                <a href="#" onclick="filterByCategoryName('Laptops')" class="text-gray-700 hover:text-blue-600 transition">Laptops</a>
                                <a href="#" onclick="filterByCategoryName('Gaming Consoles')" class="text-gray-700 hover:text-blue-600 transition">Gaming</a>
                                <a href="#" onclick="filterByCategoryName('Speakers')" class="text-gray-700 hover:text-blue-600 transition">Audio</a>
                                <a href="#" onclick="filterByCategoryName('Smart Home')" class="text-gray-700 hover:text-blue-600 transition">Smart Home</a>
                                <a href="#deals" class="text-red-600 font-medium">Deals</a>
                            </div>
                        </div>

                        <!-- Delivery Information - Hidden on mobile -->
                        <div class="text-sm text-gray-600 hidden sm:block">
                            📍 We deliver to: <span class="font-medium">All States in Nigeria</span>
                        </div>
                    </div>
                </nav>
            </div>
        </header>

        <!-- Main Content -->
        <main>
            {{ $slot }}
        </main>

        <!-- Footer -->
        <footer class="bg-gray-900 text-white mt-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                    <div>
                        <h3 class="text-lg font-semibold mb-4">Customer Service</h3>
                        <ul class="space-y-2">
                            <li><a href="#" class="text-gray-300 hover:text-white transition">Contact Us</a></li>
                            <li><a href="#" class="text-gray-300 hover:text-white transition">Shipping Info</a></li>
                            <li><a href="#" class="text-gray-300 hover:text-white transition">Returns</a></li>
                            <li><a href="#" class="text-gray-300 hover:text-white transition">FAQ</a></li>
                        </ul>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold mb-4">About</h3>
                        <ul class="space-y-2">
                            <li><a href="#" class="text-gray-300 hover:text-white transition">Our Story</a></li>
                            <li><a href="#" class="text-gray-300 hover:text-white transition">Careers</a></li>
                            <li><a href="#" class="text-gray-300 hover:text-white transition">Press</a></li>
                            <li><a href="#" class="text-gray-300 hover:text-white transition">Sustainability</a></li>
                        </ul>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold mb-4">Connect</h3>
                        <ul class="space-y-2">
                            <li><a href="#" class="text-gray-300 hover:text-white transition">Facebook</a></li>
                            <li><a href="#" class="text-gray-300 hover:text-white transition">Twitter</a></li>
                            <li><a href="#" class="text-gray-300 hover:text-white transition">Instagram</a></li>
                            <li><a href="#" class="text-gray-300 hover:text-white transition">YouTube</a></li>
                        </ul>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold mb-4">Newsletter</h3>
                        <p class="text-gray-300 mb-4">Get the latest deals and tech news</p>
                        <div class="flex">
                            <input type="email" placeholder="Email address" class="flex-1 px-3 py-2 bg-gray-800 border border-gray-700 rounded-l-md focus:outline-none focus:border-blue-500">
                            <button class="px-4 py-2 bg-blue-600 text-white rounded-r-md hover:bg-blue-700 transition">Join</button>
                        </div>
                    </div>
                </div>

                <div class="border-t border-gray-800 mt-12 pt-8 flex flex-col md:flex-row justify-between items-center">
                    <p class="text-gray-400">&copy; 2025 Gadget Store. All rights reserved.</p>
                    <div class="flex space-x-4 mt-4 md:mt-0">
                        <a href="#" class="text-gray-400 hover:text-white transition">Privacy</a>
                        <a href="#" class="text-gray-400 hover:text-white transition">Terms</a>
                        <a href="#" class="text-gray-400 hover:text-white transition">Accessibility</a>
                    </div>
                </div>
            </div>
        </footer>

        @livewireScripts
        <!-- Toast / Flash message container -->
        <div id="flash-toast" class="fixed top-6 right-6 z-50" style="display: none;">
            <div id="flash-inner" class="max-w-sm w-full bg-white shadow-md rounded-md border border-gray-100 px-4 py-3 flex items-center space-x-3">
                <div class="flex-shrink-0 text-green-600">
                    <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
                <div>
                    <div id="flash-title" class="text-sm font-medium text-gray-900">Added to cart</div>
                    <div id="flash-body" class="text-xs text-gray-500">Product added to cart.</div>
                </div>
            </div>
        </div>

        <script>
            console.log('Layout script loaded');

            // Category filtering functions
            function filterByCategory(categoryId) {
                // Dispatch event to ProductGrid component
                if (window.Livewire) {
                    window.Livewire.dispatch('categorySelected', [categoryId]);
                }

                // Scroll to products section
                const productsSection = document.getElementById('products');
                if (productsSection) {
                    productsSection.scrollIntoView({ behavior: 'smooth' });
                }
            }

            function filterByCategoryName(categoryName) {
                // Find category ID by name and filter
                fetch('/api/categories')
                    .then(response => response.json())
                    .then(data => {
                        const category = data.find(cat => cat.name === categoryName);
                        if (category) {
                            filterByCategory(category.id);
                        }
                    })
                    .catch(error => {
                        console.log('Category filtering:', categoryName);
                        // Fallback - just scroll to products
                        const productsSection = document.getElementById('products');
                        if (productsSection) {
                            productsSection.scrollIntoView({ behavior: 'smooth' });
                        }
                    });
            }

            // Handle cart count updates from CartPage component
            window.addEventListener('cartCountUpdated', function(e) {
                console.log('cartCountUpdated event received:', e.detail);
                const count = e.detail || 0;
                updateCartBadge(count);
            });

            // Handle cart updates from Cart component
            window.addEventListener('cartUpdated', function() {
                console.log('cartUpdated event received');
                // Refresh from server when cart is updated
                setTimeout(refreshCartCount, 100);
            });

            // Handle add-to-cart events from Alpine.js and dispatch to Livewire
            window.addEventListener('add-to-cart', function(event) {
                // Use Livewire.dispatch to trigger Livewire listeners
                Livewire.dispatch('addToCart', [event.detail.productId]);
            });

            // Handle open-cart events
            window.addEventListener('open-cart', function() {
                Livewire.dispatch('openCart');
            });

            // Function to update cart badge
            function updateCartBadge(count) {
                const badge = document.getElementById('cart-counter');
                if (badge) {
                    console.log('Updating cart badge to:', count, 'Element found:', badge);
                    badge.textContent = count || 0;
                    // Store the count in localStorage to persist across page loads
                    localStorage.setItem('cartCount', count || 0);
                } else {
                    console.error('Cart counter element not found!');
                }
            }

            // Load cart count from localStorage on page load
            function loadCartCountFromStorage() {
                const badge = document.getElementById('cart-counter');
                if (badge) {
                    const storedCount = localStorage.getItem('cartCount');
                    const initialCount = badge.getAttribute('data-initial-count') || 0;

                    if (storedCount !== null && parseInt(storedCount) > parseInt(initialCount)) {
                        // Use stored count if it's higher than initial count
                        updateCartBadge(parseInt(storedCount));
                    } else {
                        // Use initial count from server
                        updateCartBadge(parseInt(initialCount));
                    }
                }
            }

            // Show flash toast and update cart badge when Cart Livewire dispatches browser event
            window.addEventListener('cart-item-added', function(e) {
                try {
                    const detail = e.detail || {};
                    console.log('Cart event received:', detail); // Debug logging
                    const title = detail.productName ? `Added: ${detail.productName}` : 'Added to cart';
                    const count = detail.count || 0;

                    // Update badge immediately
                    updateCartBadge(count);

                    // Also refresh from server after a short delay to ensure accuracy
                    setTimeout(refreshCartCount, 500);

                    // Update and show toast
                    const toast = document.getElementById('flash-toast');
                    const flashTitle = document.getElementById('flash-title');
                    const flashBody = document.getElementById('flash-body');

                    if (flashTitle) flashTitle.textContent = title;
                    if (flashBody) flashBody.textContent = `You now have ${count} item${count === 1 ? '' : 's'} in your cart.`;

                    if (toast) {
                        toast.style.display = 'block';
                        toast.classList.remove('opacity-0');
                        setTimeout(() => {
                            toast.style.display = 'none';
                        }, 2800);
                    }
                } catch (err) {
                    console.error('cart-item-added handler error', err);
                }
            });

            // Function to get current cart count from server
            async function refreshCartCount() {
                try {
                    console.log('Refreshing cart count from server...');
                    const response = await fetch('/api/cart/count', {
                        method: 'GET',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Content-Type': 'application/json',
                        },
                    });

                    if (response.ok) {
                        const data = await response.json();
                        console.log('Server returned count:', data.count);
                        updateCartBadge(data.count || 0);
                    } else {
                        console.error('Server returned error:', response.status);
                    }
                } catch (error) {
                    console.error('Failed to refresh cart count:', error);
                }
            }

            // Initialize cart counter on page load
            document.addEventListener('DOMContentLoaded', function() {
                console.log('Page loaded, initializing cart counter...');

                // Load from localStorage first for immediate update
                loadCartCountFromStorage();

                // Then refresh from server after Livewire is ready
                setTimeout(() => {
                    console.log('Refreshing cart count from server...');
                    refreshCartCount();
                }, 200);
            });
        </script>

        <!-- Cart Component (only show when not on cart page) -->
        @if(!request()->is('cart'))
            <livewire:cart />
        @endif
    </body>
</html>
