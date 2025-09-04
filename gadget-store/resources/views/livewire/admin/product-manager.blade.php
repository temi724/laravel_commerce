

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
                    <th class="px-8 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                    <th class="px-8 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                    <th class="px-8 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                    <th class="px-8 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                    <th class="px-8 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created</th>
                    <th class="px-8 py-4 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($items as $product)
                    <tr class="hover:bg-gray-50 transition-colors duration-150">
                        <td class="px-8 py-6">
                            <div class="flex items-center" style="gap: 24px;">
                                @if($product->images_url && count($product->images_url) > 0)
                                    <img src="{{ $product->images_url[0] }}" alt="{{ $product->product_name }}" class="w-16 h-16 rounded-lg object-cover shadow-sm border border-gray-200 mr-6" style="margin-right: 24px;">
                                @else
                                    <div class="w-16 h-16 bg-gray-200 rounded-lg flex items-center justify-center shadow-sm border border-gray-200 mr-6" style="margin-right: 24px;">
                                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                @endif
                                <div class="ml-6 space-y-1" style="margin-left: 24px;">
                                    <div class="text-sm font-semibold text-gray-900">{{ $product->product_name }}</div>
                                    <div class="text-xs text-gray-500">ID: {{ $product->id }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-6 whitespace-nowrap">
                            <span class="inline-flex px-3 py-1.5 text-xs font-medium rounded-full {{ $product instanceof \App\Models\Product ? 'bg-blue-100 text-blue-800' : 'bg-purple-100 text-purple-800' }}">
                                {{ $product instanceof \App\Models\Product ? 'Product' : 'Deal' }}
                            </span>
                        </td>
                        <td class="px-8 py-6 whitespace-nowrap">
                            <div class="text-sm font-semibold text-gray-900">₦{{ number_format($product->price, 2) }}</div>
                            @if($product instanceof \App\Models\Deal && $product->old_price)
                                <div class="text-xs text-gray-500 line-through mt-1">₦{{ number_format($product->old_price, 2) }}</div>
                            @endif
                        </td>
                        <td class="px-8 py-6 whitespace-nowrap">
                            <div class="text-sm text-gray-900 font-medium">
                                {{ $product->category->name ?? 'No Category' }}
                            </div>
                        </td>
                        <td class="px-8 py-6 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $product->created_at->format('M j, Y') }}</div>
                            <div class="text-xs text-gray-500 mt-1">{{ $product->created_at->format('g:i A') }}</div>
                        </td>
                        <td class="px-8 py-6 whitespace-nowrap text-right text-sm font-medium space-x-3">
                            <button wire:click="openEditModal({{ $product->id }}, '{{ $product instanceof \App\Models\Product ? 'product' : 'deal' }}')"
                                    class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md text-indigo-700 bg-indigo-100 hover:bg-indigo-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-150">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                                Edit
                            </button>
                            <button wire:click="deleteProduct({{ $product->id }}, '{{ $product instanceof \App\Models\Product ? 'product' : 'deal' }}')"
                                    class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md text-red-700 bg-red-100 hover:bg-red-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors duration-150">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                                Delete
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-8 py-16 text-center text-gray-500">
                            <div class="flex flex-col items-center">
                                <svg class="w-16 h-16 text-gray-400 mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
    @if(method_exists($items, 'hasPages') && $items->hasPages())
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 px-6 py-4">
            {{ $items->links() }}
        </div>
    @endif

    <!-- Create/Edit Modal -->
    @if($showCreateModal || $showEditModal)
        <div class="fixed inset-0 flex items-center justify-center z-50 p-4"
             wire:click.self="{{ $showCreateModal ? 'closeCreateModal' : 'closeEditModal' }}">
            <div class="bg-white rounded-lg shadow-xl w-full max-w-2xl max-h-[50vh] flex flex-col border border-gray-200"
                 wire:click.stop>
                <!-- Modal Header - Fixed -->
                <div class="flex items-center justify-between p-6 border-b border-gray-200 flex-shrink-0">
                    <h3 class="text-lg font-semibold text-gray-900">
                        {{ $showCreateModal ? 'Add New Product' : 'Edit Product' }}
                    </h3>
                    <button wire:click="{{ $showCreateModal ? 'closeCreateModal' : 'closeEditModal' }}"
                            class="text-gray-400 hover:text-gray-600 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <!-- Modal Body - Scrollable Content -->
                <div class="flex-1 overflow-y-auto">
                    <form wire:submit.prevent="{{ $showCreateModal ? 'createProduct' : 'updateProduct' }}" class="h-full flex flex-col">
                        <div class="p-6 space-y-6">
                            <!-- Product Name -->
                            <div>
                                <label for="product_name" class="block text-sm font-medium text-gray-700 mb-2">
                                    Product Name *
                                </label>
                                <input type="text"
                                       id="product_name"
                                       wire:model="product_name"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('product_name') border-red-500 @enderror"
                                       placeholder="Enter product name">
                                @error('product_name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Price and Category Row -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <!-- Price -->
                                <div>
                                    <label for="price" class="block text-sm font-medium text-gray-700 mb-2">
                                        Price (₦) *
                                    </label>
                                    <input type="number"
                                           id="price"
                                           wire:model="price"
                                           step="0.01"
                                           min="0"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('price') border-red-500 @enderror"
                                           placeholder="0.00">
                                    @error('price')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Category -->
                                <div>
                                    <label for="category_id" class="block text-sm font-medium text-gray-700 mb-2">
                                        Category *
                                    </label>
                                    <select id="category_id"
                                            wire:model="category_id"
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('category_id') border-red-500 @enderror">
                                        <option value="">Select a category</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Description -->
                            <div>
                                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                                    Description *
                                </label>
                                <textarea id="description"
                                          wire:model="description"
                                          rows="4"
                                          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('description') border-red-500 @enderror"
                                          placeholder="Enter product description"></textarea>
                                @error('description')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Images -->
                            <div>
                                <label for="images_url" class="block text-sm font-medium text-gray-700 mb-2">
                                    Image URLs
                                </label>
                                <textarea id="images_url"
                                          wire:model="images_url"
                                          rows="3"
                                          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                          placeholder="Enter image URLs (one per line)&#10;https://example.com/image1.jpg&#10;https://example.com/image2.jpg"></textarea>
                                <p class="mt-1 text-xs text-gray-500">Enter one image URL per line</p>
                            </div>

                            <!-- Colors -->
                            <div>
                                <label for="colors" class="block text-sm font-medium text-gray-700 mb-2">
                                    Available Colors
                                </label>
                                <input type="text"
                                       id="colors"
                                       wire:model="colors"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                       placeholder="Red, Blue, Green, Black">
                                <p class="mt-1 text-xs text-gray-500">Separate colors with commas</p>
                            </div>

                            <!-- Specifications -->
                            <div>
                                <label for="specification" class="block text-sm font-medium text-gray-700 mb-2">
                                    Specifications
                                </label>
                                <textarea id="specification"
                                          wire:model="specification"
                                          rows="4"
                                          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                          placeholder="Enter specifications (one per line)&#10;Weight: 1.5kg&#10;Dimensions: 20cm x 15cm x 10cm&#10;Material: Premium plastic"></textarea>
                                <p class="mt-1 text-xs text-gray-500">Enter one specification per line</p>
                            </div>
                        </div>

                        <!-- Modal Footer - Fixed -->
                        <div class="flex items-center justify-end gap-3 p-6 border-t border-gray-200 flex-shrink-0 bg-white">
                            <button type="button"
                                    wire:click="{{ $showCreateModal ? 'closeCreateModal' : 'closeEditModal' }}"
                                    class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                                Cancel
                            </button>
                            <button type="submit"
                                    class="px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                                {{ $showCreateModal ? 'Create Product' : 'Update Product' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>
