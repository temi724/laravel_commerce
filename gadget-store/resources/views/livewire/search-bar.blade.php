<div class="relative">
    <div class="flex bg-white rounded-lg shadow-sm border border-gray-300 overflow-hidden">
        <!-- Search Input -->
        <div class="relative flex-1">
            <input
                type="text"
                wire:model.live.debounce.500ms="query"
                placeholder="Search for products..."
                class="w-full px-3 sm:px-4 py-2 sm:py-3 border-0 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm bg-white"
            >
            @if($query)
                <div class="absolute right-2 top-1/2 transform -translate-y-1/2 text-xs text-gray-400 hidden sm:block">
                    {{ $searchResults->count() }} results
                </div>
            @endif
        </div>

        <!-- Search Button -->
        <button
            wire:click="search"
            class="bg-blue-600 text-white px-4 sm:px-6 py-2 sm:py-3 hover:bg-blue-700 transition-colors duration-200 flex items-center justify-center flex-shrink-0"
        >
            <svg class="w-4 h-4 sm:w-5 sm:h-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M11.5 21C16.7467 21 21 16.7467 21 11.5C21 6.25329 16.7467 2 11.5 2C6.25329 2 2 6.25329 2 11.5C2 16.7467 6.25329 21 11.5 21Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M22 22L20 20" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </button>
    </div>

    <!-- Search Dropdown -->
    @if($showDropdown && $searchResults->count() > 0)
    <div class="absolute top-full left-0 right-0 bg-white border border-gray-200 rounded-lg shadow-lg z-50 mt-1">
        <div class="py-2">
            @if($query && $searchResults->count() > 0)
                <div class="px-4 py-2 text-xs text-gray-500 border-b">
                    {{ $searchResults->count() }} results for "{{ $query }}"
                </div>
                @foreach($searchResults as $product)
                    <button
                        wire:click="selectProduct('{{ $product->id }}')"
                        class="w-full px-3 sm:px-4 py-2 sm:py-3 text-left hover:bg-gray-50 flex items-center space-x-2 sm:space-x-3 transition-colors"
                    >
                        <div class="w-10 h-10 sm:w-12 sm:h-12 bg-gray-200 rounded-lg flex-shrink-0 flex items-center justify-center">
                            <svg class="w-4 h-4 sm:w-6 sm:h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="text-sm font-medium text-gray-900 truncate">
                                {{ $product->product_name }}
                            </div>
                            <div class="text-xs sm:text-sm text-gray-500 truncate">
                                @if($product->category)
                                    {{ $product->category->name }}
                                @endif
                            </div>
                        </div>
                        <div class="text-sm sm:text-lg font-bold text-blue-600 flex-shrink-0">
                            ₦{{ number_format($product->price, 2) }}
                        </div>
                    </button>
                @endforeach

                @if($searchResults->count() >= 8)
                    <div class="border-t border-gray-200 px-4 py-2">
                        <button
                            wire:click="search"
                            class="w-full text-center text-sm text-blue-600 hover:text-blue-800 transition-colors py-2"
                        >
                            View all results for "{{ $query }}"
                        </button>
                    </div>
                @endif
            @elseif($query)
                <div class="px-4 py-8 text-center text-gray-500">
                    <svg class="w-12 h-12 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m21 21-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    <div class="text-sm">No results found for "{{ $query }}"</div>
                    <div class="text-xs text-gray-400 mt-1">Try searching with different keywords</div>
                </div>
            @endif
        </div>
    </div>
    @endif
</div>
