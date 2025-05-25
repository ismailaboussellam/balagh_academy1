@extends('layouts.admin')

@section('content')
<h2 class="text-xl font-bold mb-4">All Lessons</h2>

<a href="{{ route('lessons.create') }}" class="bg-green-500 text-white px-4 py-2 rounded">+ Add Lesson</a>

<table class="table-auto w-full mt-4">
    <thead>
        <tr>
            <th>Title</th>
            <th>Student</th>
            <th>Teacher</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
    @foreach($lessons as $lesson)
        <tr>
            <td>{{ $lesson->title }}</td>
            <td>{{ $lesson->student->first_name ?? 'N/A' }}</td>
            <td>{{ $lesson->teacher->first_name ?? 'N/A' }}</td>
            <td class="space-x-2">
                <a href="{{ route('lessons.edit', $lesson) }}" class="text-blue-500">Edit</a>
                <form action="{{ route('lessons.destroy', $lesson) }}" method="POST" class="inline">
                    @csrf @method('DELETE')
                    <button type="submit" class="text-red-500">Delete</button>
                </form>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
@endsection
