<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Validation\ValidationException;

class AuditorLoginController extends Controller
{
    /**
     * Tampilkan formulir login khusus auditor.
     */
    public function create(): View
    {
        return view('auth.auditor-login');
    }

    /**
     * Proses autentikasi masuk auditor.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);

        // Cek secara proaktif jika email terdaftar tapi bukan auditor
        $email = $request->input('email');
        $preCheckUser = \App\Models\User::where('email', $email)->first();

        if ($preCheckUser && !$preCheckUser->isAuditor()) {
            throw ValidationException::withMessages([
                'email' => 'Akses ditolak. Halaman login ini hanya dikhususkan untuk akun Auditor.',
            ]);
        }

        if (Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended(route('auditor.dashboard', absolute: false));
        }

        throw ValidationException::withMessages([
            'email' => __('auth.failed'),
        ]);
    }
}
