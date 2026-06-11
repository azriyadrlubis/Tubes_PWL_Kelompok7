@extends('layouts.app')

@section('content')
<div class="py-8 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
    <!-- Header -->
    <div class="mb-8 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Moderasi Kategori</h1>
            <p class="text-sm text-slate-500 mt-1">Kelola dan tambah kategori global SDGs untuk seluruh pengguna</p>
        </div>
        <div class="bg-emerald-50 border border-emerald-200 rounded-2xl px-4 py-2 flex items-center gap-2">
            <span class="h-2 w-2 rounded-full bg-emerald-500 animate-pulse"></span>
            <span class="text-xs font-semibold text-emerald-800">Manajemen Konten Kategori</span>
        </div>
    </div>

    <!-- Alert Success -->
    @if(session('success'))
        <div class="mb-6 p-4 bg-emerald-50 border-l-4 border-emerald-500 text-emerald-800 rounded-r-xl shadow-sm flex items-center justify-between">
            <div class="flex items-center gap-3">
                <svg class="h-5 w-5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <p class="text-sm font-medium">{{ session('success') }}</p>
            </div>
        </div>
    @endif

    <!-- Main Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Form Create Global Category (SDGs) -->
        <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-6 lg:col-span-1 h-fit">
            <h2 class="text-xl font-bold text-slate-800 mb-5">Tambah Kategori Global (SDGs)</h2>
            <form action="{{ route('auditor.categories.store') }}" method="POST" class="space-y-5">
                @csrf

                <!-- Name -->
                <div>
                    <label for="name" class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Nama Kategori</label>
                    <input type="text" id="name" name="name" required placeholder="Contoh: Energi Bersih & Terjangkau"
                        class="w-full rounded-2xl border-slate-200 px-4 py-3 text-sm focus:border-emerald-500 focus:ring-emerald-500 @error('name') border-red-500 @enderror"
                        value="{{ old('name') }}">
                    @error('name')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Type -->
                <div>
                    <label for="type" class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Tipe Kategori</label>
                    <select id="type" name="type" required
                        class="w-full rounded-2xl border-slate-200 px-4 py-3 text-sm focus:border-emerald-500 focus:ring-emerald-500">
                        <option value="expense" {{ old('type') == 'expense' ? 'selected' : '' }}>Pengeluaran (Expense)</option>
                        <option value="income" {{ old('type') == 'income' ? 'selected' : '' }}>Pemasukan (Income)</option>
                    </select>
                </div>

                <!-- Icon -->
                <div>
                    <label for="icon" class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Ikon Kategori (FontAwesome)</label>
                    <select id="icon" name="icon"
                        class="w-full rounded-2xl border-slate-200 px-4 py-3 text-sm focus:border-emerald-500 focus:ring-emerald-500">
                        <option value="leaf">Daun (SDG 13/15) - leaf</option>
                        <option value="bolt">Energi (SDG 7) - bolt</option>
                        <option value="heart-pulse">Kesehatan (SDG 3) - heart-pulse</option>
                        <option value="graduation-cap">Pendidikan (SDG 4) - graduation-cap</option>
                        <option value="droplet">Air Bersih (SDG 6) - droplet</option>
                        <option value="briefcase">Pekerjaan Layak (SDG 8) - briefcase</option>
                        <option value="globe">Kemitraan Global (SDG 17) - globe</option>
                        <option value="money-bill-wave">Uang - money-bill-wave</option>
                        <option value="piggy-bank">Celengan - piggy-bank</option>
                        <option value="chart-line">Investasi - chart-line</option>
                        <option value="hand-holding-dollar">Dana Sosial - hand-holding-dollar</option>
                        <option value="shield-halved">Perdamaian - shield-halved</option>
                        <option value="utensils">Tanpa Kelaparan (SDG 2) - utensils</option>
                        <option value="house">Kota Berkelanjutan (SDG 11) - house</option>
                        <option value="trash">Konsumsi Bertanggung Jawab (SDG 12) - trash</option>
                        <option value="lightbulb">Inovasi (SDG 9) - lightbulb</option>
                    </select>
                    <p class="text-[11px] text-slate-400 mt-1">Ikon akan dirender di sisi client menggunakan FontAwesome.</p>
                </div>

                <!-- Color -->
                <div>
                    <label for="color" class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Warna HEX Kategori</label>
                    <div class="flex gap-3 items-center">
                        <input type="color" id="color_picker"
                            class="h-11 w-14 rounded-xl border border-slate-200 p-1 cursor-pointer"
                            value="{{ old('color') ?? '#10b981' }}"
                            oninput="document.getElementById('color').value = this.value">
                        <input type="text" id="color" name="color" placeholder="#10b981" required
                            class="flex-1 rounded-2xl border-slate-200 px-4 py-3 text-sm focus:border-emerald-500 focus:ring-emerald-500 @error('color') border-red-500 @enderror"
                            value="{{ old('color') ?? '#10b981' }}"
                            oninput="document.getElementById('color_picker').value = this.value">
                    </div>
                    @error('color')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit"
                    class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-semibold py-3 px-4 rounded-2xl shadow-sm hover:shadow transition duration-150 flex items-center justify-center gap-2">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    <span>Simpan Kategori Global</span>
                </button>
            </form>
        </div>

        <!-- Global Categories List -->
        <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-6 lg:col-span-2">
            <h2 class="text-xl font-bold text-slate-800 mb-5">Daftar Kategori Global (SDGs) Aktif</h2>
            @if($globalCategories->isEmpty())
                <div class="text-center py-12 bg-slate-50 rounded-3xl border border-dashed border-slate-200">
                    <svg class="mx-auto h-12 w-12 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0a2 2 0 01-2 2H6a2 2 0 01-2-2m16 0V9a2 2 0 00-2-2M9 5h6m-6 8h6" />
                    </svg>
                    <h3 class="mt-2 text-sm font-semibold text-slate-900">Belum ada Kategori Global</h3>
                    <p class="mt-1 text-xs text-slate-500">Gunakan form di samping untuk membuat kategori global pertama.</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-slate-700">
                        <thead class="text-xs font-semibold text-slate-400 uppercase tracking-wider bg-slate-50">
                            <tr>
                                <th class="px-6 py-4 rounded-l-2xl">Nama Kategori</th>
                                <th class="px-6 py-4">Tipe</th>
                                <th class="px-6 py-4">Ikon</th>
                                <th class="px-6 py-4 rounded-r-2xl">Kode Warna</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach($globalCategories as $category)
                                <tr class="hover:bg-slate-50 transition duration-150">
                                    <td class="px-6 py-4 font-semibold text-slate-800">{{ $category->name }}</td>
                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium {{ $category->type === 'income' ? 'bg-green-50 text-green-700' : 'bg-rose-50 text-rose-700' }}">
                                            {{ $category->type === 'income' ? 'Pemasukan' : 'Pengeluaran' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="inline-flex h-8 w-8 items-center justify-center rounded-lg text-white font-bold"
                                            style="background-color: {{ $category->color ?? '#6b7280' }}">
                                            <i class="fa-solid fa-{{ $category->icon ?? 'tag' }}"></i>
                                        </span>
                                        <span class="text-xs text-slate-500 ml-2">fa-{{ $category->icon ?? 'tag' }}</span>
                                    </td>
                                    <td class="px-6 py-4 font-mono text-xs text-slate-600">{{ $category->color }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
