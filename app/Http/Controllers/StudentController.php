<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Lesson;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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

        $user = User::create([
            'first_name' => $request->first_name,
            'last_name'  => $request->last_name,
            'email'      => $request->email,
            'phone'      => $request->phone,
            'password'   => Hash::make($request->password),
            'code'       => $code,
        ]);

        event(new Registered($user));
        Auth::login($user);

        return redirect()->route('student.dashboard');
    }

    public function dashboard() {
        return view('dashboard.student_dashboard');
    }


    public function lessons()
    {
        // Fetch lessons from database (example)
        $lessons = Lesson::latest()->get(); // ولا دير where() إلا عندك ربط بمستوى أو فيئة معينة
        return view('student.student_lesson', compact('lessons'));
    }

    public function showLesson($id)
    {
        $lesson = Lesson::findOrFail($id);
        return view('student.lesson_show', compact('lesson'));
    }


    public function exams()
    {
        // Fetch exams from database (example)
        // $exams = Exam::where('student_id', auth()->id())->get();
        return view('student.student_exam');
    }

    public function notifications()
    {
        // Fetch notifications from database (example)
        // $notifications = Notification::where('student_id', auth()->id())->get();
        return view('student.student_notification');
    }

}
