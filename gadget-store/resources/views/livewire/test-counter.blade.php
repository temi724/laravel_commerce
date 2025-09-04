<div class="p-4 bg-white rounded shadow-md">
    <h3 class="text-lg font-bold">Livewire Test Counter</h3>
    <div class="mt-2">
        <p>Count: <span class="font-bold text-blue-600">{{ $count }}</span></p>
        <button wire:click="increment" class="mt-2 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
            Click Me (+)
        </button>
    </div>
</div>
