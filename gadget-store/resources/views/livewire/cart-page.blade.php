<div>
    @if(count($cartItems) > 0)
        <!-- Cart Items -->
        <div class="space-y-6">
            @foreach($cartItems as $index => $item)
                <div class="flex items-center space-x-4 py-6 border-b border-gray-200">
                    <!-- Product Image -->
                    <div class="flex-shrink-0">
                        <img src="{{ $item['image'] ?? 'https://via.placeholder.com/96' }}"
                             alt="{{ $item['name'] }}"
                             class="h-20 w-24 rounded-lg object-cover">
                    </div>

                    <!-- Product Details -->
                    <div class="flex-1 min-w-0">
                        <h3 class="text-lg font-medium text-gray-900 truncate">
                            {{ $item['name'] }}
                        </h3>
                        <p class="text-sm text-gray-500 mt-1">
                            {{ $item['type'] === 'deal' ? 'Flash Deal' : 'Product' }}
                        </p>
                        @if(isset($item['old_price']) && $item['old_price'] > $item['price'])
                            <div class="flex items-center space-x-2 mt-2">
                                <p class="text-lg font-semibold text-gray-900">₦{{ number_format($item['price'], 2) }}</p>
                                <p class="text-sm text-gray-500 line-through">₦{{ number_format($item['old_price'], 2) }}</p>
                            </div>
                        @else
                            <p class="text-lg font-semibold text-gray-900 mt-2">
                                ₦{{ number_format($item['price'], 2) }}
                            </p>
                        @endif
                    </div>

                    <!-- Quantity Controls -->
                    <div class="flex items-center space-x-3">
                        <button wire:click="decreaseQuantity('{{ $item['id'] }}')"
                                wire:loading.attr="disabled"
                                class="w-8 h-8 rounded-full border border-gray-300 flex items-center justify-center hover:bg-gray-50 transition-colors disabled:opacity-50"
                                @if($item['quantity'] <= 1) disabled @endif>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                            </svg>
                        </button>

                        <span class="text-lg font-medium min-w-[2rem] text-center">
                            <span wire:loading wire:target="decreaseQuantity,increaseQuantity" class="text-gray-400">...</span>
                            <span wire:loading.remove wire:target="decreaseQuantity,increaseQuantity">{{ $item['quantity'] }}</span>
                        </span>

                        <button wire:click="increaseQuantity('{{ $item['id'] }}')"
                                wire:loading.attr="disabled"
                                class="w-8 h-8 rounded-full border border-gray-300 flex items-center justify-center hover:bg-gray-50 transition-colors disabled:opacity-50">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                        </button>
                    </div>

                    <!-- Subtotal -->
                    <div class="text-right">
                        <p class="text-lg font-semibold text-gray-900">
                            ₦{{ number_format($item['subtotal'], 2) }}
                        </p>
                    </div>

                    <!-- Remove Button -->
                    <div>
                        <button wire:click="removeFromCart('{{ $item['id'] }}')"
                                wire:confirm="Are you sure you want to remove this item from your cart?"
                                class="text-red-500 hover:text-red-700 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Cart Summary -->
        <div class="mt-8 bg-gray-50 rounded-lg p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center space-x-4">
                    <span class="text-sm text-gray-600">{{ $cartCount }} {{ $cartCount === 1 ? 'item' : 'items' }}</span>
                    <button wire:click="clearCart"
                            class="text-sm text-red-600 hover:text-red-800 transition-colors"
                            onclick="return confirm('Are you sure you want to clear your cart?')">
                        Clear Cart
                    </button>
                </div>
                <div class="text-right">
                    <p class="text-sm text-gray-600">Total</p>
                    <p class="text-2xl font-bold text-gray-900">₦{{ number_format($cartTotal, 2) }}</p>
                </div>
            </div>

            <div class="flex flex-col sm:flex-row gap-3 pt-4 border-t border-gray-200">
                <a href="/"
                   class="flex-1 bg-white border border-gray-300 text-gray-700 px-6 py-3 rounded-lg font-medium text-center hover:bg-gray-50 transition-colors">
                    Continue Shopping
                </a>
                <a href="{{ route('checkout.index') }}"
                   class="flex-1 bg-blue-600 text-white px-6 py-3 rounded-lg font-medium hover:bg-blue-700 transition-colors text-center">
                    Proceed to Checkout
                </a>
            </div>
        </div>
    @else
        <!-- Empty Cart -->
        <div class="text-center py-12">
            <div class="mx-auto w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.293 2.293a1 1 0 00.707 1.707H19M7 13v4a2 2 0 002 2h2m3-10V9a3 3 0 016 0v1m-6 0h6m-6 0V9a3 3 0 00-6 0v1h6z"></path>
                </svg>
            </div>
            <h3 class="text-lg font-medium text-gray-900 mb-2">Your cart is empty</h3>
            <p class="text-gray-500 mb-6">Add some products to your cart to get started.</p>
            <a href="/"
               class="inline-flex items-center px-6 py-3 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition-colors">
                Start Shopping
            </a>
        </div>
    @endif
</div>
