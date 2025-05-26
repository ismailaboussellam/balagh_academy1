<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\View\View;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\Auth\LoginRequest;
use Symfony\Component\HttpFoundation\JsonResponse;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login form.
     */
    public function create(): View
    {
        $captcha = session('captcha_code') ?? $this->generateCaptcha();
        session(['captcha_code' => $captcha]);
        $route = request()->route()->getName();

        if (Str::contains($route, 'admin')) {
            return view('auth.admin_login');
        } elseif (Str::contains($route, 'teacher')) {
            return view('auth.teacher_login');
        } else {
            return view('auth.student_login'); 
        }

}



    /**
     * Generate a random CAPTCHA.
     */
    private function generateCaptcha(): string
    {
        $characters = 'ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        $captcha = '';
        for ($i = 0; $i < 6; $i++) {
            $captcha .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $captcha;
    }
    public function store(Request $request)
    {
        $errors = [];
        $user = User::where('email', $request->email)->first();


        if (!$user) {
            $errors['email'] = 'Email address not found';
        } elseif (!Hash::check($request->password, $user->password)) {
            $errors['password'] = 'Incorrect password';
        }

        if (empty($errors)) {
            $inputCaptcha = trim($request->captcha);
            $sessionCaptcha = trim(session('captcha_code'));

            if (strtolower($inputCaptcha) !== strtolower($sessionCaptcha)) {
                $errors['captcha'] = 'The verification code is incorrect';

            }
        }

        if (!empty($errors)) {
            return back()->withErrors($errors)->withInput();
        }

        Auth::login($user);
        if (Auth::user()->role === 'student') {
            return redirect()->route('student.dashboard');
        } elseif (Auth::user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        } elseif (Auth::user()->role === 'teacher') {
            return redirect()->route('teacher.dashboard');

        } 
        else {
            return redirect()->route('select_login');
        }
    }

    /**
     * Refresh the CAPTCHA code.
     */
    public function refreshCaptcha(Request $request): JsonResponse
    {
        $captcha = $this->generateCaptcha();
        $request->session()->put('captcha_code', $captcha);

        return response()->json(['captcha' => $captcha]);
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
