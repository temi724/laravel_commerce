                <!-- Order Header -->
                <div class="bg-gradient-to-r from-gray-50 to-gray-100/70 px-6 py-4 border-b border-gray-200/50">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-4">
                            <div class="bg-white px-4 py-2 rounded-lg shadow-sm border border-gray-200">
                                <span class="text-sm font-bold text-gray-900">#{{ $sale->order_id }}</span>
                            </div>
                            <div class="flex items-center space-x-2">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $sale->order_type === 'delivery' ? 'bg-blue-100 text-blue-700 border border-blue-200' : 'bg-emerald-100 text-emerald-700 border border-emerald-200' }}">
                                    <span class="w-2 h-2 rounded-full {{ $sale->order_type === 'delivery' ? 'bg-blue-400' : 'bg-emerald-400' }} mr-2"></span>
                                    {{ ucfirst($sale->order_type) }}
                                </span>
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $sale->order_status ? 'bg-green-100 text-green-700 border border-green-200' : 'bg-amber-100 text-amber-700 border border-amber-200' }}">
                                    <span class="w-2 h-2 rounded-full {{ $sale->order_status ? 'bg-green-400' : 'bg-amber-400' }} mr-2"></span>
                                    {{ $sale->order_status ? 'Completed' : 'Pending' }}
                                </span>
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="text-lg font-bold text-gray-900">₦{{ number_format($this->calculateOrderTotal($sale->product_ids), 2) }}</div>
                            <div class="text-xs text-gray-500">{{ $sale->created_at->format('M j, Y • g:i A') }}</div>
                        </div>
                    </div>
                </div>

                <!-- Order Details -->
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Customer Info -->
                        <div class="space-y-3">
                            <h4 class="text-sm font-semibold text-gray-700 uppercase tracking-wide">Customer</h4>
                            <div class="space-y-2">
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                    <span class="text-sm font-medium text-gray-900">{{ $sale->username }}</span>
                                </div>
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                    </svg>
                                    <span class="text-sm text-gray-600">{{ $sale->emailaddress }}</span>
                                </div>
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                    </svg>
                                    <span class="text-sm text-gray-600">{{ $sale->phonenumber }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Order Info -->
                        <div class="space-y-3">
                            <h4 class="text-sm font-semibold text-gray-700 uppercase tracking-wide">Order Details</h4>
                            <div class="space-y-2">
                                <div class="flex justify-between">
                                    <span class="text-sm text-gray-600">Items:</span>
                                    <span class="text-sm font-medium text-gray-900">{{ $sale->quantity }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-sm text-gray-600">Payment:</span>
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium border
                                        @if($sale->payment_status === 'completed') bg-green-50 text-green-700 border-green-200
                                        @elseif($sale->payment_status === 'pending') bg-amber-50 text-amber-700 border-amber-200
                                        @elseif($sale->payment_status === 'failed') bg-red-50 text-red-700 border-red-200
                                        @else bg-gray-50 text-gray-700 border-gray-200 @endif">
                                        {{ ucfirst($sale->payment_status) }}
                                    </span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-sm text-gray-600">Method:</span>
                                    <span class="text-sm text-gray-900 bg-orange-50 px-2 py-1 rounded-md border border-orange-200">Bank Transfer</span>
                                </div>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="space-y-3">
                            <h4 class="text-sm font-semibold text-gray-700 uppercase tracking-wide">Actions</h4>
                            <div class="flex flex-col space-y-2">
                                <button wire:click="viewOrder('{{ $sale->id }}')"
                                        class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-blue-700 bg-blue-50 hover:bg-blue-100 border border-blue-200 rounded-lg transition-colors duration-150">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 616 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                    View Details
                                </button>

                                @if(!$sale->order_status)
                                    <button wire:click="updateOrderStatus('{{ $sale->id }}', true)"
                                            class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-green-700 bg-green-50 hover:bg-green-100 border border-green-200 rounded-lg transition-colors duration-150">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        Mark Complete
                                    </button>
                                @endif

                                @if($sale->payment_status === 'pending')
                                    <button wire:click="updatePaymentStatus('{{ $sale->id }}', 'completed')"
                                            class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-emerald-700 bg-emerald-50 hover:bg-emerald-100 border border-emerald-200 rounded-lg transition-colors duration-150">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        Mark Paid
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200/60 p-12">
                <div class="text-center">
                    <div class="w-20 h-20 bg-gradient-to-br from-gray-100 to-gray-200 rounded-full flex items-center justify-center mx-auto mb-6 border border-gray-300">
                        <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-700 mb-3">No orders found</h3>
                    <p class="text-gray-500 max-w-md mx-auto">Orders will appear here once customers start making purchases from your store</p>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($sales->hasPages())
        <div class="mt-6">
            <div class="bg-white rounded-lg border border-gray-200 px-6 py-4">
                {{ $sales->links() }}
            </div>
        </div>
    @endif
