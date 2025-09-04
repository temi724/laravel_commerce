<x-layout>
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-lg shadow-sm">
            <!-- Header -->
            <div class="px-6 py-4 border-b border-gray-200">
                <h1 class="text-2xl font-bold text-gray-900">Shopping Cart</h1>
            </div>

            <!-- Cart Content -->
            <div class="p-6">
                @livewire('cart-page')
            </div>
        </div>
    </div>
</div>
</x-layout>
