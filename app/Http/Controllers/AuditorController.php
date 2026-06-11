<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Transaction;
use App\Models\SavingsGoals;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Http\Request;

class AuditorController extends Controller
{
    /**
     * Tampilkan Dashboard Auditor dengan data statistik dan pengelolaan kategori global.
     */
    public function dashboard()
    {
        $totalUsers = User::where('role', 'user')->count();
        $totalTransactions = Transaction::count();
        $globalSavings = SavingsGoals::sum('current_amount');

        // Ambil semua kategori global (user_id IS NULL)
        $globalCategories = Category::whereNull('user_id')
            ->orderBy('name')
            ->get();

        return view('auditor.dashboard', compact(
            'totalUsers',
            'totalTransactions',
            'globalSavings',
            'globalCategories'
        ));
    }

    /**
     * Menyimpan kategori global baru (SDGs) dengan user_id = null.
     */
    public function storeCategory(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:100|unique:categories,name,NULL,id,user_id,NULL',
            'type' => 'required|in:expense,income',
            'icon' => 'nullable|string|max:50',
            'color' => 'nullable|string|regex:/^#[0-9A-Fa-f]{6}$/',
        ], [
            'name.unique' => 'Nama kategori global ini sudah ada.',
            'color.regex' => 'Format warna HEX tidak valid (harus diawali dengan # diikuti 6 digit heksadesimal).',
        ]);

        Category::create(array_merge($data, ['user_id' => null]));

        return redirect()->route('auditor.dashboard')->with('success', 'Kategori global (SDGs) berhasil ditambahkan.');
    }

    /**
     * Halaman moderasi seluruh tag sistem.
     */
    public function tags()
    {
        $tags = Tag::with('user')
            ->withCount('transactions')
            ->orderBy('name')
            ->get();

        return view('auditor.tags', compact('tags'));
    }

    /**
     * Menghapus tag dari database (moderasi).
     */
    public function destroyTag(Tag $tag)
    {
        $name = $tag->name;
        $tag->delete();

        return redirect()->route('auditor.tags.index')
            ->with('success', 'Tag "' . $name . '" berhasil dihapus secara sistem-wide.');
    }
}
