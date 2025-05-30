<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            إضافة امتحان جديد
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <!-- فورم إضافة الامتحان -->
                    <form method="POST" action="{{ route('teacher.exams.store', $subject) }}">
                        @csrf

                        <!-- عنوان الامتحان -->
                        <div class="mb-4">
                            <label for="title" class="block text-sm font-medium text-gray-700">عنوان الامتحان</label>
                            <input type="text" name="title" id="title" value="{{ old('title') }}"
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            @error('title')
                                <span class="text-red-600 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- تاريخ الامتحان -->
                        <div class="mb-4">
                            <label for="exam_date" class="block text-sm font-medium text-gray-700">تاريخ الامتحان</label>
                            <input type="date" name="exam_date" id="exam_date" value="{{ old('exam_date') }}"
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            @error('exam_date')
                                <span class="text-red-600 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- وصف الامتحان -->
                        <div class="mb-4">
                            <label for="description" class="block text-sm font-medium text-gray-700">وصف الامتحان (اختياري)</label>
                            <textarea name="description" id="description" rows="4"
                                      class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">{{ old('description') }}</textarea>
                            @error('description')
                                <span class="text-red-600 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- زر الإرسال -->
                        <div class="flex justify-end">
                            <button type="submit"
                                    class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                إضافة الامتحان
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
