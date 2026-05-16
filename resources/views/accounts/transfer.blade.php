<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="font-semibold text-2xl text-slate-900 tracking-tight">Transfer Antar Akun</h2>
                <p class="text-sm text-slate-500 max-w-2xl">Pindahkan saldo antar rekening tanpa perlu keluar dari dashboard.</p>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-6 rounded-[28px] border border-emerald-200/80 bg-emerald-50/80 px-6 py-4 text-emerald-900 shadow-sm">
                    {{ session('success') }}
                </div>
            @endif

            <div class="rounded-[28px] border border-slate-200 bg-white p-6 shadow-sm">
                <form action="{{ route('accounts.transfer.store') }}" method="POST" class="space-y-6">
                    @csrf

                    <div class="grid gap-6 sm:grid-cols-2">
                        <div>
                            <label for="from_account_id" class="block text-sm font-semibold text-slate-700 mb-2">Dari Akun</label>
                            <select id="from_account_id" name="from_account_id" required class="w-full rounded-2xl border border-slate-300 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                                <option value="">Pilih akun sumber</option>
                                @foreach($accounts as $account)
                                    <option value="{{ $account->id }}" {{ old('from_account_id') == $account->id ? 'selected' : '' }}>{{ $account->name }} — {{ ucfirst($account->type) }}</option>
                                @endforeach
                            </select>
                            @error('from_account_id')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label for="to_account_id" class="block text-sm font-semibold text-slate-700 mb-2">Ke Akun</label>
                            <select id="to_account_id" name="to_account_id" required class="w-full rounded-2xl border border-slate-300 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                                <option value="">Pilih akun tujuan</option>
                                @foreach($accounts as $account)
                                    <option value="{{ $account->id }}" {{ old('to_account_id') == $account->id ? 'selected' : '' }}>{{ $account->name }} — {{ ucfirst($account->type) }}</option>
                                @endforeach
                            </select>
                            @error('to_account_id')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    <div>
                        <label for="amount" class="block text-sm font-semibold text-slate-700 mb-2">Jumlah Transfer</label>
                        <input id="amount" name="amount" type="number" step="0.01" min="0.01" value="{{ old('amount') }}" placeholder="1000000" required class="w-full rounded-2xl border border-slate-300 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100" />
                        @error('amount')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <div class="flex flex-col gap-3 sm:flex-row sm:justify-end pt-2 border-t border-slate-200">
                        <a href="{{ route('accounts.index') }}" class="inline-flex justify-center rounded-2xl border border-slate-300 bg-white px-6 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">Kembali</a>
                        <button type="submit" class="inline-flex justify-center rounded-2xl bg-slate-900 px-6 py-3 text-sm font-semibold text-white transition hover:bg-slate-800">Transfer Sekarang</button>
                    </div>
                </form>
            </div>

            @if($accounts->count() < 2)
                <div class="mt-6 rounded-[28px] border border-amber-200 bg-amber-50/80 px-6 py-4 text-amber-900 shadow-sm">
                    Tambahkan minimal dua akun untuk dapat menggunakan fitur transfer.
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
