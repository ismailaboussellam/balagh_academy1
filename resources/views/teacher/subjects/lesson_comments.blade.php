<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            إدارة التعليقات - {{ $lesson->subject->name }} (الدرس: {{ $lesson->title }})
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <!-- زر العودة للدرس -->
                <a href="{{ route('teacher.lessons.show', [$lesson->subject_id, $lesson->id]) }}"
                   class="bg-gray-600 text-white px-4 py-2 rounded mb-6 inline-block hover:bg-gray-700 transition duration-200">
                    العودة إلى الدرس
                </a>

                @if (session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                        {{ session('success') }}
                    </div>
                @endif

                <!-- قائمة التعليقات -->
                <div class="space-y-6">
                    @forelse ($comments as $comment)
                        <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-sm text-gray-600">
                                    من: {{ $comment->user->name }} - {{ $comment->created_at->format('d/m/Y H:i') }}
                                </span>
                                @if ($comment->teacher_response)
                                    <span class="text-sm text-green-600">تم الرد</span>
                                @else
                                    <button type="button"
                                            data-comment-id="{{ $comment->id }}"
                                            class="reply-btn bg-indigo-600 text-white px-3 py-1 rounded hover:bg-indigo-700 transition duration-200">
                                        رد
                                    </button>
                                @endif
                            </div>
                            <p class="text-gray-800">{{ $comment->content }}</p>

                            <!-- فورم الرد (مخفي افتراضياً) -->
                            <div id="reply-form-{{ $comment->id }}" class="mt-4 hidden">
                                <form method="POST" action="{{ route('teacher.comments.reply', $comment->id) }}" class="space-y-4">
                                    @csrf
                                    <div>
                                        <label for="response-{{ $comment->id }}" class="block text-sm font-medium text-gray-700">الرد</label>
                                        <textarea name="response" id="response-{{ $comment->id }}" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required></textarea>
                                        @error('response')
                                            <span class="text-red-600 text-sm">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition duration-200">
                                        إرسال الرد
                                    </button>
                                    <button type="button" class="cancel-reply-btn bg-gray-300 text-gray-800 px-4 py-2 rounded hover:bg-gray-400 transition duration-200">
                                        إلغاء
                                    </button>
                                </form>
                            </div>

                            <!-- تاريخ المحادثات (اختياري) -->
                            @if ($comment->teacher_response)
                                <div class="mt-4 p-2 bg-white rounded border border-gray-100">
                                    <p class="text-sm text-gray-700">الرد: {{ $comment->teacher_response }}</p>
                                    <p class="text-xs text-gray-500">تم الرد في: {{ $comment->updated_at->format('d/m/Y H:i') }}</p>
                                </div>
                            @endif
                        </div>
                    @empty
                        <div class="text-center text-gray-500 py-6">
                            لا توجد تعليقات حتى الآن.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
