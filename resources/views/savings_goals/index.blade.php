<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Savings Goals') }}
            </h2>
            <a href="{{ route('savings-goals.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                New Goal
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Success Message -->
            @if (session('status'))
                <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg">
                    <p class="text-green-800">{{ session('status') }}</p>
                </div>
            @endif

            <!-- Empty State -->
            @if ($savingsGoals->isEmpty())
                <div class="bg-white shadow rounded-lg p-12 text-center">
                    <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">No Savings Goals Yet</h3>
                    <p class="text-gray-600 mb-4">Start building your financial future by creating your first savings goal.</p>
                    <a href="{{ route('savings-goals.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Create First Goal
                    </a>
                </div>
            @else
                <!-- Goals Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($savingsGoals as $goal)
                        <div class="bg-white shadow rounded-lg p-6 hover:shadow-lg transition">
                            <div class="flex justify-between items-start mb-4">
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900">{{ $goal->name }}</h3>
                                    @if ($goal->deadline)
                                        <p class="text-sm text-gray-500">Due: {{ $goal->deadline->format('M d, Y') }}</p>
                                    @endif
                                </div>
                                <span class="px-3 py-1 text-xs font-semibold rounded-full {{ $goal->status === 'completed' ? 'bg-green-100 text-green-800' : ($goal->status === 'cancelled' ? 'bg-red-100 text-red-800' : 'bg-blue-100 text-blue-800') }}">
                                    {{ ucfirst($goal->status) }}
                                </span>
                            </div>

                            <!-- Progress Bar -->
                            <div class="mb-4">
                                <div class="flex justify-between items-center mb-2">
                                    <span class="text-sm font-medium text-gray-700">Progress</span>
                                    <span class="text-sm font-semibold text-gray-900">
                                        {{ number_format(($goal->current_amount / $goal->target_amount) * 100, 1) }}%
                                    </span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-blue-600 h-2 rounded-full transition-all" style="width: {{ min(100, ($goal->current_amount / $goal->target_amount) * 100) }}%"></div>
                                </div>
                            </div>

                            <!-- Amount Info -->
                            <div class="bg-gray-50 rounded p-3 mb-4">
                                <div class="flex justify-between items-center text-sm">
                                    <span class="text-gray-600">Current:</span>
                                    <span class="font-semibold text-gray-900">Rp {{ number_format($goal->current_amount, 0, ',', '.') }}</span>
                                </div>
                                <div class="flex justify-between items-center text-sm mt-1">
                                    <span class="text-gray-600">Target:</span>
                                    <span class="font-semibold text-gray-900">Rp {{ number_format($goal->target_amount, 0, ',', '.') }}</span>
                                </div>
                                <div class="flex justify-between items-center text-sm mt-1">
                                    <span class="text-gray-600">Remaining:</span>
                                    <span class="font-semibold text-{{ $goal->current_amount >= $goal->target_amount ? 'green' : 'orange' }}-600">
                                        Rp {{ number_format(max(0, $goal->target_amount - $goal->current_amount), 0, ',', '.') }}
                                    </span>
                                </div>
                            </div>

                            <!-- Actions -->
                            <div class="flex gap-2">
                                <a href="{{ route('savings-goals.edit', $goal->id) }}" class="flex-1 px-3 py-2 bg-blue-50 text-blue-600 rounded hover:bg-blue-100 transition text-sm font-medium text-center">
                                    Edit
                                </a>
                                <a href="{{ route('savings-goals.show', $goal->id) }}" class="flex-1 px-3 py-2 bg-gray-50 text-gray-600 rounded hover:bg-gray-100 transition text-sm font-medium text-center">
                                    View
                                </a>
                                <form method="POST" action="{{ route('savings-goals.destroy', $goal->id) }}" class="flex-1" onsubmit="return confirm('Delete this goal?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-full px-3 py-2 bg-red-50 text-red-600 rounded hover:bg-red-100 transition text-sm font-medium">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
