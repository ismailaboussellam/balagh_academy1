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
        $evaluations = Evaluation::with('student', 'lesson')->get();
        return view('evaluations.index', compact('evaluations'));
    }

    public function create()
    {
        $students = User::where('role', 'student')->get(); // Get all students
        $lessons = Lesson::all(); // Get all lessons
        return view('evaluations.create', compact('students', 'lessons'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:users,id',
            'lesson_id' => 'required|exists:lessons,id',
            'score' => 'required|numeric|min:0|max:100',
        ]);

        Evaluation::create($validated);
        return redirect()->route('evaluations.index')->with('success', 'Evaluation created successfully!');
    }

    public function show(Evaluation $evaluation)
    {
        return view('evaluations.show', compact('evaluation'));
    }

    public function edit(Evaluation $evaluation)
    {
        $students = User::where('role', 'student')->get(); // Get all students
        $lessons = Lesson::all(); // Get all lessons
        return view('evaluations.edit', compact('evaluation', 'students', 'lessons'));
    }

    public function update(Request $request, Evaluation $evaluation)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:users,id',
            'lesson_id' => 'required|exists:lessons,id',
            'score' => 'required|numeric|min:0|max:100',
        ]);

        $evaluation->update($validated);
        return redirect()->route('evaluations.index')->with('success', 'Evaluation updated successfully!');
    }

    public function destroy(Evaluation $evaluation)
    {
        $evaluation->delete();
        return redirect()->route('evaluations.index')->with('success', 'Evaluation deleted successfully!');
    }
}
