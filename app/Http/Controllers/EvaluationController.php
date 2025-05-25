<?php
namespace App\Http\Controllers;

use App\Models\Evaluation;
use App\Models\Lesson;
use App\Models\User;
use Illuminate\Http\Request;

class EvaluationController extends Controller
{
    public function index()
    {
        $exams = Evaluation::with(['lesson', 'student'])->get();
        return view('admin.exams.index', compact('exams'));
    }

    public function create()
    {
        $students = User::where('role', 'student')->get();
        $lessons = Lesson::all();
        return view('admin.exams.create', compact('students', 'lessons'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'file_url' => 'nullable|url',
            'student_id' => 'required|exists:users,id',
            'lesson_id' => 'nullable|exists:lessons,id',
        ]);

        Evaluation::create($validated);
        return redirect()->route('exams.index')->with('success', 'Exam created.');
    }

    public function edit(Evaluation $exam)
    {
        $students = User::where('role', 'student')->get();
        $lessons = Lesson::all();
        return view('admin.exams.edit', compact('exam', 'students', 'lessons'));
    }

    public function update(Request $request, Evaluation $exam)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'file_url' => 'nullable|url',
            'student_id' => 'required|exists:users,id',
            'lesson_id' => 'nullable|exists:lessons,id',
        ]);

        $exam->update($validated);
        return redirect()->route('exams.index')->with('success', 'Exam updated.');
    }

    public function destroy(Evaluation $exam)
    {
        $exam->delete();
        return redirect()->route('exams.index')->with('success', 'Exam deleted.');
    }
}
