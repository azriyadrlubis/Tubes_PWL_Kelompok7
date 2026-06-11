@extends('layouts.app')

@section('content')
<div class="py-8 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
    <!-- Header -->
    <div class="mb-8 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Moderasi Tag</h1>
            <p class="text-sm text-slate-500 mt-1">Hapus tag yang tidak pantas atau menyalahi aturan konten keuangan</p>
        </div>
        <div class="bg-red-50 border border-red-200 rounded-2xl px-4 py-2 flex items-center gap-2">
            <span class="h-2 w-2 rounded-full bg-red-500 animate-pulse"></span>
            <span class="text-xs font-semibold text-red-800">Moderasi Konten Aktif</span>
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

    <!-- Tags Moderation List -->
    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-6">
        <h2 class="text-xl font-bold text-slate-800 mb-5">Semua Tag Pengguna Sistem</h2>
        @if($tags->isEmpty())
            <div class="text-center py-16 bg-slate-50 rounded-3xl border border-dashed border-slate-200">
                <svg class="mx-auto h-12 w-12 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                <h3 class="mt-2 text-sm font-semibold text-slate-900">Belum ada tag</h3>
                <p class="mt-1 text-xs text-slate-500">Belum ada pengguna yang membuat tag di sistem.</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-slate-700">
                    <thead class="text-xs font-semibold text-slate-400 uppercase tracking-wider bg-slate-50">
                        <tr>
                            <th class="px-6 py-4 rounded-l-2xl">Tag</th>
                            <th class="px-6 py-4">Dibuat Oleh</th>
                            <th class="px-6 py-4">Total Penggunaan Transaksi</th>
                            <th class="px-6 py-4">Tanggal Dibuat</th>
                            <th class="px-6 py-4 rounded-r-2xl text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($tags as $tag)
                            <tr class="hover:bg-slate-50 transition duration-150">
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold text-white"
                                        style="background-color: {{ $tag->color ?? '#6b7280' }}">
                                        #{{ $tag->name }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 font-medium text-slate-800">
                                    {{ $tag->user ? $tag->user->name : 'Sistem' }}
                                    <span class="block text-xs text-slate-400 font-normal">{{ $tag->user ? $tag->user->email : '' }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="bg-slate-100 text-slate-700 text-xs font-semibold px-2.5 py-1 rounded-full">
                                        {{ $tag->transactions_count }} transaksi
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-xs text-slate-500">
                                    {{ $tag->created_at ? $tag->created_at->format('d M Y, H:i') : '-' }}
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <form action="{{ route('auditor.tags.destroy', $tag) }}" method="POST"
                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus tag \'#{{ $tag->name }}\' secara permanen dari seluruh sistem? Tindakan ini tidak dapat dibatalkan.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="inline-flex items-center gap-1 bg-red-50 text-red-600 hover:bg-red-100 font-semibold py-1.5 px-3 rounded-xl transition duration-150 text-xs">
                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                            <span>Hapus</span>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
@endsection
