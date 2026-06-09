<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Savings Goal') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow rounded-lg p-6">
                <form method="POST" action="{{ route('savings-goals.store') }}" class="space-y-6">
                    @csrf

                    <!-- Goal Name -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Goal Name</label>
                        <input 
                            type="text" 
                            id="name" 
                            name="name" 
                            value="{{ old('name') }}"
                            placeholder="e.g., Vacation, New Car, Emergency Fund"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            required
                        >
                        @error('name')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Target Amount -->
                    <div>
                        <label for="target_amount" class="block text-sm font-medium text-gray-700 mb-2">Target Amount (Rp)</label>
                        <input 
                            type="number" 
                            id="target_amount" 
                            name="target_amount" 
                            value="{{ old('target_amount') }}"
                            placeholder="0"
                            step="1000"
                            min="0"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            required
                        >
                        @error('target_amount')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Current Amount -->
                    <div>
                        <label for="current_amount" class="block text-sm font-medium text-gray-700 mb-2">Current Amount (Rp)</label>
                        <input 
                            type="number" 
                            id="current_amount" 
                            name="current_amount" 
                            value="{{ old('current_amount', 0) }}"
                            placeholder="0"
                            step="1000"
                            min="0"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        >
                        @error('current_amount')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Deadline -->
                    <div>
                        <label for="deadline" class="block text-sm font-medium text-gray-700 mb-2">Target Deadline</label>
                        <input 
                            type="date" 
                            id="deadline" 
                            name="deadline" 
                            value="{{ old('deadline') }}"
                            min="{{ now()->addDay()->format('Y-m-d') }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        >
                        @error('deadline')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                        <p class="text-sm text-gray-500 mt-1">Optional: Set a target date to motivate yourself</p>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex gap-3 pt-4">
                        <a href="{{ route('savings-goals.index') }}" class="flex-1 px-4 py-2.5 text-gray-700 border border-gray-300 rounded-lg hover:bg-gray-100 transition font-medium text-center">
                            Cancel
                        </a>
                        <button type="submit" class="flex-1 px-4 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium">
                            Create Goal
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
