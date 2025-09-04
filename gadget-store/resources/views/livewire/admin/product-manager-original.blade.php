<div class="space-y-6">
    <!-- Header with Search and Filters -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div class="flex flex-col sm:flex-row gap-4 flex-1">
                <!-- Search -->
                <div class="flex-1">
                    <input type="text" wire:model.live="search"
                           placeholder="Search products and deals..."
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>

                <!-- Type Filter -->
                <select wire:model.live="selectedType"
                        class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="all">All Items</option>
                    <option value="products">Products Only</option>
                    <option value="deals">Deals Only</option>
                </select>
            </div>

            <!-- Create Button -->
            <button wire:click="openCreateModal"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-medium transition-colors">
                Add New Product
            </button>
        </div>
    </div>

    <!-- Flash Messages -->
    @if (session()->has('message'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">{{ session('message') }}</span>
        </div>
    @endif

    <!-- Products Table -->
    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($products as $product)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                @if($product->images_url && count($product->images_url) > 0)
                                    <img src="{{ $product->images_url[0] }}" alt="{{ $product->product_name }}" class="w-12 h-12 rounded-lg object-cover mr-4">
                                @else
                                    <div class="w-12 h-12 bg-gray-200 rounded-lg flex items-center justify-center mr-4">
                                        <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                @endif
                                <div>
                                    <div class="text-sm font-medium text-gray-900">{{ $product->product_name }}</div>
                                    <div class="text-sm text-gray-500">ID: {{ $product->id }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex px-2 py-1 text-xs font-medium rounded-full {{ $product instanceof \App\Models\Product ? 'bg-blue-100 text-blue-800' : 'bg-purple-100 text-purple-800' }}">
                                {{ $product instanceof \App\Models\Product ? 'Product' : 'Deal' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-semibold text-gray-900">₦{{ number_format($product->price, 2) }}</div>
                            @if($product instanceof \App\Models\Deal && $product->old_price)
                                <div class="text-sm text-gray-500 line-through">₦{{ number_format($product->old_price, 2) }}</div>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">
                                {{ $product->category->name ?? 'No Category' }}
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $product->created_at->format('M j, Y') }}</div>
                            <div class="text-sm text-gray-500">{{ $product->created_at->format('g:i A') }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <button wire:click="editProduct({{ $product->id }})"
                                    class="text-indigo-600 hover:text-indigo-900 mr-3">
                                Edit
                            </button>
                            <button wire:click="deleteProduct({{ $product->id }})"
                                    class="text-red-600 hover:text-red-900">
                                Delete
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                            <div class="flex flex-col items-center">
                                <svg class="w-12 h-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                                </svg>
                                <h3 class="text-lg font-medium text-gray-900 mb-2">No products found</h3>
                                <p class="text-gray-500">Get started by adding your first product.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if($products->hasPages())
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 px-6 py-4">
            {{ $products->links() }}
        </div>
    @endif

    <!-- Create/Edit Modal -->
    @if($showModal)
        <!-- Modal implementation -->
    @endif
</div>
