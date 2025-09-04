<x-layout>
    <x-slot name="title">Search Results - Gadget Store</x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="mb-8">
            <h1 class="text-2xl font-bold text-gray-900">Search Results</h1>
            @if(request('q'))
                <p class="text-gray-600 mt-2">Results for "<strong>{{ request('q') }}</strong>"</p>
            @endif
        </div>

        <!-- Products Grid using Livewire -->
        <livewire:product-grid />
    </div>
</x-layout>
