<div class="min-h-screen bg-gray-100 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <!-- Logo & Header -->
        <div class="text-center">
            <div class="mx-auto h-16 w-16 bg-gradient-to-br from-blue-500 to-purple-600 rounded-lg flex items-center justify-center">
                <span class="text-white font-bold text-2xl">GS</span>
            </div>
            <h2 class="mt-6 text-3xl font-extrabold text-gray-900">Admin Dashboard</h2>
            <p class="mt-2 text-sm text-gray-600">Sign in to your account</p>
            <p class="mt-1 text-xs text-gray-500">Page loaded: {{ now()->format('H:i:s') }}</p>
        </div>

        <!-- Login Form -->
        <form wire:submit.prevent="login" class="mt-8 space-y-6">
            <div class="bg-white shadow-lg rounded-lg p-6">
                <!-- Email Field -->
                <div class="space-y-4">
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
                        <div class="mt-1">
                            <input
                                wire:model="email"
                                id="email"
                                name="email"
                                type="email"
                                autocomplete="email"
                                required
                                class="appearance-none relative block w-full px-3 py-2 border @error('email') border-red-300 @else border-gray-300 @enderror placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm"
                                placeholder="Enter your email"
                            >
                            @error('email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Password Field -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                        <div class="mt-1">
                            <input
                                wire:model="password"
                                id="password"
                                name="password"
                                type="password"
                                autocomplete="current-password"
                                required
                                class="appearance-none relative block w-full px-3 py-2 border @error('password') border-red-300 @else border-gray-300 @enderror placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm"
                                placeholder="Enter your password"
                            >
                            @error('password')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Remember Me -->
                    <div class="flex items-center">
                        <input
                            wire:model="remember"
                            id="remember"
                            name="remember"
                            type="checkbox"
                            class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                        >
                        <label for="remember" class="ml-2 block text-sm text-gray-700">Remember me</label>
                    </div>
                </div>

                <!-- Login Error -->
                @if($loginError)
                    <div class="mt-4 bg-red-50 border border-red-200 rounded-md p-3">
                        <div class="text-sm text-red-600">{{ $loginError }}</div>
                    </div>
                @endif

                <!-- Debug Message -->
                @if($debugMessage)
                    <div class="mt-4 bg-blue-50 border border-blue-200 rounded-md p-3">
                        <div class="text-sm text-blue-600">{{ $debugMessage }}</div>
                    </div>
                @endif

                <!-- Debug Test Button -->
                <div class="mt-4">
                    <button
                        type="button"
                        wire:click="testConnection"
                        class="text-sm text-blue-600 hover:text-blue-500 underline"
                    >
                        Test Livewire Connection
                    </button>
                </div>

                <!-- Submit Button -->
                <div class="mt-6">
                    <button
                        type="submit"
                        class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200"
                        wire:loading.attr="disabled"
                    >
                        <span wire:loading.remove>Sign in</span>
                        <span wire:loading class="flex items-center">
                            <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Signing in...
                        </span>
                    </button>
                </div>
            </div>
        </form>

        <!-- Back to Store -->
        <div class="text-center">
            <a href="/" class="text-sm text-blue-600 hover:text-blue-500 font-medium">
                ← Back to Store
            </a>
        </div>
    </div>
</div>

<script>
    document.addEventListener('livewire:init', () => {
        Livewire.on('redirect-to-dashboard', () => {
            // Immediate redirect
            window.location.href = '/admin/dashboard';
        });
    });
</script>
