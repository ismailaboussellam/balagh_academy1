<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;

class TeacherController extends Controller
{
    public function dashboard(){
        return view('teacher.dashboard');
    }
    // Show the teacher registration form
    public function showRegisterForm()
    {
        return view('auth.teacher-register');
    }

    // Handle teacher registration
    public function register(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'email'      => 'required|string|email|max:255|unique:users',
            'phone'      => 'required|string|max:20',
            'password'   => 'required|string|confirmed|min:8',
            // Add more validation rules for additional fields if needed
        ]);

        $user = User::create([
            'first_name' => $request->first_name,
            'last_name'  => $request->last_name,
            'email'      => $request->email,
            'phone'      => $request->phone,
            'role'  => 'teacher', // or whatever value you use for teachers
            'password'   => Hash::make($request->password),
            // Add more fields if needed
        ]);

        event(new Registered($user));
        Auth::login($user);

        return redirect()->route('teacher.dashboard')->with('success', 'Teacher registered successfully!');
    }
}
