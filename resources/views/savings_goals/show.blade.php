<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $savingsGoal->name }}
            </h2>
            <a href="{{ route('savings-goals.index') }}" class="text-blue-600 hover:text-blue-800">
                Back to Goals
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <!-- Status Badge -->
            <div class="mb-6">
                <span class="px-3 py-1 text-sm font-semibold rounded-full {{ $savingsGoal->status === 'completed' ? 'bg-green-100 text-green-800' : ($savingsGoal->status === 'cancelled' ? 'bg-red-100 text-red-800' : 'bg-blue-100 text-blue-800') }}">
                    {{ ucfirst($savingsGoal->status) }}
                </span>
            </div>

            <!-- Main Progress Card -->
            <div class="bg-white shadow rounded-lg p-8 mb-6">
                <h3 class="text-2xl font-bold text-gray-900 mb-2">{{ $savingsGoal->name }}</h3>
                
                @if ($savingsGoal->deadline)
                    <p class="text-gray-600 mb-6">Target: {{ $savingsGoal->deadline->format('F d, Y') }}</p>
                @endif

                <!-- Progress Bar -->
                <div class="mb-6">
                    <div class="flex justify-between items-center mb-3">
                        <span class="text-lg font-semibold text-gray-700">Overall Progress</span>
                        <span class="text-3xl font-bold text-blue-600">
                            {{ number_format(($savingsGoal->current_amount / $savingsGoal->target_amount) * 100, 1) }}%
                        </span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-4">
                        <div class="bg-gradient-to-r from-blue-500 to-blue-600 h-4 rounded-full transition-all" style="width: {{ min(100, ($savingsGoal->current_amount / $savingsGoal->target_amount) * 100) }}%"></div>
                    </div>
                </div>

                <!-- Amount Details -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="bg-blue-50 rounded-lg p-4">
                        <p class="text-sm text-gray-600 mb-1">Current Amount</p>
                        <p class="text-2xl font-bold text-blue-600">
                            Rp {{ number_format($savingsGoal->current_amount, 0, ',', '.') }}
                        </p>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <p class="text-sm text-gray-600 mb-1">Target Amount</p>
                        <p class="text-2xl font-bold text-gray-900">
                            Rp {{ number_format($savingsGoal->target_amount, 0, ',', '.') }}
                        </p>
                    </div>
                    <div class="bg-orange-50 rounded-lg p-4">
                        <p class="text-sm text-gray-600 mb-1">Remaining</p>
                        <p class="text-2xl font-bold text-{{ $savingsGoal->current_amount >= $savingsGoal->target_amount ? 'green' : 'orange' }}-600">
                            Rp {{ number_format(max(0, $savingsGoal->target_amount - $savingsGoal->current_amount), 0, ',', '.') }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div class="bg-white shadow rounded-lg p-6">
                    <h4 class="font-semibold text-gray-900 mb-4">Key Information</h4>
                    <dl class="space-y-3">
                        <div class="flex justify-between">
                            <dt class="text-gray-600">Created:</dt>
                            <dd class="font-medium text-gray-900">{{ $savingsGoal->created_at->format('M d, Y') }}</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-gray-600">Last Updated:</dt>
                            <dd class="font-medium text-gray-900">{{ $savingsGoal->updated_at->format('M d, Y') }}</dd>
                        </div>
                        @if ($savingsGoal->deadline)
                            <div class="flex justify-between">
                                <dt class="text-gray-600">Days Left:</dt>
                                <dd class="font-medium text-{{ now()->diffInDays($savingsGoal->deadline) <= 7 ? 'red' : 'gray' }}-900">
                                    {{ max(0, now()->diffInDays($savingsGoal->deadline)) }} days
                                </dd>
                            </div>
                        @endif
                    </dl>
                </div>

                <div class="bg-white shadow rounded-lg p-6">
                    <h4 class="font-semibold text-gray-900 mb-4">Contribution Rate</h4>
                    @if ($savingsGoal->created_at->diffInDays(now()) > 0)
                        <dl class="space-y-3">
                            <div class="flex justify-between">
                                <dt class="text-gray-600">Per Day:</dt>
                                <dd class="font-medium text-gray-900">
                                    Rp {{ number_format($savingsGoal->current_amount / max(1, $savingsGoal->created_at->diffInDays(now())), 0, ',', '.') }}
                                </dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-gray-600">Per Month:</dt>
                                <dd class="font-medium text-gray-900">
                                    Rp {{ number_format(($savingsGoal->current_amount / max(1, $savingsGoal->created_at->diffInDays(now()))) * 30, 0, ',', '.') }}
                                </dd>
                            </div>
                        </dl>
                    @else
                        <p class="text-gray-600">Goal just created - check back later for stats</p>
                    @endif
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex gap-3">
                <a href="{{ route('savings-goals.edit', $savingsGoal->id) }}" class="flex-1 px-4 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium text-center">
                    <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Edit
                </a>
                <a href="{{ route('savings-goals.index') }}" class="flex-1 px-4 py-3 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition font-medium text-center">
                    Back to List
                </a>
                <form method="POST" action="{{ route('savings-goals.destroy', $savingsGoal->id) }}" class="flex-1" onsubmit="return confirm('Delete this goal?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full px-4 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 transition font-medium">
                        <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                        Delete
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
