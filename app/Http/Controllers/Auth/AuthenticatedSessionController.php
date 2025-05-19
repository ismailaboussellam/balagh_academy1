<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login form.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // Attempt to authenticate the user
        $request->authenticate();

        // Regenerate session to prevent session fixation
        $request->session()->regenerate();

        // Get authenticated user
        $user = Auth::user();

        // Redirect based on the user type (column is "type")
        switch ($user->user_type) {
            case 'admin':
                return redirect()->route('admin.dashboard');
            case 'ostad':
                return redirect()->route('ostad.dashboard');
            case 'talib':
                return redirect()->route('student.dashboard');
            case 'ab':
                return redirect()->route('ab.dashboard');
            default:
                return redirect()->route('dashboard'); // fallback
        }
    }

    /**
     * Logout and destroy the session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
