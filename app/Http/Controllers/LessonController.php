<?php
namespace App\Http\Controllers;

use App\Models\Lesson;
use App\Models\User;
use Illuminate\Http\Request;

class LessonController extends Controller
{
    public function index()
    {
        $lessons = Lesson::with(['teacher', 'student'])->get();
        return view('admin.lessons.index', compact('lessons'));
    }

    public function create()
    {
        $students = User::where('role', 'student')->get();
        $teachers = User::where('role', 'teacher')->get();
        return view('admin.lessons.create', compact('students', 'teachers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'video_url' => 'nullable|url',
            'teacher_id' => 'required|exists:users,id',
            'student_id' => 'required|exists:users,id',
        ]);

        Lesson::create($validated);
        return redirect()->route('lessons.index')->with('success', 'Lesson added successfully!');
    }

    public function edit(Lesson $lesson)
    {
        $students = User::where('role', 'student')->get();
        $teachers = User::where('role', 'teacher')->get();
        return view('admin.lessons.edit', compact('lesson', 'students', 'teachers'));
    }

    public function update(Request $request, Lesson $lesson)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'video_url' => 'nullable|url',
            'teacher_id' => 'required|exists:users,id',
            'student_id' => 'required|exists:users,id',
        ]);

        $lesson->update($validated);
        return redirect()->route('lessons.index')->with('success', 'Lesson updated!');
    }

    public function destroy(Lesson $lesson)
    {
        $lesson->delete();
        return redirect()->route('lessons.index')->with('success', 'Lesson deleted.');
    }
}
