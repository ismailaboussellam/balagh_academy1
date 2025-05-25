@extends('layouts.admin')

@section('content')
<h2 class="text-xl font-bold mb-4">Create New Lesson</h2>

<form method="POST" action="{{ route('lessons.store') }}" class="space-y-4">
    @csrf
    <input type="text" name="title" placeholder="Title" class="w-full border p-2" required>
    <textarea name="description" placeholder="Description" class="w-full border p-2"></textarea>
    <input type="url" name="video_url" placeholder="Video URL" class="w-full border p-2">

    <select name="teacher_id" class="w-full border p-2">
        @foreach($teachers as $teacher)
            <option value="{{ $teacher->id }}">{{ $teacher->first_name }}</option>
        @endforeach
    </select>

    <select name="student_id" class="w-full border p-2">
        @foreach($students as $student)
            <option value="{{ $student->id }}">{{ $student->first_name }}</option>
        @endforeach
    </select>

    <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">Save</button>
</form>
@endsection
