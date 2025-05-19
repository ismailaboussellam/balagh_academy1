<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;

class FatherController extends Controller
{
    // Show the father registration form
    public function showRegisterForm()
    {
        return view('auth.father-register');
    }

    // Handle father registration
    public function register(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'email'      => 'required|string|email|max:255|unique:users',
            'phone'      => 'required|string|max:20',
            'password'   => 'required|string|confirmed|min:8',
        ]);

        $user = User::create([
            'first_name' => $request->first_name,
            'last_name'  => $request->last_name,
            'email'      => $request->email,
            'phone'      => $request->phone,
            'user_type'  => 'ab', // or 'father' as you prefer
            'password'   => Hash::make($request->password),
        ]);

        event(new Registered($user));
        Auth::login($user);

        return redirect()->route('father.dashboard')->with('success', 'تم تسجيل الأب بنجاح!');
    }

    // Login father using child's code
    public function loginWithCode(Request $request)
    {
        $request->validate(['code' => 'required|string']);
        $child = User::where('code', $request->code)->first();
        if ($child) {
            // Show child's data or link father to child
            return view('dashboard.father_dashboard', compact('child'));
        } else {
            return back()->withErrors(['code' => 'الكود غير صحيح']);
        }
    }
}
