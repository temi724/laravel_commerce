<div class="min-h-screen bg-gradient-to-br from-gray-50 to-blue-50 py-12 px-4 sm:px-6 lg:px-8">
    <style>
        .animate-fadeIn {
            animation: fadeIn 0.3s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .modal-overlay {
            backdrop-filter: blur(5px);
        }
    </style>
    <div class="max-w-7xl mx-auto">
        <!-- Beautiful Header Section -->
        <div class="text-center mb-16">
            {{-- <div class="inline-block p-2 bg-gradient-to-r from-blue-500 to-purple-600 rounded-2xl mb-6">
                <div class="bg-white rounded-xl p-4">
                    <svg class="w-12 h-12 text-blue-600 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                    </svg>
                </div>
            </div> --}}
            <h1 class="text-4xl md:text-5xl font-bold bg-gradient-to-r from-gray-900 to-blue-800 bg-clip-text text-transparent mb-4">
                Secure Checkout
            </h1>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto">Complete your purchase with confidence. Your information is protected with bank-level security.</p>
        </div>

        <form wire:submit.prevent="placeOrder">
            <!-- Display validation errors -->
            @if ($errors->any())
                <div class="mb-6 bg-red-50 border border-red-200 rounded-xl p-4">
                    <div class="flex">
                        <svg class="w-5 h-5 text-red-400 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                        </svg>
                        <div>
                            <h3 class="text-sm font-bold text-red-800">Please fix the following errors:</h3>
                            <ul class="text-sm text-red-700 mt-2 space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>• {{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Flash Messages -->
            @if (session()->has('message'))
                <div class="mb-6 bg-blue-50 border border-blue-200 rounded-xl p-4">
                    <div class="flex">
                        <svg class="w-5 h-5 text-blue-400 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div>
                            <p class="text-sm text-blue-700 font-medium">{{ session('message') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 xl:gap-12">
                <!-- Left side: Checkout Form -->
                <div class="lg:order-1">
                    <div class="bg-white backdrop-blur-sm rounded-3xl p-6 transition-all duration-300">
                        <div class="mb-6">
                            <h2 class="text-2xl font-bold text-gray-900 mb-2">
                                <span class="flex items-center">
                                    <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-purple-600 rounded-2xl flex items-center justify-center mr-3 shadow-lg">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                        </svg>
                                    </div>
                                    Shipping Information
                                </span>
                            </h2>
                            <p class="text-gray-600 ml-13">Enter your delivery details below</p>
                            <div class="mt-3 ml-13 w-24 h-1 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full"></div>
                        </div>

                        <div class="grid grid-cols-1 gap-4">
                            <div class="space-y-1">
                                <label for="username" class="block text-xs font-bold text-gray-800 uppercase tracking-wider">
                                    Username *
                                </label>
                                <input type="text" id="username" wire:model.defer="username"
                                       class="w-full px-4 py-3 text-base border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition-all duration-300 bg-gray-50/50 focus:bg-white hover:border-gray-300 hover:shadow-md"
                                       placeholder="Enter username" required>
                            </div>
                            <div class="space-y-1">
                                <label for="email" class="block text-xs font-bold text-gray-800 uppercase tracking-wider">
                                    Email Address *
                                </label>
                                <input type="email" id="email" wire:model.defer="email"
                                       class="w-full px-4 py-3 text-base border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition-all duration-300 bg-gray-50/50 focus:bg-white hover:border-gray-300 hover:shadow-md"
                                       placeholder="your@email.com" required>
                            </div>

                            <!-- Delivery Options -->
                            <div class="space-y-1">
                                <label class="block text-xs font-bold text-gray-800 uppercase tracking-wider">
                                    Delivery Option *
                                </label>
                                <div class="grid grid-cols-2 gap-3">
                                    <button type="button"
                                            wire:click="$set('deliveryOption', 'pickup')"
                                            class="flex items-center justify-center px-4 py-3 text-base border-2 rounded-xl cursor-pointer transition-all duration-300 hover:shadow-md focus:outline-none focus:ring-4 focus:ring-blue-100 {{ $deliveryOption === 'pickup' ? 'border-blue-500 bg-blue-50 text-blue-700 ring-2 ring-blue-200' : 'border-gray-200 bg-gray-50/50 text-gray-700 hover:border-gray-300' }}">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                        </svg>
                                        <span class="font-medium">Pickup</span>
                                        @if($deliveryOption === 'pickup')
                                        <svg class="w-5 h-5 ml-2 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                        </svg>
                                        @endif
                                    </button>
                                    <button type="button"
                                            wire:click="$set('deliveryOption', 'delivery')"
                                            class="flex items-center justify-center px-4 py-3 text-base border-2 rounded-xl cursor-pointer transition-all duration-300 hover:shadow-md focus:outline-none focus:ring-4 focus:ring-blue-100 {{ $deliveryOption === 'delivery' ? 'border-blue-500 bg-blue-50 text-blue-700 ring-2 ring-blue-200' : 'border-gray-200 bg-gray-50/50 text-gray-700 hover:border-gray-300' }}">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                        </svg>
                                        <span class="font-medium">Delivery</span>
                                        @if($deliveryOption === 'delivery')
                                        <svg class="w-5 h-5 ml-2 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                        </svg>
                                        @endif
                                    </button>
                                </div>
                            </div>

                            <!-- Conditional Address Fields (only show if delivery is selected) -->
                            @if($deliveryOption === 'delivery')
                            <div class="space-y-4 animate-fadeIn">
                                <div class="space-y-1">
                                    <label for="location" class="block text-xs font-bold text-gray-800 uppercase tracking-wider">
                                        Location *
                                    </label>
                                    <input type="text" id="location" wire:model.defer="location"
                                           class="w-full px-4 py-3 text-base border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition-all duration-300 bg-gray-50/50 focus:bg-white hover:border-gray-300 hover:shadow-md"
                                           placeholder="Enter your location" required>
                                </div>

                                <div class="space-y-1">
                                    <label for="city" class="block text-xs font-bold text-gray-800 uppercase tracking-wider">
                                        City *
                                    </label>
                                    <input type="text" id="city" wire:model.defer="city"
                                           class="w-full px-4 py-3 text-base border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition-all duration-300 bg-gray-50/50 focus:bg-white hover:border-gray-300 hover:shadow-md"
                                           placeholder="Enter city" required>
                                </div>

                                <div class="space-y-1">
                                    <label for="state" class="block text-xs font-bold text-gray-800 uppercase tracking-wider">
                                        State / Province *
                                    </label>
                                    <input type="text" id="state" wire:model.defer="state"
                                           class="w-full px-4 py-3 text-base border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition-all duration-300 bg-gray-50/50 focus:bg-white hover:border-gray-300 hover:shadow-md"
                                           placeholder="Enter state" required>
                                </div>
                            </div>
                            @endif

                            <!-- Pickup Address Display -->
                            @if($deliveryOption === 'pickup')
                            <div class="space-y-4 animate-fadeIn">
                                <div class="bg-blue-50 border border-blue-200 rounded-xl p-4">
                                    <div class="flex items-start space-x-3">
                                        <div class="flex-shrink-0">
                                            <svg class="w-6 h-6 text-blue-600 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <h3 class="text-sm font-bold text-blue-800 uppercase tracking-wider mb-2">
                                                Pickup Location
                                            </h3>
                                            <div class="text-blue-700 space-y-1">
                                                <p class="font-semibold">Gadget Store Nigeria</p>
                                                <p class="text-sm">123 Computer Village Road</p>
                                                <p class="text-sm">Ikeja, Lagos State</p>
                                                <p class="text-sm">Nigeria</p>
                                            </div>
                                            <div class="mt-3 pt-3 border-t border-blue-200">
                                                <p class="text-xs text-blue-600 font-medium">
                                                    📍 This is where you will pick up your order from
                                                </p>
                                                <p class="text-xs text-blue-500 mt-1">
                                                    Store Hours: Mon-Sat 9AM-7PM
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif

                            <div class="space-y-1">
                                <label for="phone" class="block text-xs font-bold text-gray-800 uppercase tracking-wider">
                                    Phone Number *
                                </label>
                                <input type="tel" id="phone" wire:model.defer="phone"
                                       class="w-full px-4 py-3 text-base border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition-all duration-300 bg-gray-50/50 focus:bg-white hover:border-gray-300 hover:shadow-md"
                                       placeholder="+234 (800) 123-4567" required>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right side: Order Summary -->
                <div class="lg:order-2">
                    <div class="bg-white backdrop-blur-sm rounded-3xl p-6 transition-all duration-300 lg:sticky lg:top-8">
                        <div class="mb-6">
                            <h2 class="text-2xl font-bold text-gray-900 mb-2">
                                <span class="flex items-center">
                                    <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-purple-600 rounded-2xl flex items-center justify-center mr-3 shadow-lg">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                    </div>
                                    Order Summary
                                </span>
                            </h2>
                            <p class="text-gray-600 ml-13">Review your items and total</p>
                            <div class="mt-3 ml-13 w-24 h-1 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full"></div>
                        </div>

                        <!-- Beautiful Cart Items -->
                        <div class="space-y-3 mb-6">
                            @foreach($cartItems as $index => $item)
                                <div class="bg-gradient-to-r from-gray-50 to-blue-50/30 rounded-2xl p-4 border border-gray-100 hover:shadow-lg hover:scale-[1.01] transition-all duration-300">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center">
                                            <div class="relative overflow-hidden rounded-xl shadow-md">
                                                <img src="{{ $item['image'] ?? 'https://via.placeholder.com/80' }}"
                                                     alt="{{ $item['name'] }}"
                                                     class="h-16 w-16 object-cover transform hover:scale-110 transition-transform duration-300">
                                                <div class="absolute inset-0 bg-gradient-to-t from-black/10 to-transparent rounded-xl"></div>
                                            </div>
                                            <div class="ml-4 flex-1">
                                                <h3 class="font-bold text-lg text-gray-900 mb-1">
                                                    {{ $item['name'] }}
                                                </h3>
                                                <div class="flex items-center space-x-3 mb-2">
                                                    <span class="text-sm text-gray-600 bg-white px-3 py-1 rounded-full border border-blue-100 shadow-sm">
                                                        Qty: {{ $item['quantity'] }}
                                                    </span>
                                                    <span class="text-xs text-blue-600 bg-blue-50 px-2 py-1 rounded-full">
                                                        ₦{{ number_format($item['price'], 2) }} each
                                                    </span>
                                                </div>

                                                @if(!empty($item['selected_storage']))
                                                    <div class="mt-1">
                                                        <span class="text-xs text-green-600 font-medium bg-green-50 px-2 py-1 rounded-full">
                                                            ✓ Storage: {{ $item['selected_storage'] }}
                                                        </span>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <p class="font-bold text-lg text-gray-900">
                                                ₦{{ number_format($item['subtotal'], 2) }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Beautiful Order Total Section -->
                        <div class="bg-gradient-to-br from-gray-50 to-blue-50/50 rounded-2xl p-6 border border-gray-100 shadow-inner mb-6">
                            <div class="space-y-3">
                                <div class="flex justify-between items-center py-2 border-b border-gray-200/70">
                                    <span class="text-base font-semibold text-gray-700 flex items-center">
                                        <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                        </svg>
                                        Subtotal
                                    </span>
                                    <span class="font-bold text-lg text-gray-900">₦{{ number_format($cartTotal, 2) }}</span>
                                </div>
                                @if($deliveryOption === 'delivery')
                                <div class="flex justify-between items-center py-2 border-b border-gray-200/70">
                                    <span class="text-base font-semibold text-gray-700 flex items-center">
                                        <svg class="w-4 h-4 mr-2 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                        </svg>
                                        Delivery
                                    </span>
                                    <span class="font-bold text-sm text-orange-600 flex items-center">
                                        <span class="text-xs bg-orange-100 px-2 py-1 rounded-full">
                                            FREE - Can be negotiated with rider
                                        </span>
                                    </span>
                                </div>
                                @endif
                                <div class="flex justify-between items-center pt-4 border-t-2 border-blue-200">
                                    <span class="text-xl font-bold text-gray-900">Total</span>
                                    <span class="text-2xl font-bold text-gray-900">
                                        ₦{{ number_format($cartTotal, 2) }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Payment Options Section -->
                        <div class="bg-gradient-to-br from-gray-50 to-blue-50/50 rounded-2xl p-6 border border-gray-100 shadow-inner mb-6">
                            <div class="mb-4">
                                <h3 class="text-lg font-bold text-gray-900 mb-2 flex items-center">
                                    <div class="w-8 h-8 bg-gradient-to-br from-green-500 to-blue-500 rounded-xl flex items-center justify-center mr-3 shadow-sm">
                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                                        </svg>
                                    </div>
                                    Payment Method
                                </h3>
                                <p class="text-gray-600 text-sm ml-11">Choose your preferred payment option</p>
                            </div>

                            <div class="space-y-3">
                                <!-- Bank Transfer Option -->
                                <div class="relative">
                                    <input type="radio" id="bank_transfer" name="payment_method"
                                           wire:model="paymentMethod" value="bank_transfer"
                                           class="sr-only peer" checked>
                                    <label for="bank_transfer" class="flex items-center p-4 bg-blue-50 rounded-xl border-2 border-blue-500 ring-2 ring-blue-200 cursor-pointer hover:border-blue-300 hover:shadow-md transition-all duration-300">
                                        <div class="flex items-center justify-center w-10 h-10 bg-blue-100 rounded-xl mr-4">
                                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                            </svg>
                                        </div>
                                        <div class="flex-1">
                                            <h4 class="font-bold text-gray-900 mb-1">Bank Transfer</h4>
                                            <p class="text-sm text-gray-600">Pay directly to our bank account</p>
                                            <div class="mt-2 text-xs text-blue-600 bg-blue-100 px-2 py-1 rounded-full inline-block">
                                                Account details will be provided after order
                                            </div>
                                        </div>
                                        <div class="ml-4">
                                            <div class="w-5 h-5 border-2 border-blue-500 bg-blue-500 rounded-full flex items-center justify-center">
                                                <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                                </svg>
                                            </div>
                                        </div>
                                    </label>
                                </div>
                            </div>

                            <!-- Pay Now Button -->
                            <div class="mt-6 pt-4 border-t-2 border-blue-200 bg-gradient-to-r from-blue-50 to-purple-50 rounded-xl p-4">
                                {{-- <div class="text-center mb-3">
                                    <h4 class="font-bold text-lg text-gray-900">Ready to Pay?</h4>
                                    <p class="text-sm text-gray-600">Complete your order with your selected payment method</p>
                                </div> --}}
                                <button type="button" wire:click="processPayment"
                                        class="w-full bg-gradient-to-r from-blue-600 bg-black via-purple-600 to-blue-700 hover:from-blue-700 hover:via-purple-700 hover:to-blue-800 text-white font-bold py-4 px-6 rounded-2xl text-lg transition-all duration-300 transform hover:-translate-y-1 hover:shadow-xl focus:outline-none focus:ring-4 focus:ring-blue-300 relative overflow-hidden group border-2 border-blue-500 shadow-lg">
                                    <div class="absolute inset-0 bg-white/20 transform -skew-x-12 -translate-x-full group-hover:translate-x-full transition-transform duration-700"></div>
                                    <span class="flex items-center justify-center relative z-10">
                                        <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                        </svg>
                                        Pay Now - Bank Transfer
                                    </span>
                                </button>

                                <!-- Payment Method Info -->
                                <div class="mt-3 text-center">
                                    <p class="text-sm text-blue-600">
                                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        Bank details will be provided for manual transfer
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Beautiful Submit Button -->
                        <div class="space-y-3">
                            <!-- Note: Submit functionality moved to Pay Now button in payment section -->

                            <div class="flex items-center justify-center space-x-6 text-sm text-gray-600 bg-green-50 py-4 px-6 rounded-2xl border border-green-100">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                    </svg>
                                    SSL Encrypted
                                </div>
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                                    </svg>
                                    Secure Payment
                                </div>
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    Money Back Guarantee
                                </div>
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </form>

    <!-- Bank Transfer Modal -->
    @if($showBankModal)
    <div class="fixed inset-0 z-50 overflow-y-auto modal-overlay" style="background-color: rgba(0, 0, 0, 0.5);">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-3xl shadow-2xl max-w-md w-full mx-4 transform transition-all duration-300 animate-fadeIn">
                <!-- Modal Header -->
                <div class="bg-gradient-to-r from-blue-600 to-purple-600 text-white p-6 rounded-t-3xl">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center mr-3">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold">Bank Transfer Details</h3>
                        </div>
                        <button wire:click="closeBankModal" class="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center hover:bg-white/30 transition-colors">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Modal Body -->
                <div class="p-6 space-y-6">
                    <!-- Order ID -->
                    <div class="bg-blue-50 rounded-xl p-4">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <span class="text-sm font-semibold text-blue-800">Order ID:</span>
                            <span class="text-sm font-bold text-blue-900 ml-2" id="orderId">{{ $generatedOrderId ?? 'GS-' . strtoupper(Str::random(8)) }}</span>
                        </div>
                    </div>

                    <!-- Bank Details -->
                    <div class="bg-gray-50 rounded-xl p-4 space-y-3">
                        <h4 class="font-bold text-gray-900 mb-3 flex items-center">
                            <svg class="w-5 h-5 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                            Transfer To:
                        </h4>

                        <div class="space-y-2">
                            <div class="flex justify-between">
                                <span class="text-sm font-medium text-gray-600">Account Name:</span>
                                <span class="text-sm font-bold text-gray-900">Gadget Store Nigeria</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-sm font-medium text-gray-600">Bank:</span>
                                <span class="text-sm font-bold text-gray-900">GTBank</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-sm font-medium text-gray-600">Account Number:</span>
                                <span class="text-sm font-bold text-gray-900">0123456789</span>
                            </div>
                            <!-- Copy Account Number Button -->
                            <div class="mt-2">
                                <button onclick="copyAccountNumber()"
                                        class="flex items-center justify-center w-full py-2 px-3 bg-blue-500 hover:bg-blue-600 text-white text-sm font-medium rounded-lg transition-all duration-300">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                    </svg>
                                    Copy Account Details
                                </button>
                            </div>
                            <div class="flex justify-between pt-2">
                                <span class="text-base font-bold text-gray-900">Amount:</span>
                                <span class="text-lg font-bold text-green-600">₦{{ number_format($cartTotal, 2) }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Instructions -->
                    <div class="bg-yellow-50 rounded-xl p-4">
                        <div class="flex items-start">
                            <svg class="w-5 h-5 text-yellow-600 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <div>
                                <h5 class="font-bold text-yellow-800 mb-2">Important Instructions:</h5>
                                <ul class="text-sm text-yellow-700 space-y-1">
                                    <li>• Make the transfer to the account details above</li>
                                    <li>• Include your Order ID in the transfer description</li>
                                    <li>• Send proof of payment via WhatsApp or Email</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Contact Options -->
                    <div class="bg-green-50 rounded-xl p-4">
                        <h5 class="font-bold text-green-800 mb-3 flex items-center">
                            <svg class="w-5 h-5 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                            </svg>
                            Send Proof of Payment:
                        </h5>
                        <div class="space-y-2">
                            <a href="https://wa.me/2348123456789?text=Payment%20Proof%20for%20Order%20ID:%20{{ $generatedOrderId ?? 'GS-' . strtoupper(Str::random(8)) }}"
                               target="_blank"
                               class="flex items-center p-3 bg-white rounded-lg hover:shadow-md transition-all duration-300">
                                <div class="w-8 h-8 bg-green-500 rounded-lg flex items-center justify-center mr-3">
                                    <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.885 3.785"/>
                                    </svg>
                                </div>
                                <div>
                                    <span class="text-sm font-bold text-gray-900">WhatsApp</span>
                                    <p class="text-xs text-gray-600">+234 812 345 6789</p>
                                </div>
                            </a>
                            <!-- Copy WhatsApp Number Button -->
                            <button onclick="copyWhatsAppNumber()"
                                    class="flex items-center justify-center w-full py-2 px-3 bg-green-500 hover:bg-green-600 text-white text-sm font-medium rounded-lg transition-all duration-300">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                </svg>
                                Copy WhatsApp Number
                            </button>
                            <a href="mailto:orders@gadgetstore.ng?subject=Payment Proof - Order ID: {{ $generatedOrderId ?? 'GS-' . strtoupper(Str::random(8)) }}&body=Please find attached proof of payment for my order."
                               class="flex items-center p-3 bg-white rounded-lg hover:shadow-md transition-all duration-300">
                                <div class="w-8 h-8 bg-blue-500 rounded-lg flex items-center justify-center mr-3">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <span class="text-sm font-bold text-gray-900">Email</span>
                                    <p class="text-xs text-gray-600">orders@gadgetstore.ng</p>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="p-6 bg-gray-50 rounded-b-3xl">
                    <div class="flex space-x-3">
                        <button wire:click="confirmPayment"
                                class="flex-1 bg-gradient-to-r from-green-600 to-blue-600 hover:from-green-700 hover:to-blue-700 text-white font-bold py-3 px-4 rounded-xl transition-all duration-300 transform hover:-translate-y-0.5 hover:shadow-lg">
                            <span class="flex items-center justify-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Payment Confirmed - Order Now
                            </span>
                        </button>
                        <button wire:click="closeBankModal"
                                class="px-6 py-3 bg-gray-300 hover:bg-gray-400 text-gray-700 font-semibold rounded-xl transition-all duration-300">
                            Cancel
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <script>
        // Copy Account Details Function
        function copyAccountNumber() {
            const accountDetails = `Account Name: Gadget Store Nigeria
Bank: GTBank
Account Number: 0123456789`;

            navigator.clipboard.writeText(accountDetails).then(function() {
                // Show success message
                showCopyMessage('Account details copied to clipboard!', 'success');
            }).catch(function(err) {
                // Fallback for older browsers
                const textArea = document.createElement("textarea");
                textArea.value = accountDetails;
                document.body.appendChild(textArea);
                textArea.select();
                document.execCommand('copy');
                document.body.removeChild(textArea);
                showCopyMessage('Account details copied to clipboard!', 'success');
            });
        }

        // Copy WhatsApp Number Function
        function copyWhatsAppNumber() {
            const whatsappNumber = '+234 812 345 6789';

            navigator.clipboard.writeText(whatsappNumber).then(function() {
                // Show success message
                showCopyMessage('WhatsApp number copied to clipboard!', 'success');
            }).catch(function(err) {
                // Fallback for older browsers
                const textArea = document.createElement("textarea");
                textArea.value = whatsappNumber;
                document.body.appendChild(textArea);
                textArea.select();
                document.execCommand('copy');
                document.body.removeChild(textArea);
                showCopyMessage('WhatsApp number copied to clipboard!', 'success');
            });
        }

        // Show Copy Message Function
        function showCopyMessage(message, type) {
            // Create or update existing notification
            let notification = document.getElementById('copyNotification');
            if (!notification) {
                notification = document.createElement('div');
                notification.id = 'copyNotification';
                notification.className = 'fixed top-4 right-4 z-50 px-4 py-2 rounded-lg shadow-lg transition-all duration-300 transform translate-x-full opacity-0';
                document.body.appendChild(notification);
            }

            // Set message and style based on type
            if (type === 'success') {
                notification.className = 'fixed top-4 right-4 z-50 px-4 py-2 rounded-lg shadow-lg transition-all duration-300 bg-green-500 text-white font-medium';
            }

            notification.textContent = message;

            // Show notification
            setTimeout(() => {
                notification.classList.remove('translate-x-full', 'opacity-0');
            }, 10);

            // Hide notification after 3 seconds
            setTimeout(() => {
                notification.classList.add('translate-x-full', 'opacity-0');
            }, 3000);
        }
    </script>
</div>
