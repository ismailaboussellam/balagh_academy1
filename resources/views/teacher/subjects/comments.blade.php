<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            تعليقات الدورة: {{ $subject->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <!-- زر العودة للدورة -->
                <a href="{{ route('teacher.subjects.show', $subject) }}"
                   class="bg-gray-600 text-white px-4 py-2 rounded mb-6 inline-block hover:bg-gray-700 transition duration-200">
                    العودة إلى الدورة
                </a>

                @if (session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                        {{ session('success') }}
                    </div>
                @endif

                <!-- عرض الدروس كـ Cards -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @forelse ($lessons as $lesson)
                        <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                            <!-- صورة الدرس -->
                            @if ($lesson->image_path)
                                <img src="{{ asset('storage/' . $lesson->image_path) }}" alt="{{ $lesson->title }}" class="w-full h-48 object-cover">
                            @else
                                <img src="{{ asset('storage/lesson_images/default.jpg') }}" alt="{{ $lesson->title }}" class="w-full h-48 object-cover">
                            @endif
                            <div class="p-4 text-center">
                                <h4 class="text-md font-semibold text-gray-800 mb-3">تعليقات درس: {{ $lesson->title }}</h4>
                                <div class="flex justify-center">
                                    <a href="{{ route('teacher.comments.index', [$subject->id, $lesson->id]) }}"
                                       class="bg-gray-600 text-white px-3 py-1 rounded hover:bg-gray-700 transition duration-300">
                                        عرض التعليقات
                                    </a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-600">لا توجد دروس بعد.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
