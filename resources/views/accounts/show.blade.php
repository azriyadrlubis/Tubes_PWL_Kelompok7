<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-xl font-bold text-slate-900">{{ $account->name }}</h2>
                <p class="text-sm text-slate-500">Detail saldo, tipe akun, dan aktivitas terbaru.</p>
            </div>

            <div class="flex flex-col gap-3 sm:flex-row sm:items-center">
                <a href="{{ route('accounts.edit', $account) }}"
                    class="inline-flex h-11 items-center justify-center rounded-2xl border border-slate-200 bg-white px-5 text-sm font-bold text-slate-700 shadow-sm transition hover:bg-slate-50">
                    Edit Akun
                </a>
                <a href="{{ route('accounts.index') }}"
                    class="inline-flex h-11 items-center justify-center rounded-2xl bg-slate-950 px-5 text-sm font-bold text-white shadow-lg shadow-slate-900/15 transition hover:bg-slate-800">
                    Semua Akun
                </a>
            </div>
        </div>
    </x-slot>

    @php
        $typeLabels = [
            'bank' => 'Bank',
            'cash' => 'Cash',
            'credit' => 'Kartu Kredit',
            'other' => 'E-wallet',
        ];

        $typeIcons = [
            'bank' => '<svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M3 10l9-6 9 6"/><path d="M5 10v10h14V10"/><path d="M10 14h4"/><path d="M7 20v-6"/><path d="M17 20v-6"/></svg>',
            'cash' => '<svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12v5a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-5"/><path d="M3 7h18"/><path d="M7 7v10"/><path d="M17 7v10"/><circle cx="12" cy="13" r="2"/></svg>',
            'credit' => '<svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="7" width="20" height="14" rx="3"/><path d="M2 11h20"/><path d="M6 16h2"/></svg>',
            'other' => '<svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M7 2h10a3 3 0 0 1 3 3v14a3 3 0 0 1-3 3H7a3 3 0 0 1-3-3V5a3 3 0 0 1 3-3Z"/><path d="M12 18h.01"/></svg>',
        ];

        $typeStyles = [
            'bank' => ['line' => 'from-blue-600 to-cyan-400', 'icon' => 'bg-blue-100 text-blue-700', 'badge' => 'bg-blue-50 text-blue-700 ring-blue-200', 'amount' => 'text-blue-700'],
            'cash' => ['line' => 'from-emerald-500 to-teal-400', 'icon' => 'bg-emerald-100 text-emerald-700', 'badge' => 'bg-emerald-50 text-emerald-700 ring-emerald-200', 'amount' => 'text-emerald-700'],
            'credit' => ['line' => 'from-rose-500 to-red-400', 'icon' => 'bg-rose-100 text-rose-700', 'badge' => 'bg-rose-50 text-rose-700 ring-rose-200', 'amount' => 'text-rose-700'],
            'other' => ['line' => 'from-violet-500 to-fuchsia-400', 'icon' => 'bg-violet-100 text-violet-700', 'badge' => 'bg-violet-50 text-violet-700 ring-violet-200', 'amount' => 'text-violet-700'],
        ];

        $type = $account->type ?? 'other';
        $style = $typeStyles[$type] ?? $typeStyles['other'];
        $balance = (float) $account->balance;

        if (method_exists($account, 'transactions')) {
            $recentTransactions = $account->transactions()->with(['category'])->latest('transaction_date')->take(5)->get();
            $transactionCount = $account->transactions()->count();
            $incomeTotal = $account->transactions()->where('type', 'income')->sum('amount');
            $expenseTotal = $account->transactions()->where('type', 'expense')->sum('amount');
        } else {
            $recentTransactions = collect();
            $transactionCount = 0;
            $incomeTotal = 0;
            $expenseTotal = 0;
        }
    @endphp

    <div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50 py-8">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="mb-8 flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
                <div>
                    <p class="text-xs font-bold uppercase tracking-[0.28em] text-slate-400">Wallet Detail</p>
                    <h1 class="mt-2 text-4xl font-extrabold tracking-tight text-slate-950">{{ $account->name }}</h1>
                    <p class="mt-2 text-slate-500">Pantau saldo dan aktivitas akun ini dalam satu tempat.</p>
                </div>

                <a href="{{ route('transactions.create', ['account_id' => $account->id]) }}"
                    class="inline-flex h-12 items-center justify-center gap-2 rounded-2xl bg-emerald-500 px-5 text-sm font-bold text-white shadow-lg shadow-emerald-600/20 transition hover:bg-emerald-600">
                    Tambah Transaksi
                </a>
            </div>

            <div class="grid gap-6 lg:grid-cols-[1.05fr_0.95fr]">
                <section class="relative overflow-hidden rounded-[34px] border border-white/70 bg-white/90 p-7 shadow-xl shadow-slate-900/5 ring-1 ring-slate-200/70">
                    <div class="absolute inset-y-0 left-0 w-2 bg-gradient-to-b {{ $style['line'] }}"></div>
                    <div class="absolute -right-16 -top-16 h-48 w-48 rounded-full bg-gradient-to-br {{ $style['line'] }} opacity-10 blur-xl"></div>

                    <div class="relative">
                        <div class="flex items-start justify-between gap-5">
                            <div class="flex min-w-0 items-start gap-4">
                                <div class="flex h-16 w-16 shrink-0 items-center justify-center rounded-3xl {{ $style['icon'] }} ring-8 ring-slate-50">
                                    {!! $typeIcons[$type] ?? $typeIcons['other'] !!}
                                </div>

                                <div class="min-w-0">
                                    <span class="inline-flex rounded-full px-3 py-1 text-[11px] font-bold uppercase tracking-[0.18em] ring-1 {{ $style['badge'] }}">
                                        {{ $typeLabels[$type] ?? ucfirst($type) }}
                                    </span>
                                    <h2 class="mt-3 break-words text-2xl font-extrabold text-slate-950">
                                        {{ $account->name }}
                                    </h2>
                                    <p class="mt-1 text-sm font-medium text-slate-500">
                                        Dibuat {{ optional($account->created_at)->format('d M Y') ?? '-' }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="mt-10">
                            <p class="text-xs font-bold uppercase tracking-[0.24em] text-slate-400">Saldo Saat Ini</p>
                            <p class="mt-3 text-4xl font-extrabold tracking-tight {{ $balance < 0 ? 'text-red-600' : $style['amount'] }} sm:text-5xl">
                                {{ $balance < 0 ? '-Rp' : 'Rp' }}{{ number_format(abs($balance), 0, ',', '.') }}
                            </p>
                        </div>

                        <div class="mt-8 grid gap-3 sm:grid-cols-3">
                            <div class="rounded-3xl bg-slate-50 p-4 ring-1 ring-slate-200/70">
                                <p class="text-xs font-bold text-slate-400">Transaksi</p>
                                <p class="mt-2 text-2xl font-extrabold text-slate-950">{{ $transactionCount }}</p>
                            </div>

                            <div class="rounded-3xl bg-emerald-50 p-4 ring-1 ring-emerald-100">
                                <p class="text-xs font-bold text-emerald-500">Pemasukan</p>
                                <p class="mt-2 text-lg font-extrabold text-emerald-700">
                                    Rp{{ number_format($incomeTotal, 0, ',', '.') }}
                                </p>
                            </div>

                            <div class="rounded-3xl bg-rose-50 p-4 ring-1 ring-rose-100">
                                <p class="text-xs font-bold text-rose-500">Pengeluaran</p>
                                <p class="mt-2 text-lg font-extrabold text-rose-700">
                                    Rp{{ number_format($expenseTotal, 0, ',', '.') }}
                                </p>
                            </div>
                        </div>
                    </div>
                </section>

                <section class="rounded-[34px] border border-white/70 bg-white/80 p-6 shadow-xl shadow-slate-900/5 ring-1 ring-slate-200/70">
                    <div class="flex items-center justify-between gap-4">
                        <div>
                            <p class="text-xs font-bold uppercase tracking-[0.24em] text-slate-400">Transaksi Terbaru</p>
                            <h3 class="mt-2 text-xl font-extrabold text-slate-950">Aktivitas akun</h3>
                        </div>

                        <a href="{{ route('transactions.index', ['account_id' => $account->id]) }}"
                            class="text-sm font-bold text-blue-600 transition hover:text-blue-700">
                            Lihat semua
                        </a>
                    </div>

                    <div class="mt-6 space-y-3">
                        @forelse ($recentTransactions as $transaction)
                            <div class="rounded-3xl border border-slate-200 bg-white p-4 shadow-sm">
                                <div class="flex items-center justify-between gap-4">
                                    <div class="min-w-0">
                                        <p class="truncate font-bold text-slate-950">{{ $transaction->title }}</p>
                                        <div class="mt-1 flex flex-wrap items-center gap-2 text-xs text-slate-500">
                                            <span>{{ optional($transaction->category)->name ?? 'Tanpa kategori' }}</span>
                                            <span>•</span>
                                            <span>{{ optional($transaction->transaction_date)->format('d M Y') ?? '-' }}</span>
                                        </div>
                                    </div>

                                    <p class="shrink-0 text-sm font-extrabold {{ $transaction->type === 'income' ? 'text-emerald-600' : 'text-red-600' }}">
                                        {{ $transaction->type === 'income' ? '+Rp' : '-Rp' }}{{ number_format($transaction->amount, 0, ',', '.') }}
                                    </p>
                                </div>
                            </div>
                        @empty
                            <div class="rounded-[30px] border border-dashed border-slate-300 bg-slate-50/80 p-10 text-center">
                                <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-white text-slate-400 shadow-sm ring-1 ring-slate-200">
                                    <svg class="h-7 w-7" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M4 6h16" />
                                        <path d="M4 12h10" />
                                        <path d="M4 18h7" />
                                    </svg>
                                </div>
                                <p class="mt-4 font-bold text-slate-800">Belum ada transaksi</p>
                                <p class="mt-1 text-sm text-slate-500">Mulai catat aktivitas pertama untuk akun ini.</p>
                            </div>
                        @endforelse
                    </div>
                </section>
            </div>

            <section class="mt-6 rounded-[34px] border border-white/70 bg-white/80 p-6 shadow-xl shadow-slate-900/5 ring-1 ring-slate-200/70">
                <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <p class="text-xs font-bold uppercase tracking-[0.24em] text-slate-400">Aksi Cepat</p>
                        <h3 class="mt-2 text-xl font-extrabold text-slate-950">Kelola akun ini</h3>
                    </div>

                    <div class="flex flex-col gap-3 sm:flex-row">
                        <a href="{{ route('accounts.transfer') }}"
                            class="inline-flex h-11 items-center justify-center rounded-2xl border border-slate-200 bg-white px-5 text-sm font-bold text-slate-700 transition hover:bg-slate-50">
                            Transfer
                        </a>
                        <a href="{{ route('accounts.edit', $account) }}"
                            class="inline-flex h-11 items-center justify-center rounded-2xl bg-slate-950 px-5 text-sm font-bold text-white transition hover:bg-slate-800">
                            Edit Detail
                        </a>
                    </div>
                </div>
            </section>
        </div>
    </div>
</x-app-layout>