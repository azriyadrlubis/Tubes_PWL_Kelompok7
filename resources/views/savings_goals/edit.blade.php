<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Savings Goal') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow rounded-lg p-6">
                <form method="POST" action="{{ route('savings-goals.update', $savingsGoal->id) }}" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <!-- Goal Name -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Goal Name</label>
                        <input 
                            type="text" 
                            id="name" 
                            name="name" 
                            value="{{ old('name', $savingsGoal->name) }}"
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
                            value="{{ old('target_amount', $savingsGoal->target_amount) }}"
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
                            value="{{ old('current_amount', $savingsGoal->current_amount) }}"
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
                            value="{{ old('deadline', $savingsGoal->deadline ? $savingsGoal->deadline->format('Y-m-d') : '') }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        >
                        @error('deadline')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                        <p class="text-sm text-gray-500 mt-1">Optional: Update your target date</p>
                    </div>

                    <!-- Progress Info -->
                    <div class="bg-gray-50 rounded p-4">
                        <h3 class="font-medium text-gray-900 mb-3">Goal Progress</h3>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-blue-600 h-2 rounded-full transition-all" style="width: {{ min(100, ($savingsGoal->current_amount / $savingsGoal->target_amount) * 100) }}%"></div>
                        </div>
                        <p class="text-sm text-gray-600 mt-2">
                            {{ number_format(($savingsGoal->current_amount / $savingsGoal->target_amount) * 100, 1) }}% complete - 
                            Rp {{ number_format(max(0, $savingsGoal->target_amount - $savingsGoal->current_amount), 0, ',', '.') }} remaining
                        </p>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex gap-3 pt-4">
                        <a href="{{ route('savings-goals.index') }}" class="flex-1 px-4 py-2.5 text-gray-700 border border-gray-300 rounded-lg hover:bg-gray-100 transition font-medium text-center">
                            Cancel
                        </a>
                        <button type="submit" class="flex-1 px-4 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium">
                            Update Goal
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
