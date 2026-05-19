@extends('layouts.app')

@section('content')
<div class="bg-gradient-to-br from-blue-50 to-indigo-50 min-h-screen">
    <div class="max-w-6xl mx-auto px-4 py-8">

        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-4xl font-bold text-gray-800">Accounts</h1>
                <p class="text-gray-500 mt-1">Kelola semua akun dan dompet keuangan Anda</p>
            </div>
        </div>

        @if (session('success'))
            <div class="mb-6 rounded-[28px] border border-emerald-200/80 bg-emerald-50/80 px-6 py-4 text-emerald-900 shadow-sm">
                {{ session('success') }}
            </div>
        @endif

                    @php
                        $typeLabels = [
                            'bank' => 'Bank',
                            'cash' => 'Cash',
                            'credit' => 'Kartu Kredit',
                            'other' => 'E-wallet',
                        ];

                        $typeIcons = [
                            'bank' =>
                                '<svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M3 10l9-6 9 6"/><path d="M5 10v10h14V10"/><path d="M10 14h4"/><path d="M7 20v-6"/><path d="M17 20v-6"/></svg>',
                            'cash' =>
                                '<svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12v5a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-5"/><path d="M3 7h18"/><path d="M7 7v10"/><path d="M17 7v10"/><circle cx="12" cy="13" r="2"/></svg>',
                            'credit' =>
                                '<svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="7" width="20" height="14" rx="3"/><path d="M2 11h20"/><path d="M6 16h2"/></svg>',
                            'other' =>
                                '<svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M7 2h10a3 3 0 0 1 3 3v14a3 3 0 0 1-3 3H7a3 3 0 0 1-3-3V5a3 3 0 0 1 3-3Z"/><path d="M12 18h.01"/></svg>',
                        ];

                        $accountItems =
                            $accounts instanceof \Illuminate\Pagination\AbstractPaginator
                                ? $accounts->getCollection()
                                : collect($accounts);

                        $totalBalance = $accountItems->sum('balance');
                    @endphp

                    <div class="mb-6 rounded-[32px] bg-slate-900/5 p-6 ring-1 ring-slate-200/80">
                        <div class="grid gap-4 lg:grid-cols-[minmax(0,1fr)_auto] lg:items-center">
                            <div class="grid gap-4 sm:grid-cols-2">
                                <div class="rounded-[28px] bg-white p-6 shadow-sm ring-1 ring-slate-200/80">
                                    <p class="text-xs uppercase tracking-[0.24em] text-slate-500">Saldo Total</p>
                                    <p class="mt-3 text-3xl font-semibold text-slate-900">Rp
                                        {{ number_format($totalBalance, 0, ',', '.') }}</p>
                                    <p class="mt-2 text-sm text-slate-500">Ringkasan semua dompet aktif Anda.</p>
                                </div>
                                <div class="rounded-[28px] bg-white p-6 shadow-sm ring-1 ring-slate-200/80">
                                    <p class="text-xs uppercase tracking-[0.24em] text-slate-500">Akun Aktif</p>
                                    <p class="mt-3 text-3xl font-semibold text-slate-900">{{ $accounts->count() }}</p>
                                    <p class="mt-2 text-sm text-slate-500">Jumlah dompet yang sedang aktif.</p>
                                </div>
                            </div>

                            <div class="flex flex-col items-end justify-end gap-2">
                                <a href="{{ route('accounts.create') }}"
                                    class="inline-flex h-9 min-w-[130px] items-center justify-center gap-1.5 rounded-full bg-emerald-500 px-4 text-xs font-semibold text-white shadow-md shadow-emerald-500/10 transition hover:bg-emerald-600">
                                    + Tambah Akun
                                </a>
                                <a href="{{ route('accounts.transfer') }}"
                                    class="inline-flex h-9 min-w-[130px] items-center justify-center gap-1.5 rounded-full bg-slate-900 px-4 text-xs font-semibold text-white shadow-md shadow-slate-900/10 transition hover:bg-slate-800">
                                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M4 7h16" />
                                        <path d="M4 12h10" />
                                        <path d="M16 17l4-4-4-4" />
                                    </svg>
                                    Transfer
                                </a>
                            </div>
                        </div>
                    </div>

                    @if ($accounts->isEmpty())
                        <div class="rounded-3xl border border-dashed border-gray-300 bg-white p-12 text-center shadow-sm">
                            <div class="mx-auto h-24 w-24 rounded-full bg-gray-100 flex items-center justify-center mb-4">
                                <svg class="h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M3 10.5V19a2 2 0 002 2h14a2 2 0 002-2v-8.5M5 10.5L12 4l7 6.5M5 10.5h14" />
                                </svg>
                            </div>
                            <p class="text-gray-500 mb-6">Belum ada akun. Tambahkan akun untuk mulai mengelola saldo.</p>
                            <a href="{{ route('accounts.create') }}"
                                class="inline-flex items-center gap-2 rounded-2xl bg-emerald-500 hover:bg-emerald-600 px-6 py-3 text-sm font-semibold text-white shadow-sm transition-colors">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v16m8-8H4" />
                                </svg>
                                Tambah Akun Pertamamu
                            </a>
                        </div>
                    @else
                        <div class="space-y-3">
    @foreach ($accounts as $account)
        @php
            $typeIcon = $typeIcons[$account->type] ?? $typeIcons['other'];
        @endphp

        <div class="rounded-2xl border-l-4 border-blue-500 bg-white p-4 shadow-md transition-all duration-200 hover:shadow-lg">
            <div class="flex items-center justify-between gap-4">
                <div class="flex flex-1 items-center gap-4">
                    <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-full bg-blue-100 text-blue-600">
                        {!! $typeIcon !!}
                    </div>

                    <div>
                        <h3 class="text-lg font-semibold text-gray-800">{{ $account->name }}</h3>
                        <div class="mt-1 flex items-center gap-3">
                            <span class="rounded-full bg-gray-100 px-2 py-1 text-xs text-gray-600">
                                {{ $typeLabels[$account->type] ?? ucfirst($account->type) }}
                            </span>
                            <span class="text-xs text-gray-500">ID {{ $account->id }}</span>
                            <span class="text-xs text-gray-500">
                                {{ $account->transactions_count ?? 0 }} transaksi
                            </span>
                        </div>
                    </div>
                </div>

                <div class="text-right">
                    <p class="text-2xl font-bold text-blue-600">
                        Rp{{ number_format($account->balance, 0, ',', '.') }}
                    </p>

                    <div class="mt-2 flex justify-end gap-2">
                        <a href="{{ route('accounts.edit', $account) }}"
                            class="rounded-lg p-2 text-yellow-600 transition-colors hover:bg-yellow-50 hover:text-yellow-800"
                            title="Edit">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                        </a>

                        <form action="{{ route('accounts.destroy', $account) }}" method="POST"
                            onsubmit="return confirm('Hapus akun ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="rounded-lg p-2 text-red-600 transition-colors hover:bg-red-50 hover:text-red-800"
                                title="Hapus">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>
                    @endif
                </div>
            </div>
        @endsection
