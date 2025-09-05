{{-- <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Header with integrated tabs -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Admin Dashboard</h1>
        <p class="text-gray-600 mb-6">Manage your products, sales, and orders</p>

        <!-- Tab Navigation - More integrated style -->
        <div class="border-b border-gray-200">
            <div class="flex space-x-8">
                <button wire:click="setTab('overview')"
                        class="py-2 px-1 text-sm font-medium {{ $currentTab === 'overview' ? 'text-blue-600 border-b-2 border-blue-600' : 'text-gray-500 hover:text-gray-700 hover:border-gray-300 border-b-2 border-transparent' }} transition-colors">
                    Overview
                </button>
                <button wire:click="setTab('products')"
                        class="py-2 px-1 text-sm font-medium {{ $currentTab === 'products' ? 'text-blue-600 border-b-2 border-blue-600' : 'text-gray-500 hover:text-gray-700 hover:border-gray-300 border-b-2 border-transparent' }} transition-colors">
                    Products
                </button>
                <button wire:click="setTab('sales')"
                        class="py-2 px-1 text-sm font-medium {{ $currentTab === 'sales' ? 'text-blue-600 border-b-2 border-blue-600' : 'text-gray-500 hover:text-gray-700 hover:border-gray-300 border-b-2 border-transparent' }} transition-colors">
                    Sales & Orders
                </button>
            </div>
        </div>
    </div>

        <!-- Tab Content -->
        @if($currentTab === 'overview')
            <!-- Overview Dashboard -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Total Products -->
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Total Products</p>
                            <p class="text-2xl font-bold text-gray-900">{{ number_format($totalProducts) }}</p>
                        </div>
                    </div>
                </div>

                <!-- Total Deals -->
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Total Deals</p>
                            <p class="text-2xl font-bold text-gray-900">{{ number_format($totalDeals) }}</p>
                        </div>
                    </div>
                </div>

                <!-- Total Sales -->
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Total Orders</p>
                            <p class="text-2xl font-bold text-gray-900">{{ number_format($totalSales) }}</p>
                        </div>
                    </div>
                </div>

                <!-- Total Revenue -->
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Total Revenue</p>
                            <p class="text-2xl font-bold text-gray-900">₦{{ number_format($totalRevenue, 2) }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order Status Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <!-- Pending Orders -->
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">Pending Orders</h3>
                            <p class="text-3xl font-bold text-orange-600 mt-2">{{ number_format($pendingOrders) }}</p>
                            <p class="text-sm text-gray-500 mt-1">Awaiting processing</p>
                        </div>
                        <div class="w-16 h-16 bg-orange-100 rounded-full flex items-center justify-center">
                            <svg class="w-8 h-8 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Completed Orders -->
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">Completed Orders</h3>
                            <p class="text-3xl font-bold text-green-600 mt-2">{{ number_format($completedOrders) }}</p>
                            <p class="text-sm text-gray-500 mt-1">Successfully delivered</p>
                        </div>
                        <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center">
                            <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

        @elseif($currentTab === 'products')
            <!-- Products Management -->
            @livewire('admin.product-manager')

        @elseif($currentTab === 'sales')
            <!-- Sales Management -->
        @livewire('admin.sales-manager')
    @endif
</div> --}}
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Header with integrated tabs -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Admin Dashboard</h1>
        <p class="text-gray-600 mb-6">Manage your products, sales, and orders</p>

        <!-- Tab Navigation - More integrated style -->
        <div class="border-b border-gray-200">
            <div class="flex space-x-8">
                <button wire:click="setTab('overview')"
                        class="py-2 px-1 text-sm font-medium {{ $currentTab === 'overview' ? 'text-blue-600 border-b-2 border-blue-600' : 'text-gray-500 hover:text-gray-700 hover:border-gray-300 border-b-2 border-transparent' }} transition-colors">
                    Overview
                </button>
                <button wire:click="setTab('products')"
                        class="py-2 px-1 text-sm font-medium {{ $currentTab === 'products' ? 'text-blue-600 border-b-2 border-blue-600' : 'text-gray-500 hover:text-gray-700 hover:border-gray-300 border-b-2 border-transparent' }} transition-colors">
                    Products
                </button>
                <button wire:click="setTab('sales')"
                        class="py-2 px-1 text-sm font-medium {{ $currentTab === 'sales' ? 'text-blue-600 border-b-2 border-blue-600' : 'text-gray-500 hover:text-gray-700 hover:border-gray-300 border-b-2 border-transparent' }} transition-colors">
                    Sales & Orders
                </button>
            </div>
        </div>
    </div>

    <!-- Tab Content -->
    @if($currentTab === 'overview')
        <!-- Overview Dashboard -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Total Products -->
            <div class="bg-white rounded-xl shadow-sm p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Total Products</p>
                        <p class="text-2xl font-bold text-gray-900">{{ number_format($totalProducts) }}</p>
                    </div>
                </div>
            </div>

            <!-- Total Deals -->
            <div class="bg-white rounded-xl shadow-sm p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Total Deals</p>
                        <p class="text-2xl font-bold text-gray-900">{{ number_format($totalDeals) }}</p>
                    </div>
                </div>
            </div>

            <!-- Total Sales -->
            <div class="bg-white rounded-xl shadow-sm p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Total Orders</p>
                        <p class="text-2xl font-bold text-gray-900">{{ number_format($totalSales) }}</p>
                    </div>
                </div>
            </div>

            <!-- Total Revenue -->
            <div class="bg-white rounded-xl shadow-sm p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Total Revenue</p>
                        <p class="text-2xl font-bold text-gray-900">₦{{ number_format($totalRevenue, 2) }}</p>
                        <p class="text-xs text-gray-500 mt-1">From completed payments only</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Order Status Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <!-- Pending Orders -->
            <div class="bg-white rounded-xl shadow-sm p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Pending Orders</h3>
                        <p class="text-3xl font-bold text-orange-600 mt-2">{{ number_format($pendingOrders) }}</p>
                        <p class="text-sm text-gray-500 mt-1">Awaiting processing</p>
                    </div>
                    <div class="w-16 h-16 bg-orange-100 rounded-full flex items-center justify-center">
                        <svg class="w-8 h-8 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Completed Orders -->
            <div class="bg-white rounded-xl shadow-sm p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Completed Orders</h3>
                        <p class="text-3xl font-bold text-green-600 mt-2">{{ number_format($completedOrders) }}</p>
                        <p class="text-sm text-gray-500 mt-1">Successfully delivered</p>
                    </div>
                    <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center">
                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Revenue Breakdown -->
        <div class="bg-white rounded-xl shadow-sm p-6 mb-8">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Revenue Breakdown</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-blue-50 p-4 rounded-lg">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span class="text-sm font-medium text-blue-700">Completed Payments</span>
                    </div>
                    <p class="text-xl font-bold text-blue-900 mt-2">
                        {{ $completedPayments }}
                    </p>
                </div>

                <div class="bg-yellow-50 p-4 rounded-lg">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-yellow-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span class="text-sm font-medium text-yellow-700">Pending Payments</span>
                    </div>
                    <p class="text-xl font-bold text-yellow-900 mt-2">
                        {{ $pendingPayments }}
                    </p>
                </div>

                <div class="bg-red-50 p-4 rounded-lg">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-red-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        <span class="text-sm font-medium text-red-700">Failed/Refunded</span>
                    </div>
                    <p class="text-xl font-bold text-red-900 mt-2">
                        {{ $failedRefundedPayments }}
                    </p>
                </div>
            </div>
        </div>

    @elseif($currentTab === 'products')
        <!-- Products Management -->
        @livewire('admin.product-manager')

    @elseif($currentTab === 'sales')
        <!-- Sales Management -->
        @livewire('admin.sales-manager')
    @endif
</div>
