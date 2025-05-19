<?php
namespace App\Http\Controllers;

use App\Models\Lesson;
use App\Models\User; // Assuming you may need to assign a teacher
use Illuminate\Http\Request;

class LessonController extends Controller
{
    public function index()
    {
        $lessons = Lesson::with('teacher')->get(); // Assuming lessons have a 'teacher' relationship
        return view('lessons.index', compact('lessons'));
    }

    public function create()
    {
        $teachers = User::where('role', 'teacher')->get(); // Get all teachers
        return view('lessons.create', compact('teachers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'teacher_id' => 'required|exists:users,id',
        ]);

        Lesson::create($validated);

        return redirect()->route('lessons.index')->with('success', 'Lesson created successfully!');
    }

    public function show(Lesson $lesson)
    {
        return view('lessons.show', compact('lesson'));
    }

    public function edit(Lesson $lesson)
    {
        $teachers = User::where('role', 'teacher')->get(); // Get all teachers
        return view('lessons.edit', compact('lesson', 'teachers'));
    }

    public function update(Request $request, Lesson $lesson)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'teacher_id' => 'required|exists:users,id',
        ]);

        $lesson->update($validated);
        return redirect()->route('lessons.index')->with('success', 'Lesson updated successfully!');
    }

    public function destroy(Lesson $lesson)
    {
        $lesson->delete();
        return redirect()->route('lessons.index')->with('success', 'Lesson deleted successfully!');
    }
}
