<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Lesson;
use App\Models\Evaluation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    public function dashboard()
    {
        $lessons = Lesson::with(['student', 'teacher'])->paginate(10);
        $exams = Evaluation::with(['student', 'lesson'])->paginate(10);
        $students = User::where('user_type', 'student')->get();
        $teachers = User::where('user_type', 'teacher')->get();
        return view('dashboard.admin_dashboard', compact('lessons', 'exams', 'students', 'teachers'));
    }

    public function storeLecon(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'video_url' => 'nullable|url',
            'student_id' => 'required|exists:users,id',
            'teacher_id' => 'required|exists:users,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        Lesson::create($request->all());

        return redirect()->route('dashboard.admin_dashboard')->with('success', 'Lesson created successfully.');
    }

    public function updateLecon(Request $request, $id)
    {
        $lesson = Lesson::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'video_url' => 'nullable|url',
            'student_id' => 'required|exists:users,id',
            'teacher_id' => 'required|exists:users,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $lesson->update($request->all());

        return redirect()->route('dashboard.admin_dashboard')->with('success', 'Lesson updated successfully.');
    }

    public function deleteLecon($id)
    {
        $lesson = Lesson::findOrFail($id);
        $lesson->delete();

        return redirect()->route('dashboard.admin_dashboard')->with('success', 'Lesson deleted successfully.');
    }

    public function storeExame(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'file_url' => 'nullable|url',
            'lesson_id' => 'nullable|exists:lessons,id',
            'student_id' => 'required|exists:users,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        Evaluation::create($request->all());

        return redirect()->route('dashboard.admin_dashboard')->with('success', 'Exam created successfully.');
    }

    public function updateExame(Request $request, $id)
    {
        $exam = Evaluation::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'file_url' => 'nullable|url',
            'lesson_id' => 'nullable|exists:lessons,id',
            'student_id' => 'required|exists:users,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $exam->update($request->all());

        return redirect()->route('dashboard.admin_dashboard')->with('success', 'Exam updated successfully.');
    }

    public function deleteExame($id)
    {
        $exam = Evaluation::findOrFail($id);
        $exam->delete();

        return redirect()->route('dashboard.admin_dashboard')->with('success', 'Exam deleted successfully.');
    }

    public function showAddLeconForm()
    {
        $students = User::where('role', 'student')->get();
        $teachers = User::where('role', 'teacher')->get();
        return view('admin.add-lecon', compact('students', 'teachers'));
    }

    public function showAddExameForm()
    {
        $students = User::where('role', 'student')->get();
        $lessons = Lesson::all();
        return view('admin.add-exame', compact('students', 'lessons'));
    }
}
