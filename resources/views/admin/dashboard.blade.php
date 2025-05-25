{{-- resources/views/admin/dashboard.blade.php --}}
@extends('layouts.admin')

@section('content')
<div class="p-6 space-y-8">
    <h1 class="text-3xl font-bold">Admin Dashboard</h1>

    {{-- Lessons Section --}}
    <div>
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-2xl font-semibold">Lessons</h2>
            <button onclick="openModal('lessonModal')" class="bg-green-600 text-white px-4 py-2 rounded">+ Add Lesson</button>
        </div>
        <div class="overflow-x-auto">
            <table class="table-auto w-full bg-white shadow rounded">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2">Title</th>
                        <th class="px-4 py-2">Student</th>
                        <th class="px-4 py-2">Teacher</th>
                        <th class="px-4 py-2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($lessons as $lesson)
                    <tr class="border-b">
                        <td class="px-4 py-2">{{ $lesson->title }}</td>
                        <td class="px-4 py-2">{{ $lesson->student->first_name }} {{ $lesson->student->last_name }}</td>
                        <td class="px-4 py-2">{{ $lesson->teacher->first_name }} {{ $lesson->teacher->last_name }}</td>
                        <td class="px-4 py-2 space-x-2">
                            <button onclick="editLesson({{ Js::from($lesson) }})" class="text-blue-500">Edit</button>
                            <form action="{{ route('admin.lessons.destroy', $lesson) }}" method="POST" class="inline">
                                @csrf @method('DELETE')
                                <button type="submit" onclick="return confirm('Are you sure you want to delete this lesson?')" class="text-red-500">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-4 py-2 text-center">No lessons found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $lessons->links() }}
    </div>

    {{-- Exams Section --}}
    <div>
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-2xl font-semibold">Exams</h2>
            <button onclick="openModal('examModal')" class="bg-green-600 text-white px-4 py-2 rounded">+ Add Exam</button>
        </div>
        <div class="overflow-x-auto">
            <table class="table-auto w-full bg-white shadow rounded">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2">Title</th>
                        <th class="px-4 py-2">Lesson</th>
                        <th class="px-4 py-2">Student</th>
                        <th class="px-4 py-2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($evaluations as $evaluation)
                    <tr class="border-b">
                        <td class="px-4 py-2">{{ $evaluation->title }}</td>
                        <td class="px-4 py-2">{{ optional($evaluation->lesson)->title ?? 'No Lesson Assigned' }}</td>
                        <td class="px-4 py-2">{{ $evaluation->student->first_name }} {{ $evaluation->student->last_name }}</td>
                        <td class="px-4 py-2 space-x-2">
                            <button onclick="editExam({{ Js::from($evaluation) }})" class="text-blue-500">Edit</button>
                            <form action="{{ route('admin.exams.destroy', $evaluation) }}" method="POST" class="inline">
                                @csrf @method('DELETE')
                                <button type="submit" onclick="return confirm('Are you sure you want to delete this exam?')" class="text-red-500">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-4 py-2 text-center">No exams found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $evaluations->links() }}
    </div>
</div>

{{-- Lesson Modal --}}
<div id="lessonModal" class="hidden fixed inset-0 bg-black bg-opacity-30 flex items-center justify-center" role="dialog" aria-labelledby="lessonModalTitle">
    <div class="bg-white rounded-lg w-1/2 p-6">
        <h3 id="lessonModalTitle" class="text-xl font-bold mb-4">Add Lesson</h3>
        <form id="lessonForm" method="POST" action="{{ route('admin.lessons.store') }}" class="space-y-4">
            @csrf
            <input type="hidden" name="_method" id="lessonFormMethod" value="POST">

            <div>
                <label class="block">Title</label>
                <input type="text" name="title" id="lessonTitle" class="w-full border p-2" required>
                @error('title')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label class="block">Description</label>
                <textarea name="description" id="lessonDescription" class="w-full border p-2"></textarea>
                @error('description')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label class="block">Video URL</label>
                <input type="url" name="video_url" id="lessonVideoUrl" class="w-full border p-2">
                @error('video_url')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label class="block">Student</label>
                <select name="student_id" id="lessonStudent" class="w-full border p-2" required>
                    <option value="">-- Select Student --</option>
                    @foreach($students as $student)
                        <option value="{{ $student->id }}">{{ $student->first_name }} {{ $student->last_name }}</option>
                    @endforeach
                </select>
                @error('student_id')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label class="block">Teacher</label>
                <select name="teacher_id" id="lessonTeacher" class="w-full border p-2" required>
                    <option value="">-- Select Teacher --</option>
                    @foreach($teachers as $teacher)
                        <option value="{{ $teacher->id }}">{{ $teacher->first_name }} {{ $teacher->last_name }}</option>
                    @endforeach
                </select>
                @error('teacher_id')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="flex justify-end space-x-2">
                <button type="button" onclick="closeModal('lessonModal')" class="px-4 py-2 bg-gray-500 text-white rounded">Cancel</button>
                <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded">Save</button>
            </div>
        </form>
    </div>
</div>

{{-- Exam Modal --}}
<div id="examModal" class="hidden fixed inset-0 bg-black bg-opacity-30 flex items-center justify-center" role="dialog" aria-labelledby="examModalTitle">
    <div class="bg-white rounded-lg w-1/2 p-6">
        <h3 id="examModalTitle" class="text-xl font-bold mb-4">Add Exam</h3>
        <form id="examForm" method="POST" action="{{ route('admin.exams.store') }}" class="space-y-4">
            @csrf
            <input type="hidden" name="_method" id="examFormMethod" value="POST">

            <div>
                <label class="block">Title</label>
                <input type="text" name="title" id="examTitle" class="w-full border p-2" required>
                @error('title')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label class="block">Description</label>
                <textarea name="description" id="examDescription" class="w-full border p-2"></textarea>
                @error('description')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label class="block">File URL</label>
                <input type="url" name="file_url" id="examFileUrl" class="w-full border p-2">
                @error('file_url')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label class="block">Lesson (optional)</label>
                <select name="lesson_id" id="examLesson" class="w-full border p-2">
                    <option value="">-- Select Lesson --</option>
                    @foreach($lessons as $lesson)
                        <option value="{{ $lesson->id }}">{{ $lesson->title }}</option>
                    @endforeach
                </select>
                @error('lesson_id')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label class="block">Student</label>
                <select name="student_id" id="examStudent" class="w-full border p-2" required>
                    <option value="">-- Select Student --</option>
                    @foreach($students as $student)
                        <option value="{{ $student->id }}">{{ $student->first_name }} {{ $student->last_name }}</option>
                    @endforeach
                </select>
                @error('student_id')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="flex justify-end space-x-2">
                <button type="button" onclick="closeModal('examModal')" class="px-4 py-2 bg-gray-500 text-white rounded">Cancel</button>
                <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded">Save</button>
            </div>
        </form>
    </div>
</div>

{{-- JavaScript Helpers --}}
@push('scripts')
<script>
function openModal(id) {
    document.getElementById(id).classList.remove('hidden');
    if (id === 'lessonModal') {
        document.getElementById('lessonForm').reset();
        document.getElementById('lessonModalTitle').innerText = 'Add Lesson';
        document.getElementById('lessonFormMethod').value = 'POST';
        document.getElementById('lessonForm').action = "{{ route('admin.lessons.store') }}";
    } else if (id === 'examModal') {
        document.getElementById('examForm').reset();
        document.getElementById('examModalTitle').innerText = 'Add Exam';
        document.getElementById('examFormMethod').value = 'POST';
        document.getElementById('examForm').action = "{{ route('admin.exams.store') }}";
    }
}

function closeModal(id) {
    document.getElementById(id).classList.add('hidden');
}

function editLesson(lesson) {
    openModal('lessonModal');
    document.getElementById('lessonModalTitle').innerText = 'Edit Lesson';
    document.getElementById('lessonForm').action = `/admin/lessons/${lesson.id}`;
    document.getElementById('lessonFormMethod').value = 'PUT';
    document.getElementById('lessonTitle').value = lesson.title || '';
    document.getElementById('lessonDescription').value = lesson.description || '';
    document.getElementById('lessonVideoUrl').value = lesson.video_url || '';
    document.getElementById('lessonStudent').value = lesson.student_id || '';
    document.getElementById('lessonTeacher').value = lesson.teacher_id || '';
}

function editExam(exam) {
    openModal('examModal');
    document.getElementById('examModalTitle').innerText = 'Edit Exam';
    document.getElementById('examForm').action = `/admin/exams/${exam.id}`;
    document.getElementById('examFormMethod').value = 'PUT';
    document.getElementById('examTitle').value = exam.title || '';
    document.getElementById('examDescription').value = exam.description || '';
    document.getElementById('examFileUrl').value = exam.file_url || '';
    document.getElementById('examLesson').value = exam.lesson_id || '';
    document.getElementById('examStudent').value = exam.student_id || '';
}
</script>
@endpush
@endsection
