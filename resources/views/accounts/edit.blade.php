<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="text-xl font-bold text-slate-900">Edit Akun</h2>
            <p class="text-sm text-slate-500">Perbarui detail akun Anda dengan mudah.</p>
        </div>
    </x-slot>

    <div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50 py-8">
        <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">
            <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <p class="text-xs font-bold uppercase tracking-[0.28em] text-slate-400">Wallet Maintenance</p>
                    <h1 class="mt-2 text-4xl font-extrabold tracking-tight text-slate-950">Edit Akun</h1>
                    <p class="mt-2 text-slate-500">Sesuaikan nama, tipe, dan saldo akun yang sudah terdaftar.</p>
                </div>

                <a href="{{ route('accounts.index') }}"
                    class="inline-flex h-11 items-center justify-center rounded-2xl border border-slate-200 bg-white px-5 text-sm font-bold text-slate-700 shadow-sm transition hover:bg-slate-50">
                    Kembali
                </a>
            </div>

            @php
                $types = [
                    'cash' => [
                        'label' => 'Cash',
                        'desc' => 'Uang tunai harian',
                        'color' => 'peer-checked:border-emerald-400 peer-checked:bg-emerald-50',
                        'icon' => 'bg-emerald-100 text-emerald-700',
                    ],
                    'bank' => [
                        'label' => 'Bank',
                        'desc' => 'Rekening tabungan',
                        'color' => 'peer-checked:border-blue-400 peer-checked:bg-blue-50',
                        'icon' => 'bg-blue-100 text-blue-700',
                    ],
                    'credit' => [
                        'label' => 'Kartu Kredit',
                        'desc' => 'Limit dan cicilan',
                        'color' => 'peer-checked:border-rose-400 peer-checked:bg-rose-50',
                        'icon' => 'bg-rose-100 text-rose-700',
                    ],
                    'other' => [
                        'label' => 'E-wallet',
                        'desc' => 'Dompet digital',
                        'color' => 'peer-checked:border-violet-400 peer-checked:bg-violet-50',
                        'icon' => 'bg-violet-100 text-violet-700',
                    ],
                ];

                $selectedType = old('type', $account->type);
                $selectedStyle = $types[$selectedType] ?? $types['other'];
            @endphp

            <div class="grid gap-6 lg:grid-cols-[1fr_0.72fr]">
                <div class="overflow-hidden rounded-[32px] border border-white/70 bg-white/90 shadow-xl shadow-slate-900/5 ring-1 ring-slate-200/70">
                    <div class="border-b border-slate-100 bg-white px-6 py-5">
                        <h3 class="text-lg font-extrabold text-slate-950">Detail Akun</h3>
                        <p class="mt-1 text-sm text-slate-500">Perbarui informasi akun tanpa mengubah struktur transaksi.</p>
                    </div>

                    <form action="{{ route('accounts.update', $account) }}" method="POST" class="space-y-7 p-6">
                        @csrf
                        @method('PUT')

                        <div>
                            <label for="name" class="mb-2 block text-sm font-bold text-slate-700">Nama Akun</label>
                            <input id="name" name="name" value="{{ old('name', $account->name) }}" required
                                class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm font-semibold text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-blue-400 focus:bg-white focus:ring-4 focus:ring-blue-100" />
                            @error('name')
                                <p class="mt-2 text-sm font-semibold text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <p class="mb-3 block text-sm font-bold text-slate-700">Tipe Akun</p>

                            <div class="grid gap-3 sm:grid-cols-2">
                                @foreach ($types as $value => $type)
                                    <label class="cursor-pointer">
                                        <input type="radio" name="type" value="{{ $value }}" class="peer sr-only"
                                            @checked(old('type', $account->type) === $value)>

                                        <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4 transition {{ $type['color'] }}">
                                            <div class="flex items-center justify-between gap-3">
                                                <div>
                                                    <p class="font-extrabold text-slate-900">{{ $type['label'] }}</p>
                                                    <p class="mt-1 text-xs font-medium text-slate-500">{{ $type['desc'] }}</p>
                                                </div>

                                                <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-white text-slate-500 shadow-sm ring-1 ring-slate-200">
                                                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round">
                                                        <path d="M20 6L9 17l-5-5" />
                                                    </svg>
                                                </div>
                                            </div>
                                        </div>
                                    </label>
                                @endforeach
                            </div>

                            @error('type')
                                <p class="mt-2 text-sm font-semibold text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="balance" class="mb-2 block text-sm font-bold text-slate-700">Saldo Akun</label>
                            <div class="flex overflow-hidden rounded-2xl border border-slate-200 bg-slate-50 transition focus-within:border-blue-400 focus-within:bg-white focus-within:ring-4 focus-within:ring-blue-100">
                                <span class="flex items-center border-r border-slate-200 px-4 text-sm font-extrabold text-slate-500">Rp</span>
                                <input id="balance" name="balance" type="number" step="0.01" min="0"
                                    value="{{ old('balance', $account->balance) }}" required
                                    class="w-full border-0 bg-transparent px-4 py-3 text-sm font-semibold text-slate-900 outline-none focus:ring-0" />
                            </div>
                            @error('balance')
                                <p class="mt-2 text-sm font-semibold text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex flex-col gap-3 border-t border-slate-100 pt-6 sm:flex-row sm:justify-end">
                            <a href="{{ route('accounts.index') }}"
                                class="inline-flex h-12 items-center justify-center rounded-2xl border border-slate-200 bg-white px-6 text-sm font-bold text-slate-700 transition hover:bg-slate-50">
                                Batal
                            </a>

                            <button type="submit"
                                class="inline-flex h-12 items-center justify-center gap-2 rounded-2xl bg-slate-950 px-6 text-sm font-bold text-white shadow-lg shadow-slate-900/15 transition hover:bg-slate-800">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                                Perbarui Akun
                            </button>
                        </div>
                    </form>
                </div>

                <aside class="rounded-[32px] border border-white/70 bg-white/75 p-6 shadow-xl shadow-slate-900/5 ring-1 ring-slate-200/70">
                    <p class="text-xs font-bold uppercase tracking-[0.28em] text-slate-400">Current Wallet</p>

                    <div class="mt-5 rounded-[28px] bg-slate-950 p-5 text-white">
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <p class="text-sm text-slate-400">Nama akun</p>
                                <p class="mt-2 text-2xl font-extrabold">{{ $account->name }}</p>
                            </div>

                            <div class="flex h-11 w-11 items-center justify-center rounded-2xl {{ $selectedStyle['icon'] }}">
                                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M20 6L9 17l-5-5" />
                                </svg>
                            </div>
                        </div>

                        <div class="mt-8">
                            <p class="text-sm text-slate-400">Saldo saat ini</p>
                            <p class="mt-1 text-3xl font-extrabold">
                                Rp{{ number_format($account->balance, 0, ',', '.') }}
                            </p>
                        </div>
                    </div>

                    <div class="mt-5 grid gap-3">
                        <div class="rounded-2xl border border-slate-200 bg-white p-4">
                            <p class="text-xs font-bold uppercase tracking-[0.18em] text-slate-400">Tipe</p>
                            <p class="mt-2 font-extrabold text-slate-950">
                                {{ $types[$account->type]['label'] ?? ucfirst($account->type) }}
                            </p>
                        </div>

                        <div class="rounded-2xl border border-slate-200 bg-white p-4">
                            <p class="text-xs font-bold uppercase tracking-[0.18em] text-slate-400">Terakhir diperbarui</p>
                            <p class="mt-2 font-extrabold text-slate-950">
                                {{ optional($account->updated_at)->format('d M Y') ?? '-' }}
                            </p>
                        </div>
                    </div>
                </aside>
            </div>
        </div>
    </div>
</x-app-layout>