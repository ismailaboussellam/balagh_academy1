@extends('layouts.admin')

@section('content')
<div class="min-h-screen bg-gray-100 flex">
    <!-- Sidebar -->
    <aside class="w-64 bg-white shadow-md hidden md:block">
        <div class="p-6 text-2xl font-bold text-indigo-700">Admin Panel</div>
        <nav class="mt-10">
            <a href="#" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-indigo-100 hover:text-indigo-700">Dashboard</a>
            <a href="#" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-indigo-100 hover:text-indigo-700">Users</a>
            <a href="#" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-indigo-100 hover:text-indigo-700">Exams</a>
            <a href="#" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-indigo-100 hover:text-indigo-700">Settings</a>
        </nav>
    </aside>
    <!-- Main Content -->
    <div class="flex-1 flex flex-col">
        <!-- Header -->
        <header class="bg-white shadow p-4 flex justify-between items-center">
            <h1 class="text-2xl font-semibold text-gray-800">Admin Dashboard</h1>
            <div class="flex items-center space-x-4">
                <span class="text-gray-600">{{ Auth::user()->name }}</span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">Logout</button>
                </form>
            </div>
        </header>
        <!-- Stats Cards -->
        <div class="p-6 grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white p-6 rounded shadow text-center">
                <div class="text-3xl font-bold text-indigo-600">{{ $users_count ?? 0 }}</div>
                <div class="text-gray-600">Total Users</div>
            </div>
            <div class="bg-white p-6 rounded shadow text-center">
                <div class="text-3xl font-bold text-green-600">{{ $exams_count ?? 0 }}</div>
                <div class="text-gray-600">Total Exams</div>
            </div>
            <div class="bg-white p-6 rounded shadow text-center">
                <div class="text-3xl font-bold text-yellow-600">{{ $messages_count ?? 0 }}</div>
                <div class="text-gray-600">Messages</div>
            </div>
        </div>
        <!-- Exams Table -->
        <div class="p-6">
            <div class="bg-white rounded shadow overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Exam Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($exams as $exam)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $loop->iteration }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $exam->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $exam->date }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <a href="#" class="text-indigo-600 hover:text-indigo-900">View</a>
                                <a href="#" class="ml-2 text-green-600 hover:text-green-900">Edit</a>
                                <a href="#" class="ml-2 text-red-600 hover:text-red-900">Delete</a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-center text-gray-500">No exams found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="p-4">{{ $exams->links() }}</div>
            </div>
        </div>
    </div>
</div>
@endsection