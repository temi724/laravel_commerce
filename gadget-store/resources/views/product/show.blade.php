<x-layout>
    <x-slot name="title">{{ $product->product_name }} - Gadget Store</x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Breadcrumb -->
        <nav class="mb-8">
            <ol class="flex items-center space-x-2 text-sm text-gray-500">
                <li><a href="/" class="hover:text-blue-600">Home</a></li>
                <li><span>/</span></li>
                @if($type === 'product' && $product->category)
                    <li><a href="/?category={{ $product->category->id }}" class="hover:text-blue-600">{{ $product->category->name }}</a></li>
                    <li><span>/</span></li>
                @elseif($type === 'deal')
                    <li><a href="#deals" class="hover:text-blue-600">Flash Deals</a></li>
                    <li><span>/</span></li>
                @endif
                <li class="text-gray-900">{{ $product->product_name }}</li>
            </ol>
        </nav>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 lg:gap-12 xl:gap-16">
            <!-- Product Images Section -->
            <div class="lg:sticky lg:top-8">
                <div x-data="{ currentImage: 0 }" class="space-y-4">
                    <!-- Main Image Display -->
                    <div class="aspect-square bg-white rounded-2xl border border-gray-200 overflow-hidden">
                        @if($product->images_url && count($product->images_url) > 0)
                            @foreach($product->images_url as $index => $image)
                                <img
                                    x-show="currentImage === {{ $index }}"
                                    x-transition:enter="transition ease-out duration-300"
                                    x-transition:enter-start="opacity-0 scale-95"
                                    x-transition:enter-end="opacity-100 scale-100"
                                    src="{{ $image }}"
                                    alt="{{ $product->product_name }}"
                                    class="w-full h-full object-contain p-4 sm:p-8 cursor-zoom-in"
                                    onerror="this.onerror=null; this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNDAwIiBoZWlnaHQ9IjQwMCIgdmlld0JveD0iMCAwIDQwMCA0MDAiIGZpbGw9Im5vbmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+CjxyZWN0IHdpZHRoPSI0MDAiIGhlaWdodD0iNDAwIiBmaWxsPSIjRjNGNEY2Ii8+CjxwYXRoIGQ9Ik0xNzUgMTUwSDE1MFYxNzVIMTI1VjE1MEgxMDBWMjUwSDEyNVYyMjVIMTUwVjI1MEgxNzVWMjI1SDIwMFYyNTBIMjI1VjIyNUgyNTBWMjAwSDI3NVYxNzVIMjUwVjE1MEgyMjVWMTI1SDIwMFYxNTBIMTc1WiIgZmlsbD0iIzlDQTNBRiIvPgo8L3N2Zz4K'; this.classList.add('opacity-50');"
                                >
                            @endforeach
                        @else
                            <div class="w-full h-full flex items-center justify-center bg-gray-50">
                                <div class="text-center">
                                    <svg class="w-12 h-12 sm:w-16 sm:h-16 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    <p class="text-gray-400 text-sm font-medium">No image available</p>
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Image Thumbnails -->
                    @if($product->images_url && count($product->images_url) > 1)
                        <div class="flex gap-2 sm:gap-3 overflow-x-auto pb-1">
                            @foreach($product->images_url as $index => $image)
                                <button
                                    @click="currentImage = {{ $index }}"
                                    :class="currentImage === {{ $index }} ? 'border-blue-500 ring-2 ring-blue-100' : 'border-gray-200 hover:border-gray-300'"
                                    class="flex-shrink-0 w-12 h-12 bg-white rounded-lg border-2 overflow-hidden transition-all duration-200"
                                >
                                    <img src="{{ $image }}" alt="{{ $product->product_name }} thumbnail" class="w-full h-full object-contain p-1">
                                </button>
                            @endforeach
                        </div>
                    @endif

                    <!-- Image Controls -->
                    @if($product->images_url && count($product->images_url) > 0)
                        <div class="flex gap-2">
                            <button class="flex-1 py-2 sm:py-2.5 px-3 sm:px-4 text-blue-600 hover:text-blue-700 text-xs sm:text-sm font-medium border border-blue-200 rounded-lg hover:bg-blue-50 transition-colors">
                                <svg class="w-3 h-3 sm:w-4 sm:h-4 inline-block mr-1 sm:mr-2" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M11.5 21C16.7467 21 21 16.7467 21 11.5C21 6.25329 16.7467 2 11.5 2C6.25329 2 2 6.25329 2 11.5C2 16.7467 6.25329 21 11.5 21Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M22 22L20 20" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M15.5 11.5H15.5093" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M11.5 7.5V7.5093" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M7.5 11.5H7.5093" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M11.5 15.5V15.5093" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                Zoom
                            </button>
                            <button class="flex-1 py-2 sm:py-2.5 px-3 sm:px-4 text-gray-600 hover:text-gray-700 text-xs sm:text-sm font-medium border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                                <svg class="w-3 h-3 sm:w-4 sm:h-4 inline-block mr-1 sm:mr-2" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M8.5 12L17.5 12M17.5 12L14.5 15M17.5 12L14.5 9" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M2.5 12C2.5 7.52166 2.5 5.28249 3.89124 3.89124C5.28249 2.5 7.52166 2.5 12 2.5C16.4783 2.5 18.7175 2.5 20.1088 3.89124C21.5 5.28249 21.5 7.52166 21.5 12C21.5 16.4783 21.5 18.7175 20.1088 20.1088C18.7175 21.5 16.4783 21.5 12 21.5C7.52166 21.5 5.28249 21.5 3.89124 20.1088C2.5 18.7175 2.5 16.4783 2.5 12Z" stroke="currentColor" stroke-width="1.5"/>
                                </svg>
                                Share
                            </button>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Product Info Section -->
            <div class="space-y-4 lg:space-y-6">
                <!-- Product Title & Rating -->
                <div class="space-y-3">
                    <div class="flex items-center space-x-2 text-sm text-gray-500 mb-2">
                        <span>Brand:</span>
                        <span class="font-medium text-blue-600">{{ explode(' ', $product->product_name)[0] ?? 'Generic' }}</span>
                        <span>•</span>
                        <span>Model: {{ $product->id }}</span>
                        <span class="hidden sm:inline">•</span>
                        <span class="hidden sm:inline">Web Code: {{ substr($product->id, -8) }}</span>
                    </div>

                    <h1 class="text-2xl lg:text-3xl font-bold text-gray-900 mb-3">{{ $product->product_name }}</h1>

                    <!-- Rating -->
                    <div class="flex items-center space-x-2 mb-4">
                        <div class="flex items-center">
                            @for($i = 1; $i <= 5; $i++)
                                <svg class="w-5 h-5 {{ $i <= 4 ? 'text-yellow-400' : 'text-gray-300' }}" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M9.15316 5.40838C10.4198 3.13613 11.0531 2 12 2C12.9469 2 13.5802 3.13612 14.8468 5.40837L15.1745 5.99623C15.5345 6.64193 15.7144 6.96479 15.9951 7.17781C16.2757 7.39083 16.6251 7.4699 17.3241 7.62805L17.9605 7.77203C20.4201 8.32856 21.65 8.60682 21.9426 9.54773C22.2352 10.4886 21.3968 11.4691 19.7199 13.4299L19.2861 13.9372C18.8096 14.4944 18.5713 14.773 18.4641 15.1177C18.357 15.4624 18.393 15.8341 18.465 16.5776L18.5306 17.2544C18.7841 19.8706 18.9109 21.1787 18.1449 21.7602C17.3788 22.3417 16.2273 21.8115 13.9243 20.7512L13.3285 20.4768C12.6741 20.1755 12.3469 20.0248 12 20.0248C11.6531 20.0248 11.3259 20.1755 10.6715 20.4768L10.0757 20.7512C7.77268 21.8115 6.62118 22.3417 5.85515 21.7602C5.08912 21.1787 5.21588 19.8706 5.4694 17.2544L5.53498 16.5776C5.60703 15.8341 5.64305 15.4624 5.53586 15.1177C5.42868 14.773 5.19043 14.4944 4.71392 13.9372L4.2801 13.4299C2.60325 11.4691 1.76482 10.4886 2.05742 9.54773C2.35002 8.60682 3.57986 8.32856 6.03954 7.77203L6.67589 7.62805C7.37485 7.4699 7.72433 7.39083 8.00494 7.17781C8.28555 6.96479 8.46553 6.64194 8.82547 5.99623L9.15316 5.40838Z"/>
                                </svg>
                            @endfor
                        </div>
                        <span class="text-sm text-gray-600">4.1</span>
                        <span class="text-sm text-blue-600 hover:underline cursor-pointer">({{ is_array($product->reviews) ? count($product->reviews) : ($product->reviews ?? 14) }} Reviews)</span>
                    </div>

                    @if($type === 'product' && $product->category)
                        <p class="text-sm text-gray-500">Category:
                            <a href="/?category={{ $product->category->id }}" class="text-blue-600 hover:underline">{{ $product->category->name }}</a>
                        </p>
                    @elseif($type === 'deal')
                        <p class="text-sm text-gray-500">Category: <span class="text-blue-600">Flash Deal</span></p>
                    @endif
                </div>

                <!-- Pricing Section -->
                <div class="bg-gradient-to-r from-gray-50 to-white border border-gray-200 rounded-xl p-6">
                    <div class="flex flex-wrap items-baseline gap-2 sm:gap-3">
                        <span id="current-price" class="text-2xl sm:text-3xl font-bold text-red-600">₦{{ number_format($product->display_price, 2) }}</span>
                        @if($type === 'deal' && $product->old_price && $product->old_price > $product->price)
                            <span class="text-base sm:text-lg text-gray-500 line-through">₦{{ number_format($product->old_price, 2) }}</span>
                            <span class="bg-red-100 text-red-800 text-xs sm:text-sm font-medium px-1.5 sm:px-2 py-1 rounded">SAVE ₦{{ number_format($product->old_price - $product->price, 2) }}</span>
                        @elseif($type === 'product' && $product->display_price > 500)
                            <span id="old-price" class="text-base sm:text-lg text-gray-500 line-through">₦{{ number_format($product->display_price * 1.2, 2) }}</span>
                            <span id="savings" class="bg-red-100 text-red-800 text-xs sm:text-sm font-medium px-1.5 sm:px-2 py-1 rounded">SAVE ₦{{ number_format($product->display_price * 0.2, 2) }}</span>
                        @endif
                    </div>
                    @if($type === 'deal')
                        <p class="text-sm text-gray-600 mt-1">⚡ Flash Deal - Limited time offer!</p>
                    @elseif($product->display_price > 500)
                        <p class="text-sm text-gray-600 mt-1">Sale ends: September 11, 2025</p>
                    @endif
                </div>

                <!-- Color Selection -->
                @if($product->colors && is_array($product->colors) && count($product->colors) > 0)
                    @php
                        $firstColorRaw = $product->colors[0];
                        $initialColorName = is_array($firstColorRaw)
                            ? ($firstColorRaw['name'] ?? (is_string(reset($firstColorRaw)) ? reset($firstColorRaw) : ''))
                            : $firstColorRaw;
                    @endphp
                    <div x-data="{ selectedColor: '{{ addslashes($initialColorName) }}' }">
                        <h3 class="text-lg font-semibold text-gray-900 mb-3">Colour: <span x-text="selectedColor" class="capitalize"></span></h3>
                        <div class="flex flex-wrap gap-3">
                            @foreach($product->colors as $color)
                                @php
                                    $colorName = is_array($color) ? ($color['name'] ?? (is_string(reset($color)) ? reset($color) : '')) : $color;
                                    $lower = strtolower($colorName);
                                    $swatch = match($lower) {
                                        'midnight' => '#000000',
                                        'starlight' => '#f9f9f9',
                                        'blue' => '#007AFF',
                                        'purple' => '#AF52DE',
                                        'pink' => '#FF2D92',
                                        'red' => '#FF3B30',
                                        'orange' => '#FF8C00',
                                        'yellow' => '#FFD700',
                                        'green' => '#32D74B',
                                        'black' => '#000000',
                                        'white' => '#FFFFFF',
                                        'gray' => '#8E8E93',
                                        'grey' => '#8E8E93',
                                        'silver' => '#C0C0C0',
                                        'gold' => '#FFD700',
                                        'rose' => '#FF69B4',
                                        'cyan' => '#00FFFF',
                                        'navy' => '#000080',
                                        'brown' => '#8B4513',
                                        'lime' => '#32CD32',
                                        default => '#' . substr(md5($colorName), 0, 6),
                                    };
                                @endphp
                                <button
                                    @click="selectedColor = '{{ addslashes($colorName) }}'"
                                    :class="selectedColor === '{{ addslashes($colorName) }}' ? 'ring-2 ring-blue-500 border-blue-500' : 'border-gray-300 hover:border-gray-400'"
                                    class="flex items-center space-x-2 px-4 py-2 border-2 rounded-lg transition-all duration-200"
                                >
                                    <div class="w-6 h-6 rounded-full border border-gray-200" style="background-color: {{ $swatch }}"></div>
                                    <span class="text-sm font-medium capitalize">{{ $colorName }}</span>
                                </button>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Storage Options -->
                @if(!empty($product->storage_options))
                    <div x-data="{
                        selectedStorage: '{{ $product->default_storage }}',
                        selectedPrice: {{ $product->display_price }},
                        storageOptions: @js($product->storage_options),
                        updatePrice(storage, price) {
                            this.selectedStorage = storage;
                            this.selectedPrice = price;
                            document.getElementById('current-price').textContent = '₦' + price.toLocaleString('en-NG', {minimumFractionDigits: 2});
                            const oldPriceElement = document.getElementById('old-price');
                            const savingsElement = document.getElementById('savings');
                            if (oldPriceElement) {
                                oldPriceElement.textContent = '₦' + (price * 1.2).toLocaleString('en-NG', {minimumFractionDigits: 2});
                            }
                            if (savingsElement) {
                                savingsElement.textContent = 'SAVE ₦' + (price * 0.2).toLocaleString('en-NG', {minimumFractionDigits: 2});
                            }
                        }
                    }">
                        <h3 class="text-lg font-semibold text-gray-900 mb-3">Storage: <span x-text="selectedStorage"></span></h3>
                        <div class="flex flex-wrap gap-3">
                            @foreach($product->storage_options as $storageOption)
                                <button
                                    @click="updatePrice('{{ $storageOption['storage'] }}', {{ $storageOption['price'] }})"
                                    :class="selectedStorage === '{{ $storageOption['storage'] }}' ? 'border-blue-500 bg-blue-50 text-blue-700 ring-2 ring-blue-200' : 'border-gray-300 hover:border-gray-400'"
                                    class="px-4 py-3 border-2 rounded-lg transition-all duration-200">
                                    <div class="text-center">
                                        <div class="text-sm font-medium">{{ $storageOption['storage'] }}</div>
                                        <div class="text-xs text-green-600 mt-1">₦{{ number_format($storageOption['price'], 0) }}</div>
                                    </div>
                                </button>
                            @endforeach
                        </div>
                        <input type="hidden" id="selected-storage" x-model="selectedStorage" />
                        <input type="hidden" id="selected-storage-price" x-model="selectedPrice" />
                    </div>
                @endif

                <!-- Stock Status -->
                <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                    <div class="flex items-center space-x-2">
                        <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                        <span class="text-sm font-medium text-green-700">{{ $product->in_stock ? 'In Stock' : 'Limited Stock' }}</span>
                    </div>
                    <div class="text-xs text-gray-500">
                        Ships in 1-2 business days
                    </div>
                </div>

                <!-- Purchase Options -->
                <div class="bg-white border border-gray-200 rounded-2xl p-4 sm:p-6">
                    <!-- Add to Cart Section -->
                    <div class="space-y-4 mb-6">
                            <div class="flex flex-col sm:flex-row gap-3">
                            <button onclick="
                                const selectedStorage = document.getElementById('selected-storage')?.value || null;
                                const selectedPrice = document.getElementById('selected-storage-price')?.value || {{ $product->display_price }};
                                if (window.Livewire) {
                                    Livewire.dispatch('addToCart', ['{{ $product->id }}', 1, '{{ $type }}', selectedStorage, selectedPrice]);
                                }
                            " class="flex-1 bg-blue-600 text-white px-4 sm:px-6 py-3 sm:py-4 rounded-xl font-semibold text-base sm:text-lg hover:bg-blue-700 active:bg-blue-800 transition-all duration-200 transform hover:scale-[1.02] active:scale-[0.98]">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5 inline-block mr-2" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M3.74157 18.5545C4.94119 20 7.17389 20 11.6393 20H12.3605C16.8259 20 19.0586 20 20.2582 18.5545M3.74157 18.5545C2.54194 17.1091 2.9534 14.9146 3.77633 10.5257C4.36155 7.40452 4.65416 5.84393 5.76506 4.92196M3.74157 18.5545L5.76506 4.92196M20.2582 18.5545C21.4578 17.1091 21.0464 14.9146 20.2235 10.5257C19.6382 7.40452 19.3456 5.84393 18.2347 4.92196M20.2582 18.5545L18.2347 4.92196M18.2347 4.92196C17.1238 4 15.5361 4 12.3605 4H11.6393C8.46374 4 6.87596 4 5.76506 4.92196" stroke="currentColor" stroke-width="1.5"/>
                                    <circle cx="9" cy="19.5" r="1.5" stroke="currentColor" stroke-width="1.5"/>
                                    <circle cx="15" cy="19.5" r="1.5" stroke="currentColor" stroke-width="1.5"/>
                                </svg>
                                Add to Cart
                            </button>
                            <button class="p-3 sm:p-4 border-2 border-gray-200 text-gray-600 rounded-xl font-semibold hover:bg-gray-50 hover:border-gray-300 transition-all duration-200 sm:flex-shrink-0">
                                <svg class="w-5 h-5 mx-auto sm:mx-0" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M2 9.1371C2 14 6.01943 16.5914 8.96173 18.9109C10 19.7294 11 20.5 12 20.5C13 20.5 14 19.7294 15.0383 18.9109C17.9806 16.5914 22 14 22 9.1371C22 4.27416 16.4998 0.825464 12 5.50063C7.50016 0.825464 2 4.27416 2 9.1371Z" stroke="currentColor" stroke-width="1.5"/>
                                </svg>
                            </button>
                        </div>

                        <!-- Quick Actions -->
                        {{-- <div class="grid grid-cols-2 gap-3">
                            <button class="py-3 px-4 bg-gray-50 text-gray-700 rounded-lg font-medium text-sm hover:bg-gray-100 transition-colors">
                                <svg class="w-4 h-4 inline-block mr-2" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M11.1004 3.00208C8.45025 2.88133 6.34009 2.62947 4.71799 3.49302C3.5479 4.08862 2.88872 5.54745 2.62946 6.03249C2.00009 7.50009 2.00009 9.50009 2.00009 13.5001C2.00009 17.5001 2.00009 19.5001 2.62946 20.9677C3.26074 22.4387 4.56151 23.7394 6.03249 24.3707C7.50009 25.0001 9.50009 25.0001 13.5001 25.0001C17.5001 25.0001 19.5001 25.0001 20.9677 24.3707C22.4387 23.7394 23.7394 22.4387 24.3707 20.9677C25.0001 19.5001 25.0001 17.5001 25.0001 13.5001C25.0001 9.50009 25.0001 7.50009 24.3707 6.03249C23.7394 4.56151 22.4387 3.26074 20.9677 2.62946C19.8338 2.14756 18.4194 2.01741 16.5001 2.00208" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                                    <path d="M8 12L16 12M16 12L13 15M16 12L13 9" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                Buy Now
                            </button>
                            <button class="py-3 px-4 bg-gray-50 text-gray-700 rounded-lg font-medium text-sm hover:bg-gray-100 transition-colors">
                                <svg class="w-4 h-4 inline-block mr-2" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M9 15L15 9M15 9H10.5M15 9V13.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M2.5 12C2.5 7.52166 2.5 5.28249 3.89124 3.89124C5.28249 2.5 7.52166 2.5 12 2.5C16.4783 2.5 18.7175 2.5 20.1088 3.89124C21.5 5.28249 21.5 7.52166 21.5 12C21.5 16.4783 21.5 18.7175 20.1088 20.1088C18.7175 21.5 16.4783 21.5 12 21.5C7.52166 21.5 5.28249 21.5 3.89124 20.1088C2.5 18.7175 2.5 16.4783 2.5 12Z" stroke="currentColor" stroke-width="1.5"/>
                                </svg>
                                Compare
                            </button>
                        </div> --}}
                    </div>

                    <!-- Benefits Section -->
                    <div class="border-t border-gray-100 pt-4">
                        <div class="space-y-3 text-sm">
                            <div class="flex items-center gap-3 text-blue-700">
                                <div class="w-5 h-5 bg-blue-100 rounded-full flex items-center justify-center">
                                    <svg class="w-3 h-3" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="1.5"/>
                                        <path d="M12 8V12L14.5 14.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </div>
                                <span class="font-medium">Quick and easy store pickup available</span>
                            </div>
                            <div class="flex items-center gap-3 text-purple-700">
                                <div class="w-5 h-5 bg-purple-100 rounded-full flex items-center justify-center">
                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4zM18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z"></path>
                                    </svg>
                                </div>
                                <span class="font-medium">Secure payment & easy returns</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Key Features -->
                @if($product->overview)
                    <div class="bg-blue-50 border border-blue-100 rounded-xl p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-3">Product Overview</h3>
                        <p class="text-gray-700 leading-relaxed">{{ $product->overview }}</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Product Details Tabs -->
        <div class="mt-16 bg-white rounded-xl border border-gray-200 overflow-hidden" x-data="{ activeTab: 'about' }">
            <div class="border-b border-gray-200 bg-gray-50 px-6">
                <nav class="flex space-x-8">
                    <button
                        @click="activeTab = 'about'"
                        :class="activeTab === 'about' ? 'border-blue-500 text-blue-600 bg-white' : 'border-transparent text-gray-500 hover:text-gray-700'"
                        class="whitespace-nowrap py-4 px-4 border-b-2 font-medium text-sm transition-all duration-200 -mb-px">
                        About This Product
                    </button>
                    <button
                        @click="activeTab = 'specs'"
                        :class="activeTab === 'specs' ? 'border-blue-500 text-blue-600 bg-white' : 'border-transparent text-gray-500 hover:text-gray-700'"
                        class="whitespace-nowrap py-4 px-4 border-b-2 font-medium text-sm transition-all duration-200 -mb-px">
                        Specifications
                    </button>
                    <button
                        @click="activeTab = 'reviews'"
                        :class="activeTab === 'reviews' ? 'border-blue-500 text-blue-600 bg-white' : 'border-transparent text-gray-500 hover:text-gray-700'"
                        class="whitespace-nowrap py-4 px-4 border-b-2 font-medium text-sm transition-all duration-200 -mb-px">
                        Customer Reviews
                    </button>
                </nav>
            </div>

            <!-- Tab Content -->
                        <!-- Tab Content -->
            <div class="p-6 min-h-[400px]">
                <!-- About This Product Tab -->
                <div x-show="activeTab === 'about'" class="space-y-6">
                    @if($product->what_is_included)
                        <div>
                            <h3 class="text-xl font-semibold text-gray-900 mb-4">What's included:</h3>
                            <div class="bg-gray-50 p-4 rounded-lg">
                                {!! is_array($product->what_is_included) ? nl2br(e(implode('
', $product->what_is_included))) : nl2br(e($product->what_is_included)) !!}
                            </div>
                        </div>
                    @endif

                    @if($product->description)
                        <div>
                            <h3 class="text-xl font-semibold text-gray-900 mb-4">Product Description</h3>
                            <div class="prose prose-lg max-w-none text-gray-700">
                                <p>{{ $product->description }}</p>
                            </div>
                        </div>
                    @endif

                    @if($product->about)
                        <div>
                            <h3 class="text-xl font-semibold text-gray-900 mb-4">Key Features</h3>
                            <div class="prose prose-lg max-w-none text-gray-700">
                                <div class="space-y-3">
                                    @foreach(explode('.', $product->about) as $feature)
                                        @if(trim($feature))
                                            <div class="flex items-start space-x-3">
                                                <div class="w-2 h-2 bg-blue-600 rounded-full mt-2 flex-shrink-0"></div>
                                                <p>{{ trim($feature) }}.</p>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- How It Works Section -->
                    @if(stripos($product->product_name, 'Phone') !== false || stripos($product->product_name, 'iPhone') !== false)
                        <div>
                            <h3 class="text-xl font-semibold text-gray-900 mb-4">How do unlocked phones work?</h3>
                            <div class="bg-blue-50 p-6 rounded-lg">
                                <p class="text-gray-700">
                                    Purchasing an unlocked handset gives you more handset options to choose from and more flexibility as to where you use it.
                                    Because an unlocked handset isn't tied to a particular service provider, it can be used with any service provider in
                                    the world that operates on a SIM card-based GSM network.
                                </p>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Specifications Tab -->
                <div x-show="activeTab === 'specs'" class="space-y-6">
                    @if($product->specification && is_array($product->specification))
                        @foreach($product->specification as $category => $specs)
                            @if(is_array($specs))
                                <div class="border-b border-gray-100 pb-6 last:border-b-0">
                                    <h3 class="text-xl font-semibold text-gray-900 mb-4 capitalize">{{ $category }}</h3>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        @foreach($specs as $key => $value)
                                            <div class="flex justify-between items-start py-2">
                                                <span class="text-gray-600 font-medium capitalize">{{ str_replace('_', ' ', $key) }}:</span>
                                                <span class="text-gray-900 text-right">
                                                    @if(is_array($value))
                                                        {{ implode(', ', $value) }}
                                                    @elseif(is_bool($value))
                                                        {{ $value ? 'Yes' : 'No' }}
                                                    @else
                                                        {{ $value }}
                                                    @endif
                                                </span>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @else
                                <div class="border-b border-gray-100 pb-6 last:border-b-0">
                                    <div class="flex justify-between items-start py-2">
                                        <span class="text-gray-600 font-medium capitalize">{{ str_replace('_', ' ', $category) }}:</span>
                                        <span class="text-gray-900 text-right">
                                            @if(is_bool($specs))
                                                {{ $specs ? 'Yes' : 'No' }}
                                            @else
                                                {{ $specs }}
                                            @endif
                                        </span>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    @else
                        <div class="text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">No specifications available</h3>
                            <p class="mt-1 text-sm text-gray-500">Specifications for this product are not available at the moment.</p>
                        </div>
                    @endif
                </div>

                <!-- Customer Reviews Tab -->
                <div x-show="activeTab === 'reviews'" class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        <!-- Rating Summary -->
                        <div class="bg-gray-50 p-6 rounded-lg text-center">
                            <div class="text-4xl font-bold text-gray-900 mb-2">4.1</div>
                            <div class="flex justify-center mb-2">
                                @for($i = 1; $i <= 5; $i++)
                                    <svg class="w-5 h-5 {{ $i <= 4 ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                    </svg>
                                @endfor
                            </div>
                            <p class="text-sm text-gray-600">({{ is_array($product->reviews) ? count($product->reviews) : ($product->reviews ?? 14) }} Reviews)</p>
                        </div>

                        <!-- Rating Breakdown -->
                        <div class="md:col-span-2 space-y-3">
                            @php
                                $ratingBreakdown = [
                                    5 => 65,
                                    4 => 20,
                                    3 => 10,
                                    2 => 3,
                                    1 => 2
                                ];
                            @endphp

                            @foreach($ratingBreakdown as $stars => $percentage)
                                <div class="flex items-center space-x-3">
                                    <span class="text-sm text-gray-600 w-12">{{ $stars }} stars</span>
                                    <div class="flex-1 bg-gray-200 rounded-full h-2">
                                        <div class="bg-yellow-400 h-2 rounded-full" style="width: {{ $percentage }}%"></div>
                                    </div>
                                    <span class="text-sm text-gray-600 w-12">{{ $percentage }}%</span>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Sample Reviews -->
                    <div class="space-y-6">
                        <div class="border-b border-gray-200 pb-6">
                            <div class="flex items-center space-x-4 mb-3">
                                <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                    <span class="text-blue-600 font-semibold text-sm">JD</span>
                                </div>
                                <div>
                                    <div class="flex items-center space-x-2">
                                        <span class="font-medium text-gray-900">John D.</span>
                                        <div class="flex">
                                            @for($i = 1; $i <= 5; $i++)
                                                <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                                </svg>
                                            @endfor
                                        </div>
                                    </div>
                                    <p class="text-sm text-gray-600">2 days ago</p>
                                </div>
                            </div>
                            <p class="text-gray-700">Excellent product! Works exactly as advertised. Great build quality and fast delivery. Would definitely recommend to others.</p>
                            <div class="mt-3 text-sm text-gray-600">
                                <span>Was this helpful?</span>
                                <button class="ml-2 text-blue-600 hover:underline">Yes (12)</button>
                                <button class="ml-2 text-blue-600 hover:underline">No (1)</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Related Products Section -->
        <div class="mt-20">
            <div class="flex items-center justify-between mb-8">
                <h2 class="text-2xl font-bold text-gray-900">Products we think you'll love</h2>
                <a href="/" class="text-sm text-blue-600 hover:text-blue-700 font-medium transition-colors">View all products</a>
            </div>
            @php
                $relatedProducts = \App\Models\Product::where('category_id', $product->category_id)
                    ->where('id', '!=', $product->id)
                    ->inRandomOrder()
                    ->limit(8)
                    ->get();
            @endphp
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach($relatedProducts as $relatedProduct)
                    <div class="bg-white rounded-lg border border-gray-100 hover:border-gray-200 transition-colors duration-200 group">
                        <a href="{{ route('product.show', $relatedProduct->id) }}" class="block">
                            <div class="aspect-square bg-gray-100 rounded-t-lg relative overflow-hidden">
                                @if($relatedProduct->images_url && count($relatedProduct->images_url) > 0)
                                    <img
                                        src="{{ $relatedProduct->images_url[0] }}"
                                        alt="{{ $relatedProduct->product_name }}"
                                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                                        onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';"
                                    >
                                    <div class="absolute inset-0 flex items-center justify-center" style="display: none;">
                                        <svg class="w-16 h-16 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                @else
                                    <div class="absolute inset-0 flex items-center justify-center">
                                        <svg class="w-16 h-16 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                @endif

                                @if(!$relatedProduct->in_stock)
                                    <div class="absolute top-3 left-3 bg-red-100 text-red-800 px-2 py-1 rounded-md text-xs font-medium">Out of Stock</div>
                                @else
                                    <div class="absolute top-3 left-3 bg-green-100 text-green-800 px-2 py-1 rounded-md text-xs font-medium">In Stock</div>
                                @endif
                            </div>
                            <div class="p-4">
                                @if($relatedProduct->category)
                                    <div class="text-[11px] uppercase tracking-wide text-blue-600 font-semibold mb-1">{{ $relatedProduct->category->name }}</div>
                                @endif
                                <h3 class="font-semibold text-gray-900 text-sm mb-2 line-clamp-2 leading-tight group-hover:text-blue-600 transition-colors">
                                    {{ $relatedProduct->product_name }}
                                </h3>
                                @if($relatedProduct->overview)
                                    <p class="text-xs text-gray-600 mb-3 line-clamp-2">{{ $relatedProduct->overview }}</p>
                                @endif
                                <div class="flex items-center justify-between">
                                    <div class="text-lg font-bold text-gray-900">₦{{ number_format($relatedProduct->price, 2) }}</div>
                                    @if($relatedProduct->in_stock)
                                        <button class="w-8 h-8 bg-blue-50 text-blue-600 rounded-full flex items-center justify-center hover:bg-blue-100 transition-colors group">
                                            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M2 3L2.26491 3.0883C3.58495 3.52832 4.24497 3.74832 4.62248 4.2721C5 4.79587 5 5.49159 5 6.88304V9.5C5 12.7875 5 14.4312 5.90796 15.5376C6.07418 15.7401 6.25989 15.9258 6.46243 16.092C7.56878 17 9.21252 17 12.5 17C15.7875 17 17.4312 17 18.5376 16.092C18.7401 15.9258 18.9258 15.7401 19.092 15.5376C20 14.4312 20 12.7875 20 9.5V8.5C20 7.09554 20 6.39331 19.6532 5.88886C19.3065 5.38441 18.6851 5.18885 17.4422 4.79773L12.5 3" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                                                <path d="M7.5 18C8.32843 18 9 18.6716 9 19.5C9 20.3284 8.32843 21 7.5 21C6.67157 21 6 20.3284 6 19.5C6 18.6716 6.67157 18 7.5 18Z" stroke="currentColor" stroke-width="1.5"/>
                                                <path d="M16.5 18.0001C17.3284 18.0001 18 18.6716 18 19.5001C18 20.3285 17.3284 21.0001 16.5 21.0001C15.6716 21.0001 15 20.3285 15 19.5001C15 18.6716 15.6716 18.0001 16.5 18.0001Z" stroke="currentColor" stroke-width="1.5"/>
                                            </svg>
                                        </button>
                                    @else
                                        <button disabled class="w-8 h-8 bg-gray-100 text-gray-400 rounded-full flex items-center justify-center cursor-not-allowed">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728L5.636 5.636m12.728 12.728L18.364 5.636M5.636 18.364l12.728-12.728"></path>
                                            </svg>
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-layout>
