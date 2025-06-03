<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            تعليقات الدرس: {{ $lesson->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <!-- زر العودة المعدل -->
                <a href="{{ route('teacher.lessons.show', [$subject->id, $lesson->id]) }}"
                   class="bg-gray-600 text-white px-4 py-2 rounded mb-6 inline-block hover:bg-gray-700 transition duration-200">
                    العودة إلى الدرس
                </a>

                @if (session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="space-y-4">
                    @if ($comments->count())
                        @foreach ($comments as $comment)
                            <div class="p-4 bg-gray-100 rounded-lg">
                                <p class="text-sm font-semibold">{{ $comment->user->first_name }} {{ $comment->user->last_name }} ({{ $comment->user->role === 'teacher' ? 'أستاذ' : 'طالب' }}):</p>
                                <p class="text-sm text-gray-600">{{ $comment->content }}</p>
                                @if ($comment->teacher_response)
                                    <p class="text-sm text-indigo-600 mt-2">رد الأستاذ: {{ $comment->teacher_response }}</p>
                                @else
                                    <form action="{{ route('teacher.comments.reply', $comment) }}" method="POST" class="mt-2">
                                        @csrf
                                        <textarea name="teacher_response" class="w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 h-16" placeholder="أضف ردًا"></textarea>
                                        <button type="submit" class="mt-2 bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700 transition duration-300">
                                            إرسال الرد
                                        </button>
                                    </form>
                                @endif
                            </div>
                        @endforeach
                    @else
                        <p class="text-sm text-gray-600">لا توجد تعليقات بعد.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
