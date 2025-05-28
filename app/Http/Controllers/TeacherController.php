<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Lesson;
use App\Models\Subject;
use App\Models\UserTeacher;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;

class TeacherController extends Controller
{
    public function dashboard()
    {
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
            'specialization' => 'nullable|string|max:255',
            'bio' => 'nullable|string',
        ]);

        $user = User::create([
            'first_name' => $request->first_name,
            'last_name'  => $request->last_name,
            'email'      => $request->email,
            'phone'      => $request->phone,
            'role'  => 'teacher',
            'password'   => Hash::make($request->password),
        ]);

        UserTeacher::create([
            'user_id' => $user->id,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'phone' => $request->phone,
            'specialization' => $request->specialization,
            'bio' => $request->bio,
        ]);

        event(new Registered($user));
        Auth::login($user);

        return redirect()->route('teacher.dashboard')->with('success', 'Teacher registered successfully!');
    }

    // List subjects (courses)
    public function subjects()
    {
        $subjects = Subject::where('teacher_id', Auth::id())->get();
        return view('teacher.subjects.index', compact('subjects'));
    }

    // Show create subject form
    public function createSubject()
    {
        return view('teacher.subjects.create');
    }

    // Store subject
    public function storeSubject(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Subject::create([
            'teacher_id' => Auth::id(),
            'name' => $request->name,
        ]);

        return redirect()->route('teacher.subjects')->with('success', 'الدورة تم إنشاؤها بنجاح!');
    }

    // Show edit subject form
    public function editSubject(Subject $subject)
    {
        if ($subject->teacher_id !== Auth::id()) {
            abort(403, 'غير مصرح لك بتعديل هذه الدورة');
        }
        return view('teacher.subjects.edit', compact('subject'));
    }

    // Update subject
    public function updateSubject(Request $request, Subject $subject)
    {
        if ($subject->teacher_id !== Auth::id()) {
            abort(403, 'غير مصرح لك بتعديل هذه الدورة');
        }

        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $subject->update([
            'name' => $request->name,
        ]);

        return redirect()->route('teacher.subjects')->with('success', 'تم تحديث الدورة بنجاح!');
    }

    // Delete subject
    public function deleteSubject(Subject $subject)
    {
        if ($subject->teacher_id !== Auth::id()) {
            abort(403, 'غير مصرح لك بحذف هذه الدورة');
        }

        $subject->delete();
        return redirect()->route('teacher.subjects')->with('success', 'تم حذف الدورة بنجاح!');
    }

    // Show subject details (with lessons)
    public function showSubject(Subject $subject)
    {
        if ($subject->teacher_id !== Auth::id()) {
            abort(403, 'غير مصرح لك بمشاهدة هذه الدورة');
        }
        $lessons = $subject->lessons;
        return view('teacher.subjects.show', compact('subject', 'lessons'));
    }

    public function createLesson(Subject $subject)
{
    if ($subject->teacher_id !== Auth::id()) {
        abort(403, 'غير مصرح لك');
    }
    return view('teacher.lessons.create', compact('subject'));
}

public function storeLesson(Request $request, Subject $subject)
{
    if ($subject->teacher_id !== Auth::id()) {
        abort(403, 'غير مصرح لك');
    }
    $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'video_url' => 'nullable|url', // لروابط YouTube
    ]);

    $lesson = Lesson::create([
        'subject_id' => $subject->id,
        'teacher_id' => Auth::id(),
        'title' => $request->title,
        'description' => $request->description,
    ]);

    if ($request->filled('video_url')) {
        $lesson->videos()->create([
            'video_url' => $request->video_url,
        ]);
    }

    return redirect()->route('teacher.subjects.show', $subject)->with('success', 'تم إنشاء الدرس بنجاح!');
}

}
