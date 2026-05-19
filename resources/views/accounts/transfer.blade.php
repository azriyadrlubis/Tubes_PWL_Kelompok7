<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="text-xl font-bold text-slate-900">Transfer Antar Akun</h2>
            <p class="text-sm text-slate-500">Pindahkan saldo antar rekening tanpa keluar dari dashboard.</p>
        </div>
    </x-slot>

    <div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50 py-8">
        <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">
            <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <p class="text-xs font-bold uppercase tracking-[0.28em] text-slate-400">Money Movement</p>
                    <h1 class="mt-2 text-4xl font-extrabold tracking-tight text-slate-950">Transfer Saldo</h1>
                    <p class="mt-2 max-w-2xl text-slate-500">
                        Pindahkan saldo dari satu akun ke akun lain dengan catatan yang tetap rapi.
                    </p>
                </div>

                <a href="{{ route('accounts.index') }}"
                    class="inline-flex h-11 items-center justify-center rounded-2xl border border-slate-200 bg-white px-5 text-sm font-bold text-slate-700 shadow-sm transition hover:bg-slate-50">
                    Kembali
                </a>
            </div>

            @if (session('success'))
                <div class="mb-6 rounded-3xl border border-emerald-200 bg-emerald-50 px-6 py-4 text-sm font-semibold text-emerald-900 shadow-sm">
                    {{ session('success') }}
                </div>
            @endif

            @if ($accounts->count() < 2)
                <div class="mb-6 rounded-[28px] border border-amber-200 bg-amber-50 px-6 py-5 text-amber-900 shadow-sm">
                    <p class="font-bold">Transfer belum bisa digunakan</p>
                    <p class="mt-1 text-sm">Tambahkan minimal dua akun untuk dapat memindahkan saldo.</p>
                </div>
            @endif

            <div class="grid gap-6 lg:grid-cols-[1fr_0.72fr]">
                <div class="overflow-hidden rounded-[32px] border border-white/70 bg-white/90 shadow-xl shadow-slate-900/5 ring-1 ring-slate-200/70">
                    <div class="border-b border-slate-100 px-6 py-5">
                        <h3 class="text-lg font-extrabold text-slate-950">Detail Transfer</h3>
                        <p class="mt-1 text-sm text-slate-500">Pilih akun sumber, akun tujuan, lalu masukkan nominal.</p>
                    </div>

                    <form action="{{ route('accounts.transfer.store') }}" method="POST" class="space-y-7 p-6">
                        @csrf

                        <div class="grid gap-4 sm:grid-cols-[1fr_auto_1fr] sm:items-end">
                            <div>
                                <label for="from_account_id" class="mb-2 block text-sm font-bold text-slate-700">Dari Akun</label>
                                <select id="from_account_id" name="from_account_id" required
                                    class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm font-semibold text-slate-900 outline-none transition focus:border-blue-400 focus:bg-white focus:ring-4 focus:ring-blue-100">
                                    <option value="">Pilih akun sumber</option>
                                    @foreach ($accounts as $account)
                                        <option value="{{ $account->id }}" {{ old('from_account_id') == $account->id ? 'selected' : '' }}>
                                            {{ $account->name }} - {{ ucfirst($account->type) }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('from_account_id')
                                    <p class="mt-2 text-sm font-semibold text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="hidden pb-3 sm:flex">
                                <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-slate-950 text-white shadow-lg shadow-slate-900/15">
                                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M5 12h14" />
                                        <path d="M13 6l6 6-6 6" />
                                    </svg>
                                </div>
                            </div>

                            <div>
                                <label for="to_account_id" class="mb-2 block text-sm font-bold text-slate-700">Ke Akun</label>
                                <select id="to_account_id" name="to_account_id" required
                                    class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm font-semibold text-slate-900 outline-none transition focus:border-blue-400 focus:bg-white focus:ring-4 focus:ring-blue-100">
                                    <option value="">Pilih akun tujuan</option>
                                    @foreach ($accounts as $account)
                                        <option value="{{ $account->id }}" {{ old('to_account_id') == $account->id ? 'selected' : '' }}>
                                            {{ $account->name }} - {{ ucfirst($account->type) }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('to_account_id')
                                    <p class="mt-2 text-sm font-semibold text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div>
                            <label for="amount" class="mb-2 block text-sm font-bold text-slate-700">Jumlah Transfer</label>
                            <div class="flex overflow-hidden rounded-2xl border border-slate-200 bg-slate-50 transition focus-within:border-blue-400 focus-within:bg-white focus-within:ring-4 focus-within:ring-blue-100">
                                <span class="flex items-center border-r border-slate-200 px-4 text-sm font-extrabold text-slate-500">Rp</span>
                                <input id="amount" name="amount" type="number" step="0.01" min="0.01"
                                    value="{{ old('amount') }}" placeholder="1000000" required
                                    class="w-full border-0 bg-transparent px-4 py-3 text-sm font-semibold text-slate-900 outline-none focus:ring-0" />
                            </div>
                            @error('amount')
                                <p class="mt-2 text-sm font-semibold text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex flex-col gap-3 border-t border-slate-100 pt-6 sm:flex-row sm:justify-end">
                            <a href="{{ route('accounts.index') }}"
                                class="inline-flex h-12 items-center justify-center rounded-2xl border border-slate-200 bg-white px-6 text-sm font-bold text-slate-700 transition hover:bg-slate-50">
                                Batal
                            </a>

                            <button type="submit"
                                class="inline-flex h-12 items-center justify-center gap-2 rounded-2xl bg-slate-950 px-6 text-sm font-bold text-white shadow-lg shadow-slate-900/15 transition hover:bg-slate-800 disabled:cursor-not-allowed disabled:opacity-60"
                                @disabled($accounts->count() < 2)>
                                Transfer Sekarang
                            </button>
                        </div>
                    </form>
                </div>

                <aside class="rounded-[32px] border border-white/70 bg-white/75 p-6 shadow-xl shadow-slate-900/5 ring-1 ring-slate-200/70">
                    <p class="text-xs font-bold uppercase tracking-[0.28em] text-slate-400">Transfer Flow</p>

                    <div class="mt-5 space-y-4">
                        <div class="rounded-[28px] bg-slate-950 p-5 text-white">
                            <p class="text-sm text-slate-400">Langkah 1</p>
                            <p class="mt-2 text-xl font-extrabold">Pilih akun sumber</p>
                            <p class="mt-2 text-sm text-slate-400">Saldo akan dikurangi dari akun ini.</p>
                        </div>

                        <div class="rounded-[28px] border border-slate-200 bg-white p-5">
                            <p class="text-sm font-bold text-slate-400">Langkah 2</p>
                            <p class="mt-2 text-xl font-extrabold text-slate-950">Pilih akun tujuan</p>
                            <p class="mt-2 text-sm text-slate-500">Saldo akan ditambahkan ke akun tujuan.</p>
                        </div>

                        <div class="rounded-[28px] border border-emerald-200 bg-emerald-50 p-5">
                            <p class="text-sm font-bold text-emerald-500">Langkah 3</p>
                            <p class="mt-2 text-xl font-extrabold text-slate-950">Transfer tercatat</p>
                            <p class="mt-2 text-sm text-slate-500">Riwayat saldo tetap bisa dilacak dengan rapi.</p>
                        </div>
                    </div>
                </aside>
            </div>
        </div>
    </div>
</x-app-layout>