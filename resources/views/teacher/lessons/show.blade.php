<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            تفاصيل الدرس: {{ $lesson->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                @if (session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                        {{ session('success') }}
                    </div>
                @endif
                <!-- العنوان -->
                <h3 class="text-2xl font-bold text-gray-800 mb-6">{{ $lesson->title }}</h3>

                <!-- الفيديو -->
                <div class="mb-6">
                    @if ($lesson->videos->count())
                        @foreach ($lesson->videos as $video)
                            @if ($video->video_path)
                                <video id="lessonVideo{{ $lesson->id }}" width="100%" controls class="rounded-lg mb-2">
                                    <source src="{{ asset('storage/' . $video->video_path) }}" type="video/mp4">
                                    المتصفح لا يدعم تشغيل الفيديو.
                                </video>
                                <button onclick="document.getElementById('lessonVideo{{ $lesson->id }}').requestFullscreen()" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition duration-300">
                                    تكبير الفيديو
                                </button>
                            @elseif ($video->video_url)
                                <iframe width="100%" height="315" src="{{ $video->video_url }}" frameborder="0" allowfullscreen class="rounded-lg mb-2"></iframe>
                            @endif
                        @endforeach
                    @else
                        <p class="text-gray-600">لا يوجد فيديو متاح.</p>
                    @endif
                </div>

                <!-- الوصف -->
                <div class="flex items-start space-x-3 mb-6">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <div>
                        <h4 class="text-lg font-semibold text-gray-700">الوصف</h4>
                        <p class="text-gray-600 leading-relaxed">{{ $lesson->description ?? 'لا يوجد وصف' }}</p>
                    </div>
                </div>

                <!-- رابط الفيديو -->
                <div class="flex items-start space-x-3 mb-6">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <div>
                        <h4 class="text-lg font-semibold text-gray-700">رابط الفيديو</h4>
                        @if ($lesson->videos->first()->video_url ?? false)
                            <a href="{{ $lesson->videos->first()->video_url }}" target="_blank" class="text-indigo-600 hover:underline">{{ $lesson->videos->first()->video_url }}</a>
                        @else
                            <p class="text-gray-600">لا يوجد رابط فيديو</p>
                        @endif
                    </div>
                </div>

                <!-- الإجراءات -->
                <div class="flex items-start space-x-3 mb-6">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <div>
                        <h4 class="text-lg font-semibold text-gray-700">الإجراءات</h4>
                        <div class="space-y-2 mt-2">
                            <a href="{{ route('teacher.lessons.edit', [$subject, $lesson]) }}" class="block bg-blue-600 text-white px-4 py-2 rounded text-center hover:bg-blue-700 transition duration-300">تعديل</a>
                            <form action="{{ route('teacher.lessons.delete', [$subject, $lesson]) }}" method="POST" onsubmit="return confirm('هل أنت متأكد من حذف الدرس؟')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="block w-full bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 transition duration-300">حذف</button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- التعليقات -->
                <div class="flex items-start space-x-3 mb-6">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                    </svg>
                    <div class="w-full">
                        <h4 class="text-lg font-semibold text-gray-700">التعليقات</h4>
                        <div class="mt-2 space-y-4 max-h-96 overflow-y-auto">
                            @if ($lesson->comments->count())
                                @foreach ($lesson->comments as $comment)
                                    <div class="p-4 bg-gray-100 rounded-lg">
                                        <p class="text-sm font-semibold">{{ $comment->user->first_name }} {{ $comment->user->last_name }} ({{ $comment->user->role === 'teacher' ? 'أستاذ' : 'طالب' }}):</p>
                                        <p class="text-sm text-gray-600">{{ $comment->content }}</p>
                                    </div>
                                @endforeach
                            @else
                                <p class="text-sm text-gray-600">لا توجد تعليقات</p>
                            @endif
                        </div>
                        <form action="{{ route('teacher.comments.store', [$subject, $lesson]) }}" method="POST" class="mt-4">
                            @csrf
                            <textarea name="content" class="w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 h-24" placeholder="أضف تعليقًا"></textarea>
                            @error('content')
                                <span class="text-red-600 text-sm">{{ $message }}</span>
                            @enderror
                            <div class="flex space-x-2 mt-2">
                                <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700 transition duration-300">
                                    إضافة تعليق
                                </button>
                                <!-- زر جديد لعرض التعليقات -->
                                <a href="{{ route('teacher.comments.index', [$subject->id, $lesson->id]) }}"
                                   class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700 transition duration-300">
                                    عرض التعليقات
                                </a>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- التقييمات -->
                <div class="flex items-start space-x-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.783-.57-.38-1.81.588-1.81h4.915a1 1 0 00.95-.69l1.519-4.674z" />
                    </svg>
                    <div class="w-full">
                        <h4 class="text-lg font-semibold text-gray-700">التقييمات</h4>
                        <div class="mt-2 space-y-4 max-h-96 overflow-y-auto">
                            @if ($lesson->evaluations->count())
                                @foreach ($lesson->evaluations as $evaluation)
                                    <div class="p-4 bg-gray-100 rounded-lg">
                                        <p class="text-sm font-semibold">{{ $evaluation->user->first_name }} {{ $lesson->user->last_name }} ({{ $evaluation->user->role === 'teacher' ? 'أستاذ' : 'طالب' }}):</p>
                                        <p class="text-sm text-gray-600">{{ $evaluation->rating }}/5 - {{ $evaluation->comment ?? 'لا يوجد تعليق' }}</p>
                                    </div>
                                @endforeach
                            @else
                                <p class="text-sm text-gray-600">لا توجد تقييمات</p>
                            @endif
                        </div>
                        <form action="{{ route('teacher.evaluations.store', [$subject, $lesson]) }}" method="POST" class="mt-4">
                            @csrf
                            <select name="rating" class="w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 p-2">
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                            </select>
                            <textarea name="comment" class="w-full rounded-md border-gray-300 shadow-sm mt-2 focus:ring-indigo-500 focus:border-indigo-500 h-24" placeholder="أضف تعليقًا (اختياري)"></textarea>
                            @error('rating')
                                <span class="text-red-600 text-sm">{{ $message }}</span>
                            @enderror
                            @error('comment')
                                <span class="text-red-600 text-sm">{{ $message }}</span>
                            @enderror
                            <button type="submit" class="mt-2 bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700 transition duration-300">إضافة تقييم</button>
                        </form>
                    </div>
                </div>

                <!-- زر الرجوع -->
                <a href="{{ route('teacher.subjects.show', $subject) }}" class="mt-6 inline-block bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700 transition duration-300">
                    رجوع إلى الدورة
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
