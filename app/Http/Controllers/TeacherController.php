<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\User;
use App\Models\Lesson;
use App\Models\Comment;
use App\Models\Subject;
use App\Models\UserTeacher;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Storage;

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
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    $subjectData = [
        'teacher_id' => Auth::id(),
        'name' => $request->name,
    ];

    // التحقق من رفع الصورة
    if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store('subject_images', 'public');
        $subjectData['image_path'] = $imagePath;

        // Debugging: عرض المسار للتحقق
        \Log::info('Image stored at: ' . $imagePath);
    } else {
        \Log::info('No image uploaded');
    }

    Subject::create($subjectData);

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
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    $subjectData = [
        'name' => $request->name,
    ];

    // التحقق من رفع الصورة
    if ($request->hasFile('image')) {
        if ($subject->image_path) {
            Storage::disk('public')->delete($subject->image_path);
        }
        $imagePath = $request->file('image')->store('subject_images', 'public');
        $subjectData['image_path'] = $imagePath;

        // Debugging: عرض المسار للتحقق
        \Log::info('Image updated at: ' . $imagePath);
    } else {
        \Log::info('No image uploaded during update');
    }

    $subject->update($subjectData);

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
        'video_path' => 'nullable|file|mimes:mp4,avi,mov|max:614400', // 600MB in KB
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // تحديث ليصبح image
        'document' => 'nullable|file|mimes:pdf,doc,docx|max:10240', // 10MB max
    ]);

    $lessonData = [
        'subject_id' => $subject->id,
        'teacher_id' => Auth::id(),
        'title' => $request->title,
        'description' => $request->description,
    ];

    // معالجة الصورة
    if ($request->hasFile('image')) {
        $lessonData['image_path'] = $request->file('image')->store('lesson_images', 'public');
    }

    $lesson = Lesson::create($lessonData);

    // معالجة الفيديو
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

    // معالجة الوثيقة
    if ($request->hasFile('document')) {
        $lessonData['document_path'] = $request->file('document')->store('documents', 'public');
        $lesson->update($lessonData); // تحديث الدرس بمسار الوثيقة
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
        'video_path' => 'nullable|file|mimes:mp4,avi,mov|max:102400',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'document' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
    ]);

    $lesson->update([
        'title' => $request->title,
        'description' => $request->description,
    ]);

    // معالجة الفيديو
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

    // معالجة الصورة
    if ($request->hasFile('image')) {
        if ($lesson->image_path) {
            Storage::disk('public')->delete($lesson->image_path);
        }
        $lesson->update(['image_path' => $request->file('image')->store('lesson_images', 'public')]);
    }

    // معالجة الوثيقة
    if ($request->hasFile('document')) {
        if ($lesson->document_path) {
            Storage::disk('public')->delete($lesson->document_path);
        }
        $lesson->update(['document_path' => $request->file('document')->store('documents', 'public')]);
    }

    return redirect()->route('teacher.subjects.show', $subject)->with('success', 'تم تحديث الدرس بنجاح!');
}

    public function deleteLesson(Subject $subject, Lesson $lesson)
    {
        if ($subject->teacher_id !== Auth::id() || $lesson->teacher_id !== Auth::id()) {
            abort(403, 'غير مصرح لك');
        }
        $lesson->delete();
        return redirect()->route('teacher.subjects.show', $subject);
    }

    public function storeComment(Request $request, Subject $subject, Lesson $lesson)
    {
        $request->validate(['content' => 'required|string']);
        $lesson->comments()->create([
            'user_id' => Auth::id(),
            'content' => $request->content,
        ]);
        return redirect()->route('teacher.lessons.show', [$subject, $lesson]);
    }

    public function storeEvaluation(Request $request, Subject $subject, Lesson $lesson)
    {
        $request->validate([
            'rating' => 'required|integer|between:1,5',
            'comment' => 'nullable|string',
        ]);
        $lesson->evaluations()->create([
            'user_id' => Auth::id(),
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);
        return redirect()->route('teacher.lessons.show', [$subject, $lesson]);
    }
    public function showLesson(Subject $subject, Lesson $lesson)
    {
        if ($subject->teacher_id !== Auth::id() || $lesson->teacher_id !== Auth::id()) {
            abort(403, 'غير مصرح لك');
        }
        return view('teacher.lessons.show', compact('subject', 'lesson'));
    }
    public function index()
{
    return view('lessons.index');
}

public function indexExams()
{
    $exams = Exam::where('teacher_id', auth()->id())->get();
    return view('teacher.exams.index', compact('exams'));
}

public function indexNotifications()
{
    return view('notifications.index');
}
public function createExam($subject)
{
    return view('teacher.exams.create', compact('subject'));
}

public function storeExam(Request $request, $subject)
{
    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'exam_date' => 'required|date',
        'description' => 'nullable|string',
        'document' => 'nullable|file|mimes:pdf,doc,docx|max:10240', // 10MB max
    ]);

    // إنشاء الامتحان في قاعدة البيانات
    $exam = new Exam();
    $exam->subject_id = $subject;
    $exam->title = $validated['title'];
    $exam->exam_date = $validated['exam_date'];
    $exam->description = $validated['description'];
    $exam->teacher_id = auth()->id();

    // معالجة الوثيقة
    if ($request->hasFile('document')) {
        $exam->document_path = $request->file('document')->store('exam_documents', 'public');
    }

    $exam->save();

    return redirect()->route('teacher.subjects.show', $subject)->with('success', 'تم إضافة الامتحان بنجاح!');
}
public function editExam($subject, Exam $exam)
{
    if ($exam->teacher_id !== auth()->id()) {
        abort(403, 'غير مصرح لك');
    }
    return view('teacher.exams.edit', compact('subject', 'exam'));
}

public function updateExam(Request $request, $subject, Exam $exam)
{
    if ($exam->teacher_id !== auth()->id()) {
        abort(403, 'غير مصرح لك');
    }

    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'exam_date' => 'required|date',
        'description' => 'nullable|string',
        'document' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
    ]);

    $exam->update([
        'title' => $validated['title'],
        'exam_date' => $validated['exam_date'],
        'description' => $validated['description'],
    ]);

    if ($request->hasFile('document')) {
        if ($exam->document_path) {
            Storage::disk('public')->delete($exam->document_path);
        }
        $exam->document_path = $request->file('document')->store('exam_documents', 'public');
        $exam->save();
    }

    return redirect()->route('teacher.exams')->with('success', 'تم تحديث الامتحان بنجاح!');
}

public function destroyExam($subject, Exam $exam)
{
    if ($exam->teacher_id !== auth()->id()) {
        abort(403, 'غير مصرح لك');
    }

    if ($exam->document_path) {
        Storage::disk('public')->delete($exam->document_path);
    }

    $exam->delete();
    return redirect()->route('teacher.exams')->with('success', 'تم حذف الامتحان بنجاح!');
}

// Affichage des commantaire
public function showLessonComments($subjectId, $lessonId)
{
    $lesson = Lesson::where('subject_id', $subjectId)->findOrFail($lessonId);
    if ($lesson->teacher_id !== Auth::id()) {
        abort(403, 'غير مصرح لك بمشاهدة هذه التعليقات');
    }

    $comments = $lesson->comments()->with('user')->get();

    return view('teacher.subjects.lesson_comments', compact('lesson', 'comments'));
}

public function replyToComment(Request $request, $commentId)
{
    $comment = Comment::findOrFail($commentId);
    if ($comment->lesson->teacher_id !== Auth::id()) {
        abort(403, 'غير مصرح لك بالرد على هذا التعليق');
    }

    $request->validate([
        'response' => 'required|string|max:1000',
    ]);

    $comment->update(['teacher_response' => $request->response]);

    return redirect()->back()->with('success', 'تم إرسال الرد بنجاح!');
}


}
