<x-layout>
    <x-slot name="title">Gadget Store - Premium Electronics & Gadgets</x-slot>

    <!-- Hero Section -->
    <section class="bg-gradient-to-r from-blue-900 via-purple-900 to-blue-900 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 lg:py-24">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div>
                    <h1 class="text-4xl lg:text-6xl font-bold mb-6">
                        Latest Tech.<br>
                        <span class="bg-gradient-to-r from-blue-400 to-purple-400 bg-clip-text text-transparent">
                            Best Prices.
                        </span>
                    </h1>
                    <p class="text-xl text-blue-100 mb-8 max-w-md">
                        Discover cutting-edge gadgets, smartphones, laptops, and more. Get free shipping on orders over ₦50,000.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="#products" class="bg-white text-blue-900 px-8 py-3 rounded-lg font-semibold hover:bg-blue-50 transition text-center">
                            Shop Now
                        </a>
                        <a href="#deals" class="border-2 border-white text-white px-8 py-3 rounded-lg font-semibold hover:bg-white hover:text-blue-900 transition text-center">
                            View Deals
                        </a>
                    </div>
                </div>
                <div class="relative">
                    <div class="bg-white/10 rounded-2xl p-8 backdrop-blur-sm">
                        <div class="space-y-6">
                            <div class="flex items-center space-x-4">
                                <div class="w-12 h-12 bg-blue-400 rounded-lg flex items-center justify-center">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <div class="font-semibold">Latest Smartphones</div>
                                    <div class="text-blue-200 text-sm">From ₦299,000</div>
                                </div>
                            </div>
                            <div class="flex items-center space-x-4">
                                <div class="w-12 h-12 bg-purple-400 rounded-lg flex items-center justify-center">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <div class="font-semibold">Gaming Laptops</div>
                                    <div class="text-blue-200 text-sm">Up to 50% Off</div>
                                </div>
                            </div>
                            <div class="flex items-center space-x-4">
                                <div class="w-12 h-12 bg-green-400 rounded-lg flex items-center justify-center">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536M9 11V9a3 3 0 116 0v2m-3 9a7 7 0 100-14 7 7 0 000 14z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <div class="font-semibold">Smart Home</div>
                                    <div class="text-blue-200 text-sm">Free Installation</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Categories -->
    <section class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-center text-gray-900 mb-12">Shop by Category</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                <div class="bg-white rounded-xl border border-gray-100 hover:border-blue-200 transition-all duration-200 p-6 text-center group cursor-pointer hover:bg-blue-50/30">
                    <div class="w-16 h-16 mx-auto bg-blue-100 rounded-xl flex items-center justify-center mb-4 group-hover:bg-blue-200 group-hover:scale-110 transition-all duration-200">
                        <svg class="w-8 h-8 text-blue-600" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M2 6C2 4.11438 2 3.17157 2.58579 2.58579C3.17157 2 4.11438 2 6 2H18C19.8856 2 20.8284 2 21.4142 2.58579C22 3.17157 22 4.11438 22 6V18C22 19.8856 22 20.8284 21.4142 21.4142C20.8284 22 19.8856 22 18 22H6C4.11438 22 3.17157 22 2.58579 21.4142C2 20.8284 2 19.8856 2 18V6Z" stroke="currentColor" stroke-width="1.5"/>
                            <path d="M6 10H10" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                            <path d="M12 17H18" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                            <path d="M7 17H8" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                        </svg>
                    </div>
                    <h3 class="font-semibold text-gray-900 mb-2 group-hover:text-blue-900 transition-colors">Smartphones</h3>
                    <p class="text-sm text-gray-600">Latest models</p>
                </div>

                <div class="bg-white rounded-xl border border-gray-100 hover:border-purple-200 transition-all duration-200 p-6 text-center group cursor-pointer hover:bg-purple-50/30">
                    <div class="w-16 h-16 mx-auto bg-purple-100 rounded-xl flex items-center justify-center mb-4 group-hover:bg-purple-200 group-hover:scale-110 transition-all duration-200">
                        <svg class="w-8 h-8 text-purple-600" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M2 6C2 4.11438 2 3.17157 2.58579 2.58579C3.17157 2 4.11438 2 6 2H18C19.8856 2 20.8284 2 21.4142 2.58579C22 3.17157 22 4.11438 22 6V15C22 16.8856 22 17.8284 21.4142 18.4142C20.8284 19 19.8856 19 18 19H6C4.11438 19 3.17157 19 2.58579 18.4142C2 17.8284 2 16.8856 2 15V6Z" stroke="currentColor" stroke-width="1.5"/>
                            <path d="M2 15L5.5 15L8 22L10.5 15L14 15" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M22 15L18.5 15L16 22L13.5 15L10 15" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                    <h3 class="font-semibold text-gray-900 mb-2 group-hover:text-purple-900 transition-colors">Laptops</h3>
                    <p class="text-sm text-gray-600">Work & Gaming</p>
                </div>

                <div class="bg-white rounded-xl border border-gray-100 hover:border-green-200 transition-all duration-200 p-6 text-center group cursor-pointer hover:bg-green-50/30">
                    <div class="w-16 h-16 mx-auto bg-green-100 rounded-xl flex items-center justify-center mb-4 group-hover:bg-green-200 group-hover:scale-110 transition-all duration-200">
                        <svg class="w-8 h-8 text-green-600" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M2 18C2 16.4596 2 15.6893 2.34673 15.1235C2.54074 14.8069 2.80693 14.5407 3.12353 14.3467C3.68934 14 4.45956 14 6 14C7.54044 14 8.31066 14 8.87647 14.3467C9.19307 14.5407 9.45926 14.8069 9.65327 15.1235C10 15.6893 10 16.4596 10 18C10 19.5404 10 20.3107 9.65327 20.8765C9.45926 21.1931 9.19307 21.4593 8.87647 21.6533C8.31066 22 7.54044 22 6 22C4.45956 22 3.68934 22 3.12353 21.6533C2.80693 21.4593 2.54074 21.1931 2.34673 20.8765C2 20.3107 2 19.5404 2 18Z" stroke="currentColor" stroke-width="1.5"/>
                            <path d="M14 18C14 16.4596 14 15.6893 14.3467 15.1235C14.5407 14.8069 14.8069 14.5407 15.1235 14.3467C15.6893 14 16.4596 14 18 14C19.5404 14 20.3107 14 20.8765 14.3467C21.1931 14.5407 21.4593 14.8069 21.6533 15.1235C22 15.6893 22 16.4596 22 18C22 19.5404 22 20.3107 21.6533 20.8765C21.4593 21.1931 21.1931 21.4593 20.8765 21.6533C20.3107 22 19.5404 22 18 22C16.4596 22 15.6893 22 15.1235 21.6533C14.8069 21.4593 14.5407 21.1931 14.3467 20.8765C14 20.3107 14 19.5404 14 18Z" stroke="currentColor" stroke-width="1.5"/>
                            <path d="M6 2V10C6 11.4142 7.58579 13 9 13H15C16.4142 13 18 11.4142 18 10V2" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M9 6C10.6569 6 12 4.65685 12 3C12 4.65685 13.3431 6 15 6" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                    <h3 class="font-semibold text-gray-900 mb-2 group-hover:text-green-900 transition-colors">Audio</h3>
                    <p class="text-sm text-gray-600">Headphones & Speakers</p>
                </div>

                <div class="bg-white rounded-xl border border-gray-100 hover:border-red-200 transition-all duration-200 p-6 text-center group cursor-pointer hover:bg-red-50/30">
                    <div class="w-16 h-16 mx-auto bg-red-100 rounded-xl flex items-center justify-center mb-4 group-hover:bg-red-200 group-hover:scale-110 transition-all duration-200">
                        <svg class="w-8 h-8 text-red-600" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M2 14.5C2 11.2617 2 9.64256 2.87868 8.32128C3.75736 7 5.24264 7 8.21321 7H15.7868C18.7574 7 20.2426 7 21.1213 8.32128C22 9.64256 22 11.2617 22 14.5V15.5C22 18.7383 22 20.3574 21.1213 21.6787C20.2426 23 18.7574 23 15.7868 23H8.21321C5.24264 23 3.75736 23 2.87868 21.6787C2 20.3574 2 18.7383 2 15.5V14.5Z" stroke="currentColor" stroke-width="1.5"/>
                            <path d="M22 12H2" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                            <path d="M15 1L12 4L9 1" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            <circle cx="6.5" cy="16.5" r="1.5" stroke="currentColor" stroke-width="1.5"/>
                            <circle cx="17.5" cy="16.5" r="1.5" stroke="currentColor" stroke-width="1.5"/>
                        </svg>
                    </div>
                    <h3 class="font-semibold text-gray-900 mb-2 group-hover:text-red-900 transition-colors">Gaming</h3>
                    <p class="text-sm text-gray-600">Consoles & Accessories</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Flash Deals -->
    <section class="py-16" id="deals">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h2 class="text-3xl font-bold text-gray-900 mb-2">⚡ Flash Deals</h2>
                    <p class="text-gray-600">Limited time offers - Don't miss out!</p>
                </div>
                <div class="bg-red-100 text-red-800 px-4 py-2 rounded-lg font-semibold" x-data="countdown()" x-text="timeLeft">
                    Ends in 23:45:12
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @php
                    $deals = \App\Models\Deal::inStock()->take(6)->get();
                @endphp

                @forelse($deals as $deal)
                    <a href="{{ route('product.show', $deal->id) }}" class="bg-white rounded-xl border border-gray-100 hover:border-gray-200 overflow-hidden group transition-all duration-200 block">
                        <div class="relative">
                            @if($deal->images_url && count($deal->images_url) > 0)
                                <img
                                    src="{{ $deal->images_url[0] }}"
                                    alt="{{ $deal->product_name }}"
                                    class="w-full aspect-video object-cover"
                                    onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';"
                                >
                                <div class="absolute inset-0 flex items-center justify-center" style="display: none;">
                                    <svg class="w-16 h-16 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                            @else
                                <div class="w-full aspect-video bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center">
                                    <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                            @endif
                            @if($deal->old_price && $deal->old_price > $deal->price)
                                @php
                                    $discountPercentage = round((($deal->old_price - $deal->price) / $deal->old_price) * 100);
                                @endphp
                                <div class="absolute top-3 left-3 bg-red-500 text-white px-2 py-1 rounded-md text-xs font-bold">
                                    {{ $discountPercentage }}% OFF
                                </div>
                            @endif
                        </div>
                        <div class="p-6">
                            <h3 class="font-semibold text-gray-900 mb-3 px-1">{{ $deal->product_name }}</h3>
                            <div class="flex items-center space-x-2 mb-5 px-1">
                                <span class="text-2xl font-bold text-gray-900">₦{{ number_format($deal->price, 0) }}</span>
                                @if($deal->old_price && $deal->old_price > $deal->price)
                                    <span class="text-lg text-gray-500 line-through">₦{{ number_format($deal->old_price, 0) }}</span>
                                    <span class="bg-red-100 text-red-800 px-3 py-1 rounded-full text-xs font-medium">
                                        Save ₦{{ number_format($deal->old_price - $deal->price, 0) }}
                                    </span>
                                @endif
                            </div>
                            <div class="flex items-center justify-between px-1">
                                <span class="text-sm font-medium text-gray-600">⚡ Flash Deal</span>
                                <button
                                    onclick="event.preventDefault(); event.stopPropagation(); window.Livewire && Livewire.dispatch('addToCart', ['{{ $deal->id }}', 1, 'deal'])"
                                    class="flex items-center gap-2 text-blue-600 hover:text-blue-700 font-medium text-sm transition-colors group"
                                >
                                    {{-- <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M2 3L2.26491 3.0883C3.58495 3.52832 4.24497 3.74832 4.62248 4.2721C5 4.79587 5 5.49159 5 6.88304V9.5C5 12.7875 5 14.4312 5.90796 15.5376C6.07418 15.7401 6.25989 15.9258 6.46243 16.092C7.56878 17 9.21252 17 12.5 17C15.7875 17 17.4312 17 18.5376 16.092C18.7401 15.9258 18.9258 15.7401 19.092 15.5376C20 14.4312 20 12.7875 20 9.5V8.5C20 7.09554 20 6.39331 19.6532 5.88886C19.3065 5.38441 18.6851 5.18885 17.4422 4.79773L12.5 3" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                                        <path d="M7.5 18C8.32843 18 9 18.6716 9 19.5C9 20.3284 8.32843 21 7.5 21C6.67157 21 6 20.3284 6 19.5C6 18.6716 6.67157 18 7.5 18Z" stroke="currentColor" stroke-width="1.5"/>
                                        <path d="M16.5 18.0001C17.3284 18.0001 18 18.6716 18 19.5001C18 20.3285 17.3284 21.0001 16.5 21.0001C15.6716 21.0001 15 20.3285 15 19.5001C15 18.6716 15.6716 18.0001 16.5 18.0001Z" stroke="currentColor" stroke-width="1.5"/>
                                    </svg>
                                    Quick Add
                                </button> --}}
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="col-span-full text-center py-12">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">No deals available</h3>
                        <p class="mt-1 text-sm text-gray-500">Check back later for amazing deals!</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Products Section with Livewire -->
    <section class="py-16 bg-gray-50" id="products">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between mb-8">
                <h2 class="text-3xl font-bold text-gray-900">Featured Products</h2>
                <a href="/api/products" class="text-blue-600 hover:text-blue-800 font-medium">View API →</a>
            </div>

            <!-- Livewire Product Grid Component -->
            <livewire:product-grid />

            <div class="text-center mt-8">
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <p class="text-blue-800 text-sm">
                        <strong>Interactive Filtering:</strong> Use the category dropdown in the search bar above to filter products by category!
                    </p>
                </div>
            </div>
        </div>
    {{-- </section>    <!-- Gadget Carousel -->
    <section class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Latest Gadgets</h2>
                <p class="text-xl text-gray-600">Explore our premium collection of cutting-edge technology</p>
            </div>

            <!-- Carousel Container -->
            <div class="relative overflow-hidden" x-data="gadgetCarousel()">
                <!-- Carousel Track -->
                <div class="flex transition-transform duration-500 ease-in-out" :style="`transform: translateX(-${currentSlide * (100 / slidesToShow)}%)`">
                    <!-- Slide 1 -->
                    <div class="flex-none w-full md:w-1/2 lg:w-1/3 px-4">
                        <div class="group relative overflow-hidden rounded-2xl bg-white shadow-lg hover:shadow-2xl transition-all duration-300">
                            <div class="aspect-square bg-gradient-to-br from-blue-500 to-purple-600 relative">
                                <div class="absolute inset-0 flex items-center justify-center">
                                    <svg class="w-24 h-24 text-white" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </div>
                                <div class="absolute top-4 left-4 bg-green-500 text-white px-3 py-1 rounded-full text-sm font-medium">
                                    New
                                </div>
                            </div>
                            <div class="p-6">
                                <h3 class="text-xl font-bold text-gray-900 mb-2">iPhone 15 Pro</h3>
                                <p class="text-gray-600 mb-4">Titanium design with A17 Pro chip</p>
                                <div class="flex items-center justify-between">
                                    <span class="text-2xl font-bold text-blue-600">₦1,299,000</span>
                                    <button class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                                        View Details
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Slide 2 -->
                    <div class="flex-none w-full md:w-1/2 lg:w-1/3 px-4">
                        <div class="group relative overflow-hidden rounded-2xl bg-white shadow-lg hover:shadow-2xl transition-all duration-300">
                            <div class="aspect-square bg-gradient-to-br from-purple-500 to-pink-600 relative">
                                <div class="absolute inset-0 flex items-center justify-center">
                                    <svg class="w-24 h-24 text-white" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </div>
                                <div class="absolute top-4 left-4 bg-red-500 text-white px-3 py-1 rounded-full text-sm font-medium">
                                    Hot Deal
                                </div>
                            </div>
                            <div class="p-6">
                                <h3 class="text-xl font-bold text-gray-900 mb-2">MacBook Pro 16"</h3>
                                <p class="text-gray-600 mb-4">M3 Max chip, Liquid Retina XDR display</p>
                                <div class="flex items-center justify-between">
                                    <span class="text-2xl font-bold text-purple-600">₦2,499,000</span>
                                    <button class="bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700 transition-colors">
                                        View Details
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Slide 3 -->
                    <div class="flex-none w-full md:w-1/2 lg:w-1/3 px-4">
                        <div class="group relative overflow-hidden rounded-2xl bg-white shadow-lg hover:shadow-2xl transition-all duration-300">
                            <div class="aspect-square bg-gradient-to-br from-green-500 to-teal-600 relative">
                                <div class="absolute inset-0 flex items-center justify-center">
                                    <svg class="w-24 h-24 text-white" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M15.232 5.232l3.536 3.536M9 11V9a3 3 0 116 0v2m-3 9a7 7 0 100-14 7 7 0 000 14z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </div>
                                <div class="absolute top-4 left-4 bg-blue-500 text-white px-3 py-1 rounded-full text-sm font-medium">
                                    Featured
                                </div>
                            </div>
                            <div class="p-6">
                                <h3 class="text-xl font-bold text-gray-900 mb-2">AirPods Pro</h3>
                                <p class="text-gray-600 mb-4">Active noise cancellation, spatial audio</p>
                                <div class="flex items-center justify-between">
                                    <span class="text-2xl font-bold text-green-600">₦149,000</span>
                                    <button class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-colors">
                                        View Details
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Slide 4 -->
                    <div class="flex-none w-full md:w-1/2 lg:w-1/3 px-4">
                        <div class="group relative overflow-hidden rounded-2xl bg-white shadow-lg hover:shadow-2xl transition-all duration-300">
                            <div class="aspect-square bg-gradient-to-br from-red-500 to-orange-600 relative">
                                <div class="absolute inset-0 flex items-center justify-center">
                                    <svg class="w-24 h-24 text-white" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M2 14.5C2 11.2617 2 9.64256 2.87868 8.32128C3.75736 7 5.24264 7 8.21321 7H15.7868C18.7574 7 20.2426 7 21.1213 8.32128C22 9.64256 22 11.2617 22 14.5V15.5C22 18.7383 22 20.3574 21.1213 21.6787C20.2426 23 18.7574 23 15.7868 23H8.21321C5.24264 23 3.75736 23 2.87868 21.6787C2 20.3574 2 18.7383 2 15.5V14.5Z" stroke="currentColor" stroke-width="2"/>
                                        <path d="M22 12H2" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                                        <circle cx="6.5" cy="16.5" r="1.5" stroke="currentColor" stroke-width="2"/>
                                        <circle cx="17.5" cy="16.5" r="1.5" stroke="currentColor" stroke-width="2"/>
                                    </svg>
                                </div>
                                <div class="absolute top-4 left-4 bg-purple-500 text-white px-3 py-1 rounded-full text-sm font-medium">
                                    Gaming
                                </div>
                            </div>
                            <div class="p-6">
                                <h3 class="text-xl font-bold text-gray-900 mb-2">PlayStation 5</h3>
                                <p class="text-gray-600 mb-4">Next-gen gaming console with 4K graphics</p>
                                <div class="flex items-center justify-between">
                                    <span class="text-2xl font-bold text-red-600">₦399,000</span>
                                    <button class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition-colors">
                                        View Details
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Slide 5 -->
                    <div class="flex-none w-full md:w-1/2 lg:w-1/3 px-4">
                        <div class="group relative overflow-hidden rounded-2xl bg-white shadow-lg hover:shadow-2xl transition-all duration-300">
                            <div class="aspect-square bg-gradient-to-br from-indigo-500 to-blue-600 relative">
                                <div class="absolute inset-0 flex items-center justify-center">
                                    <svg class="w-24 h-24 text-white" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </div>
                                <div class="absolute top-4 left-4 bg-green-500 text-white px-3 py-1 rounded-full text-sm font-medium">
                                    Smart
                                </div>
                            </div>
                            <div class="p-6">
                                <h3 class="text-xl font-bold text-gray-900 mb-2">iPad Pro 12.9"</h3>
                                <p class="text-gray-600 mb-4">M2 chip, Liquid Retina XDR, Apple Pencil Pro</p>
                                <div class="flex items-center justify-between">
                                    <span class="text-2xl font-bold text-indigo-600">₦899,000</span>
                                    <button class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition-colors">
                                        View Details
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Slide 6 -->
                    <div class="flex-none w-full md:w-1/2 lg:w-1/3 px-4">
                        <div class="group relative overflow-hidden rounded-2xl bg-white shadow-lg hover:shadow-2xl transition-all duration-300">
                            <div class="aspect-square bg-gradient-to-br from-yellow-500 to-orange-500 relative">
                                <div class="absolute inset-0 flex items-center justify-center">
                                    <svg class="w-24 h-24 text-white" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M2 18C2 16.4596 2 15.6893 2.34673 15.1235C2.54074 14.8069 2.80693 14.5407 3.12353 14.3467C3.68934 14 4.45956 14 6 14C7.54044 14 8.31066 14 8.87647 14.3467C9.19307 14.5407 9.45926 14.8069 9.65327 15.1235C10 15.6893 10 16.4596 10 18C10 19.5404 10 20.3107 9.65327 20.8765C9.45926 21.1931 9.19307 21.4593 8.87647 21.6533C8.31066 22 7.54044 22 6 22C4.45956 22 3.68934 22 3.12353 21.6533C2.80693 21.4593 2.54074 21.1931 2.34673 20.8765C2 20.3107 2 19.5404 2 18Z" stroke="currentColor" stroke-width="2"/>
                                        <path d="M14 18C14 16.4596 14 15.6893 14.3467 15.1235C14.5407 14.8069 14.8069 14.5407 15.1235 14.3467C15.6893 14 16.4596 14 18 14C19.5404 14 20.3107 14 20.8765 14.3467C21.1931 14.5407 21.4593 14.8069 21.6533 15.1235C22 15.6893 22 16.4596 22 18C22 19.5404 22 20.3107 21.6533 20.8765C21.4593 21.1931 21.1931 21.4593 20.8765 21.6533C20.3107 22 19.5404 22 18 22C16.4596 22 15.6893 22 15.1235 21.6533C14.8069 21.4593 14.5407 21.1931 14.3467 20.8765C14 20.3107 14 19.5404 14 18Z" stroke="currentColor" stroke-width="2"/>
                                        <path d="M6 2V10C6 11.4142 7.58579 13 9 13H15C16.4142 13 18 11.4142 18 10V2" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </div>
                                <div class="absolute top-4 left-4 bg-blue-500 text-white px-3 py-1 rounded-full text-sm font-medium">
                                    Audio
                                </div>
                            </div>
                            <div class="p-6">
                                <h3 class="text-xl font-bold text-gray-900 mb-2">Sony WH-1000XM5</h3>
                                <p class="text-gray-600 mb-4">Industry-leading noise cancellation</p>
                                <div class="flex items-center justify-between">
                                    <span class="text-2xl font-bold text-yellow-600">₦299,000</span>
                                    <button class="bg-yellow-600 text-white px-4 py-2 rounded-lg hover:bg-yellow-700 transition-colors">
                                        View Details
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Navigation Buttons -->
                <button
                    @click="prevSlide()"
                    class="absolute left-4 top-1/2 transform -translate-y-1/2 bg-white/90 hover:bg-white text-gray-800 p-3 rounded-full shadow-lg transition-all duration-200 hover:scale-110"
                >
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </button>

                <button
                    @click="nextSlide()"
                    class="absolute right-4 top-1/2 transform -translate-y-1/2 bg-white/90 hover:bg-white text-gray-800 p-3 rounded-full shadow-lg transition-all duration-200 hover:scale-110"
                >
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </button>

                <!-- Dots Indicator -->
                <div class="flex justify-center mt-8 space-x-2">
                    <template x-for="(slide, index) in totalSlides" :key="index">
                        <button
                            @click="goToSlide(index)"
                            :class="currentSlide === index ? 'bg-blue-600' : 'bg-gray-300'"
                            class="w-3 h-3 rounded-full transition-colors duration-200"
                        ></button>
                    </template>
                </div>
            </div>

            <div class="text-center mt-12">
                <a href="#products" class="bg-blue-600 text-white px-8 py-4 rounded-lg font-semibold text-lg hover:bg-blue-700 transition-colors inline-flex items-center gap-2">
                    Explore All Products
                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M8.5 5L15.5 12L8.5 19" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </a>
            </div>
        </div>
    </section> --}}

    <script>
        function countdown() {
            return {
                timeLeft: '23:45:12',
                init() {
                    // Simple countdown timer
                    setInterval(() => {
                        // This would be calculated based on actual end time
                        // For demo purposes, keeping it static
                    }, 1000);
                }
            }
        }

        // function gadgetCarousel() {
        //     return {
        //         currentSlide: 0,
        //         slidesToShow: window.innerWidth >= 1024 ? 3 : window.innerWidth >= 768 ? 2 : 1,
        //         totalSlides: 2, // 6 slides total, showing 3 at a time = 2 groups

        //         init() {
        //             this.updateSlidesToShow();
        //             window.addEventListener('resize', () => {
        //                 this.updateSlidesToShow();
        //             });

        //             // Auto-play functionality
        //             setInterval(() => {
        //                 this.nextSlide();
        //             }, 5000);
        //         },

        //         updateSlidesToShow() {
        //             if (window.innerWidth >= 1024) {
        //                 this.slidesToShow = 3;
        //                 this.totalSlides = 2; // 6 slides / 3 = 2 groups
        //             } else if (window.innerWidth >= 768) {
        //                 this.slidesToShow = 2;
        //                 this.totalSlides = 3; // 6 slides / 2 = 3 groups
        //             } else {
        //                 this.slidesToShow = 1;
        //                 this.totalSlides = 6; // 6 slides / 1 = 6 groups
        //             }
        //         },

        //         nextSlide() {
        //             this.currentSlide = (this.currentSlide + 1) % this.totalSlides;
        //         },

        //         prevSlide() {
        //             this.currentSlide = this.currentSlide === 0 ? this.totalSlides - 1 : this.currentSlide - 1;
        //         },

        //         goToSlide(slideIndex) {
        //             this.currentSlide = slideIndex;
        //         }
        //     }
        // }
    </script>
</x-layout>
