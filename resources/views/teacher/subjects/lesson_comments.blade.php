<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            تعليقات الدرس: {{ $lesson->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <!-- زر العودة -->
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
                            <div class="p-4 bg-gray-100 rounded-lg relative">
                                <p class="text-sm font-semibold">{{ $comment->user->first_name }} {{ $comment->user->last_name }} ({{ $comment->user->role === 'teacher' ? 'أستاذ' : 'طالب' }}):</p>
                                <p class="text-sm text-gray-600">{{ $comment->content }}</p>
                                @if ($comment->teacher_response)
                                    <div class="ml-4 mt-2 p-2 bg-gray-50 rounded-lg">
                                        <p class="text-sm text-indigo-600">رد الأستاذ: {{ $comment->teacher_response }}</p>
                                    </div>
                                @else
                                    <!-- زر الرد (شكل سهم يوتيوب) -->
                                    <button onclick="toggleReplyForm(this)" class="mt-2 text-blue-600 hover:text-blue-800 flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                                        </svg>
                                        رد
                                    </button>
                                    <!-- نموذج الرد (مخفي في البداية) -->
                                    <div id="reply-form-{{ $comment->id }}" class="hidden mt-2">
                                        <form action="{{ route('teacher.comments.reply', $comment) }}" method="POST" class="space-y-2">
                                            @csrf
                                            <textarea name="teacher_response" class="w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 h-16 p-2 text-sm" placeholder="اكتب ردك هنا..."></textarea>
                                            <div class="flex space-x-2">
                                                <button type="submit" class="bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700 text-sm">
                                                    إرسال
                                                </button>
                                                <button type="button" onclick="toggleReplyForm(this)" class="bg-gray-600 text-white px-3 py-1 rounded hover:bg-gray-700 text-sm">
                                                    إلغاء
                                                </button>
                                            </div>
                                        </form>
                                    </div>
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

    <!-- JavaScript لتحكم في عرض/إخفاء نموذج الرد -->
    <script>
        function toggleReplyForm(button) {
            const form = button.closest('.bg-gray-100').querySelector('div[id^="reply-form-"]');
            if (form.classList.contains('hidden')) {
                form.classList.remove('hidden');
            } else {
                form.classList.add('hidden');
            }
        }
    </script>
</x-app-layout>
