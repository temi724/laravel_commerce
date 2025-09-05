<div>
    <!-- Cart Slide-over -->
    <div class="fixed inset-0 z-50 {{ $isOpen ? '' : 'hidden' }}" wire:ignore.self>
        <!-- Background overlay -->
        <div class="fixed inset-0 bg-black bg-opacity-50 transition-opacity" wire:click="closeCart"></div>

        <!-- Slide-over panel -->
        <div class="fixed right-0 top-0 h-full w-full max-w-md bg-white shadow-xl transform transition-transform duration-300 ease-in-out {{ $isOpen ? 'translate-x-0' : 'translate-x-full' }}">
            <div class="flex h-full flex-col">
                <!-- Header -->
                <div class="flex items-center justify-between border-b border-gray-200 p-6">
                    <h2 class="text-lg font-semibold text-gray-900">Shopping Cart</h2>
                    <button wire:click="closeCart" class="rounded-md p-2 text-gray-400 hover:text-gray-500">
                        <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M7.75781 16.2428L16.2431 7.75781" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M16.2431 16.2428L7.75781 7.75781" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </button>
                </div>

                <!-- Cart Items -->
                <div class="flex-1 overflow-y-auto px-6 py-4">
                    @if(count($cartItems) > 0)
                        <div class="space-y-4">
                            @foreach($cartItems as $item)
                                <div class="flex items-center space-x-4 rounded-lg border border-gray-100 p-4">
                                    <!-- Product Image -->
                                    <div class="h-16 w-16 flex-shrink-0 rounded-lg bg-gray-100">
                                        @if($item['image'])
                                            <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}" class="h-full w-full rounded-lg object-cover">
                                        @else
                                            <div class="flex h-full w-full items-center justify-center">
                                                <svg class="h-8 w-8 text-gray-400" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M4 16L4.586 15.414A2 2 0 005.414 15H7M4 16L4 18A2 2 0 006 20H18A2 2 0 0020 18V16M4 16L4 6A2 2 0 016 4H18A2 2 0 0120 6V16M20 16L19.414 15.414A2 2 0 0018.586 15H17M20 16L16 12L13 15" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                </svg>
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Product Details -->
                                    <div class="flex-1">
                                        <h3 class="text-sm font-medium text-gray-900 line-clamp-2">{{ $item['name'] }}</h3>

                                        <!-- Storage Selection Display -->
                                        @if(isset($item['selected_storage']))
                                            <p class="text-xs text-blue-600 mt-1">{{ $item['selected_storage'] }}</p>
                                        @endif

                                        <!-- Price Display -->
                                        @if(isset($item['old_price']) && $item['old_price'] > $item['price'])
                                            <div class="flex items-center space-x-2">
                                                <p class="text-sm font-semibold text-gray-900">₦{{ number_format($item['price'], 2) }}</p>
                                                <p class="text-sm text-gray-500 line-through">₦{{ number_format($item['old_price'], 2) }}</p>
                                            </div>
                                        @else
                                            <p class="text-sm text-gray-600">₦{{ number_format($item['price'], 2) }}</p>
                                        @endif

                                        <!-- Quantity Controls -->
                                        <div class="mt-2 flex items-center space-x-2">
                                            <button wire:click="decreaseQuantity('{{ $item['id'] }}')"
                                                    wire:loading.attr="disabled"
                                                    class="flex h-6 w-6 items-center justify-center rounded border border-gray-300 text-gray-500 hover:bg-gray-50 disabled:opacity-50"
                                                    @if($item['quantity'] <= 1) disabled @endif>
                                                <svg class="h-3 w-3" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M6 12H18" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                                                </svg>
                                            </button>
                                            <span class="text-sm font-medium min-w-[1.5rem] text-center">
                                                <span wire:loading wire:target="decreaseQuantity,increaseQuantity" class="text-gray-400">...</span>
                                                <span wire:loading.remove wire:target="decreaseQuantity,increaseQuantity">{{ $item['quantity'] }}</span>
                                            </span>
                                            <button wire:click="increaseQuantity('{{ $item['id'] }}')"
                                                    wire:loading.attr="disabled"
                                                    class="flex h-6 w-6 items-center justify-center rounded border border-gray-300 text-gray-500 hover:bg-gray-50 disabled:opacity-50">
                                                <svg class="h-3 w-3" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M6 12H18" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                                                    <path d="M12 18V6" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Remove Button -->
                                    <button wire:click="removeFromCart('{{ $item['id'] }}')" class="text-red-500 hover:text-red-700">
                                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M19 7L18.1327 19.1425C18.0579 20.1891 17.187 21 16.1378 21H7.86224C6.81296 21 5.94208 20.1891 5.86732 19.1425L5 7" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                                            <path d="M10 11V17" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                                            <path d="M14 11V17" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                                            <path d="M4 7H20" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                                            <path d="M6 7H12H18V6A3 3 0 0015 3H9A3 3 0 006 6V7Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                                        </svg>
                                    </button>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <!-- Empty Cart -->
                        <div class="flex flex-col items-center justify-center py-12 text-center">
                            <svg class="mb-4 h-16 w-16 text-gray-300" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M2 3L2.26491 3.0883C3.58495 3.52832 4.24497 3.74832 4.62248 4.2721C5 4.79587 5 5.49159 5 6.88304V9.5C5 12.7875 5 14.4312 5.90796 15.5376C6.07418 15.7401 6.25989 15.9258 6.46243 16.092C7.56878 17 9.21252 17 12.5 17C15.7875 17 17.4312 17 18.5376 16.092C18.7401 15.9258 18.9258 15.7401 19.092 15.5376C20 14.4312 20 12.7875 20 9.5V8.5C20 7.09554 20 6.39331 19.6532 5.88886C19.3065 5.38441 18.6851 5.18885 17.4422 4.79773L12.5 3" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                                <path d="M7.5 18C8.32843 18 9 18.6716 9 19.5C9 20.3284 8.32843 21 7.5 21C6.67157 21 6 20.3284 6 19.5C6 18.6716 6.67157 18 7.5 18Z" stroke="currentColor" stroke-width="1.5"/>
                                <path d="M16.5 18.0001C17.3284 18.0001 18 18.6716 18 19.5001C18 20.3285 17.3284 21.0001 16.5 21.0001C15.6716 21.0001 15 20.3285 15 19.5001C15 18.6716 15.6716 18.0001 16.5 18.0001Z" stroke="currentColor" stroke-width="1.5"/>
                            </svg>
                            <h3 class="text-lg font-medium text-gray-900">Your cart is empty</h3>
                            <p class="mt-1 text-sm text-gray-500">Start shopping to add items to your cart.</p>
                            <button wire:click="closeCart" class="mt-4 rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700">
                                Continue Shopping
                            </button>
                        </div>
                    @endif
                </div>

                <!-- Footer -->
                @if(count($cartItems) > 0)
                    <div class="border-t border-gray-200 p-6">
                        <!-- Total -->
                        <div class="flex items-center justify-between text-lg font-semibold text-gray-900">
                            <span>Total</span>
                            <span>₦{{ number_format($this->getTotalPrice(), 2) }}</span>
                        </div>

                        <!-- Actions -->
                        <div class="mt-4 space-y-2">
                            <a href="/cart" wire:click="closeCart" class="block w-full rounded-lg bg-blue-600 py-3 text-center font-medium text-white hover:bg-blue-700">
                                View Cart ({{ $this->getTotalItems() }})
                            </a>
                            <button wire:click="clearCart" class="block w-full rounded-lg border border-gray-300 py-3 text-center font-medium text-gray-700 hover:bg-gray-50">
                                Clear Cart
                            </button>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
