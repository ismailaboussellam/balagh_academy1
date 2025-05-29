<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Lesson;
use App\Models\Subject;
use App\Models\UserTeacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;

class TeacherController extends Controller
{
    public function dashboard()
    {
        return view('teacher.dashboard');
    }

    public function showRegisterForm()
    {
        return view('auth.teacher-register');
    }

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
            'role'       => 'teacher',
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

        return redirect()->route('teacher.dashboard')->with('success', 'تم تسجيل المدرس بنجاح!');
    }

    public function subjects()
    {
        $subjects = Subject::where('teacher_id', Auth::id())->get();
        return view('teacher.subjects.index', compact('subjects'));
    }

    public function createSubject()
    {
        return view('teacher.subjects.create');
    }

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

    public function editSubject(Subject $subject)
    {
        if ($subject->teacher_id !== Auth::id()) {
            abort(403, 'غير مصرح لك بتعديل هذه الدورة');
        }
        return view('teacher.subjects.edit', compact('subject'));
    }

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

    public function deleteSubject(Subject $subject)
    {
        if ($subject->teacher_id !== Auth::id()) {
            abort(403, 'غير مصرح لك بحذف هذه الدورة');
        }

        $subject->delete();
        return redirect()->route('teacher.subjects')->with('success', 'تم حذف الدورة بنجاح!');
    }

    public function showSubject(Subject $subject)
    {
        if ($subject->teacher_id !== Auth::id()) {
            abort(403, 'غير مصرح لك بمشاهدة هذه الدورة');
        }
        $lessons = $subject->lessons()->with(['videos', 'comments.user', 'evaluations.user'])->get();
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
            'video_url' => 'nullable|url',
            'video_path' => 'nullable|file|mimes:mp4|max:102400',
        ]);

        $lesson = Lesson::create([
            'subject_id' => $subject->id,
            'teacher_id' => Auth::id(),
            'title' => $request->title,
            'description' => $request->description,
        ]);

        if ($request->has('video_url') || $request->hasFile('video_path')) {
            $videoData = [];
            if ($request->filled('video_url')) {
                $videoData['video_url'] = $request->video_url;
            }
            if ($request->hasFile('video_path')) {
                $videoData['video_path'] = $request->file('video_path')->store('videos', 'public');
            }
            $lesson->videos()->create($videoData);
        }

        return redirect()->route('teacher.subjects.show', $subject)->with('success', 'تم إنشاء الدرس بنجاح!');
    }

    public function editLesson(Subject $subject, Lesson $lesson)
    {
        if ($subject->teacher_id !== Auth::id() || $lesson->teacher_id !== Auth::id()) {
            abort(403, 'غير مصرح لك');
        }
        return view('teacher.lessons.edit', compact('subject', 'lesson'));
    }

    public function updateLesson(Request $request, Subject $subject, Lesson $lesson)
    {
        if ($subject->teacher_id !== Auth::id() || $lesson->teacher_id !== Auth::id()) {
            abort(403, 'غير مصرح لك');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'video_url' => 'nullable|url',
            'video_path' => 'nullable|file|mimes:mp4|max:102400',
        ]);

        $lesson->update([
            'title' => $request->title,
            'description' => $request->description,
        ]);

        if ($request->has('video_url') || $request->hasFile('video_path')) {
            $videoData = [];
            if ($request->filled('video_url')) {
                $videoData['video_url'] = $request->video_url;
            }
            if ($request->hasFile('video_path')) {
                $videoData['video_path'] = $request->file('video_path')->store('videos', 'public');
            }

            if ($lesson->videos->count()) {
                $lesson->videos()->update($videoData);
            } else {
                $lesson->videos()->create($videoData);
            }
        }

        return redirect()->route('teacher.subjects.show', $subject)->with('success', 'تم تحديث الدرس بنجاح!');
    }

    public function deleteLesson(Subject $subject, Lesson $lesson)
    {
        if ($subject->teacher_id !== Auth::id() || $lesson->teacher_id !== Auth::id()) {
            abort(403, 'غير مصرح لك');
        }
        $lesson->delete();
        return redirect()->route('teacher.subjects.show', $subject)->with('success', 'تم حذف الدرس بنجاح!');
    }

    public function storeComment(Request $request, Subject $subject, Lesson $lesson)
    {
        if ($subject->teacher_id !== Auth::id() || $lesson->teacher_id !== Auth::id()) {
            abort(403, 'غير مصرح لك');
        }

        $request->validate([
            'content' => 'required|string',
        ]);

        $lesson->comments()->create([
            'user_id' => Auth::id(),
            'content' => $request->content,
        ]);

        return redirect()->route('teacher.subjects.show', $subject)->with('success', 'تم إضافة التعليق بنجاح!');
    }

    public function storeEvaluation(Request $request, Subject $subject, Lesson $lesson)
    {
        if ($subject->teacher_id !== Auth::id() || $lesson->teacher_id !== Auth::id()) {
            abort(403, 'غير مصرح لك');
        }

        $request->validate([
            'rating' => 'required|integer|between:1,5',
            'comment' => 'nullable|string',
        ]);

        $lesson->evaluations()->create([
            'user_id' => Auth::id(),
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return redirect()->route('teacher.subjects.show', $subject)->with('success', 'تم إضافة التقييم بنجاح!');
    }
    public function showLesson(Subject $subject, Lesson $lesson)
    {
        if ($subject->teacher_id !== Auth::id() || $lesson->teacher_id !== Auth::id()) {
            abort(403, 'غير مصرح لك');
        }
        return view('teacher.lessons.show', compact('subject', 'lesson'));
    }
}
