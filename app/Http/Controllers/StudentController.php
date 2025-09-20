<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserStudent;
use App\Models\Lesson;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;

class StudentController extends Controller
{
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'email'      => 'required|string|email|max:255|unique:users',
            'phone'      => 'required|string|max:20',
            'password'   => 'required|string|confirmed|min:8',
        ]);

        $code = strtoupper(Str::random(8)); // Generate unique code

        // 1️⃣ Create user in "users" table
        $user = User::create([
            'first_name' => $request->first_name,
            'last_name'  => $request->last_name,
            'email'      => $request->email,
            'phone'      => $request->phone,
            'role'       => 'student',
            'password'   => Hash::make($request->password),
            'code'       => $code,
        ]);

        // 2️⃣ Create student profile in "user_students" table
        $studentProfile = UserStudent::create([
            'user_id'         => $user->id,
            'first_name'      => $request->first_name,
            'last_name'       => $request->last_name,
            'email'           => $request->email,
            'phone_code'      => $request->phone_code ?? null,
            'phone'           => $request->phone,
            'gender'          => $request->gender ?? null,
            'birth_day'       => $request->birth_day ?? null,
            'birth_month'     => $request->birth_month ?? null,
            'birth_year'      => $request->birth_year ?? null,
            'nationality'     => $request->nationality ?? null,
            'residence_country' => $request->residence_country ?? null,
            'domain'          => $request->domain ?? null,
            'fi2a'            => $request->fi2a ?? null,
            'password'        => Hash::make($request->password), // can hash again or reuse $user->password
        ]);

        event(new Registered($user));
        Auth::login($user);

        return redirect()->route('student.dashboard');
    }

    public function dashboard()
    {
        return view('dashboard.student_dashboard');
    }

    public function lessons()
    {
        $lessons = Lesson::latest()->get();
        return view('student.student_lesson', compact('lessons'));
    }

    public function showLesson($id)
    {
        $lesson = Lesson::findOrFail($id);
        return view('student.lesson_show', compact('lesson'));
    }

    public function exams()
    {
        return view('student.student_exam');
    }

    public function notifications()
    {
        return view('student.student_notification');
    }
}
