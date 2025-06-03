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
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.861h4a1 1 0 001.555-.832l3-2.132a1 1 0 000-1.664z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-9-9 9 9 0 019 9z" />
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
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.293 4.293a1 1 0 011.414 0l2 2a1 1 0 010 1.414l-2 2a1 1 0 01-1.414 0l2-2a1 1 0 010-1.414l-2-2z" />
                        <path stroke="currentColor" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <div>
                        <h4 class="text-lg font-semibold text-gray-700">الإجراءات</h4>
                        <div class="space-y-2 mt-2">
                            <a href="{{ route('teacher.lessons.edit', [$subject, $lesson]) }}" class="block bg-blue-600 text-white px-4 py-2 rounded-md text-center hover:bg-blue-700 transition duration-300">تعديل</a>
                            <form action="{{ route('teacher.lessons.delete', [$subject, $lesson]) }}" method="POST" onsubmit="return confirm('هل أنت متأكد من حذف الدرس؟')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="block w-full bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700 transition duration-300">حذف</button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- التعليقات -->
                <div class="flex items-start space-x-3 mb-6">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 0 01-2 2h-3l-4 4z" />
                    </svg>
                    <div class="w-full">
                        <h4 class="text-lg font-semibold text-gray-700 mb-3">التعليقات</h4>
                        <div class="mt-2 space-y-4 max-h-96 overflow-y-auto">
                            @if ($lesson->comments->count())
                                @foreach ($lesson->comments as $comment)
                                    <div class="p-4 bg-gray-100 rounded-lg relative">
                                        <div class="flex items-center justify-between">
                                            <p class="text-sm font-semibold">{{ $comment->user->first_name }} {{ $comment->user->last_name }} ({{ $comment->user->role === 'teacher' ? 'أستاذ' : 'Teacher' }}):</p>
                                            <!-- زر النقاط الثلاث -->
                                            @if (Auth::id() === $comment->user_id || Auth::user()->role === 'teacher')
                                                <div class="relative">
                                                    <button onclick="toggleDropdown('comment-{{ $comment->id }}')" class="text-gray-500 hover:text-gray-700">
                                                        ⁝
                                                    </button>
                                                    <div id="dropdown-comment-{{ $comment->id }}" class="hidden absolute right-0 mt-2 w-32 bg-white border border-gray-200 rounded-lg shadow-lg z-10">
                                                        @if (Auth::id() === $comment->user_id)
                                                            <!-- تعديل -->
                                                            <button onclick="toggleEditForm('edit-comment-{{ $comment->id }}')" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                                تعديل
                                                            </button>
                                                            <!-- حذف -->
                                                            <form action="{{ route('teacher.comments.delete', $comment) }}" method="POST" onsubmit="return confirm('هل أنت متأكد من حذف التعليق؟')">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
                                                                    حذف
                                                                </button>
                                                            </form>
                                                        @endif
                                                        <!-- رد (للمعلم فقط) -->
                                                        @if (Auth::user()->role === 'teacher' && !$comment->teacher_response)
                                                            <button onclick="toggleReplyForm('reply-comment-{{ $comment->id }}')" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                                رد
                                                            </button>
                                                        @endif
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                        <p class="text-sm text-gray-600 mt-1">{{ $comment->content }}</p>
                                        @if ($comment->teacher_response)
                                            <div class="ml-4 mt-2 p-2 bg-gray-50 rounded-lg">
                                                <p class="text-sm text-indigo-600">رد الأستاذ: {{ $comment->teacher_response }}</p>
                                            </div>
                                        @endif

                                        <!-- نموذج تعديل التعليق (مخفي في البداية) -->
                                        @if (Auth::id() === $comment->user_id)
                                            <div id="edit-comment-{{ $comment->id }}" class="hidden mt-2">
                                                <form action="{{ route('teacher.comments.update', $comment) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <textarea name="content" class="w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 h-16 p-2 text-sm" placeholder="عدل تعليقك هنا...">{{ $comment->content }}</textarea>
                                                    <div class="flex space-x-2 mt-2">
                                                        <button type="submit" class="bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700 text-sm">
                                                            حفظ
                                                        </button>
                                                        <button type="button" onclick="toggleEditForm('edit-comment-{{ $comment->id }}')" class="bg-gray-600 text-white px-3 py-1 rounded hover:bg-gray-700 text-sm">
                                                            إلغاء
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        @endif

                                        <!-- نموذج الرد (للمعلم فقط، مخفي في البداية) -->
                                        @if (Auth::user()->role === 'teacher' && !$comment->teacher_response)
                                            <div id="reply-comment-{{ $comment->id }}" class="hidden mt-2">
                                                <form action="{{ route('teacher.comments.reply', $comment) }}" method="POST" class="space-y-2">
                                                    @csrf
                                                    <textarea name="teacher_response" class="w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 h-16 p-2 text-sm" placeholder="اكتب ردك هنا..."></textarea>
                                                    <div class="flex space-x-2">
                                                        <button type="submit" class="bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700 text-sm">
                                                            إرسال
                                                        </button>
                                                        <button type="button" onclick="toggleReplyForm('reply-comment-{{ $comment->id }}')" class="bg-gray-600 text-white px-3 py-1 rounded hover:bg-gray-700 text-sm">
                                                            إلغاء
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        @endif
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
                            @endif
                            <div class="flex space-x-2 mt-2">
                                <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700 transition duration-300">
                                    إضافة تعليق
                                </button>
                                <a href="{{ route('teacher.comments.index', [$subject->id, $lesson->id]) }}"
                                   class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700 transition duration-300">
                                    عرض التعليقات
                                </a>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- التقييمات (تصميم مشابه لـ Google Play) -->
                <div class="flex items-start space-x-3 mb-6">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.783-.57-.38-1.81.588-1.81h4.915a1 1 0 00.95-.69l1.519-4.674z" />
                    </svg>
                    <div class="w-full">
                        <h4 class="text-lg font-semibold text-gray-700 mb-4">التقييمات</h4>

                        <!-- نموذج إضافة تقييم -->
                        <form action="{{ route('teacher.evaluations.store', [$subject, $lesson]) }}" method="POST" class="mb-6">
                            @csrf
                            <div class="flex items-center mb-2">
                                <div class="flex space-x-1">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <label class="cursor-pointer">
                                            <input type="radio" name="rating" value="{{ $i }}" class="hidden" required>
                                            <svg class="w-6 h-6 text-gray-300 hover:text-yellow-400 {{ $i <= old('rating', 0) ? 'text-yellow-400' : '' }}" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.783-.57-.38-1.81.588-1.81h4.915a1 1 0 00.95-.69l1.519-4.674z"/>
                                            </svg>
                                        </label>
                                    @endfor
                                </div>
                            </div>
                            <textarea name="comment" class="w-full rounded-md border-gray-300 shadow-sm mt-2 focus:ring-indigo-500 focus:border-indigo-500 h-24 p-2 text-sm" placeholder="اكتب تعليقك (اختياري)"></textarea>
                            @error('rating')
                                <span class="text-red-600 text-sm block">{{ $message }}</span>
                            @enderror
                            @error('comment')
                                <span class="text-red-600 text-sm block">{{ $message }}</span>
                            @enderror
                            <button type="submit" class="mt-2 bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700 transition duration-300">إضافة تقييم</button>
                        </form>

                        <!-- عرض التقييمات -->
                        <div class="space-y-4">
                            @if ($lesson->evaluations->count())
                                @foreach ($lesson->evaluations as $evaluation)
                                    <div class="border-b pb-4 relative">
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center space-x-2">
                                                <span class="text-sm font-semibold text-gray-800">
                                                    {{ $evaluation->user->first_name }} {{ $evaluation->user->last_name }}
                                                </span>
                                                <span class="text-xs text-gray-500">
                                                    ({{ $evaluation->user->role === 'teacher' ? 'أستاذ' : 'طالب' }})
                                                </span>
                                            </div>
                                            <!-- زر النقاط الثلاث -->
                                            @if (Auth::id() === $evaluation->user_id)
                                                <div class="relative">
                                                    <button onclick="toggleDropdown('evaluation-{{ $evaluation->id }}')" class="text-gray-500 hover:text-gray-700">
                                                        ⁝
                                                    </button>
                                                    <div id="dropdown-evaluation-{{ $evaluation->id }}" class="hidden absolute right-0 mt-2 w-32 bg-white border border-gray-200 rounded-lg shadow-lg z-10">
                                                        <!-- تعديل -->
                                                        <button onclick="toggleEditForm('edit-evaluation-{{ $evaluation->id }}')" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                            تعديل
                                                        </button>
                                                        <!-- حذف -->
                                                        <form action="{{ route('teacher.evaluations.delete', $evaluation) }}" method="POST" onsubmit="return confirm('هل أنت متأكد من حذف التقييم؟')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
                                                                حذف
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="flex items-center space-x-1 mt-1">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <svg class="w-4 h-4 {{ $i <= $evaluation->rating ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.783-.57-.38-1.81.588-1.81h4.915a1 1 0 00.95-.69l1.519-4.674z"/>
                                                </svg>
                                            @endfor
                                            <span class="text-xs text-gray-500 ml-2">
                                                {{ $evaluation->created_at->format('d F Y') }}
                                            </span>
                                        </div>
                                        <p class="text-sm text-gray-600 mt-1">
                                            {{ $evaluation->comment ?? 'لا يوجد تعليق' }}
                                        </p>

                                        <!-- نموذج تعديل التقييم (مخفي في البداية) -->
                                        @if (Auth::id() === $evaluation->user_id)
                                            <div id="edit-evaluation-{{ $evaluation->id }}" class="hidden mt-2">
                                                <form action="{{ route('teacher.evaluations.update', $evaluation) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="flex items-center mb-2">
                                                        <div class="flex space-x-1">
                                                            @for ($i = 1; $i <= 5; $i++)
                                                                <label class="cursor-pointer">
                                                                    <input type="radio" name="rating" value="{{ $i }}" class="hidden" {{ $evaluation->rating == $i ? 'checked' : '' }} required>
                                                                    <svg class="w-6 h-6 {{ $i <= $evaluation->rating ? 'text-yellow-400' : 'text-gray-300' }} hover:text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.783-.57-.38-1.81.588-1.81h4.915a1 1 0 00.95-.69l1.519-4.674z"/>
                                                                    </svg>
                                                                </label>
                                                            @endfor
                                                        </div>
                                                    </div>
                                                    <textarea name="comment" class="w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 h-16 p-2 text-sm" placeholder="عدل تعليقك هنا...">{{ $evaluation->comment }}</textarea>
                                                    <div class="flex space-x-2 mt-2">
                                                        <button type="submit" class="bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700 text-sm">
                                                            حفظ
                                                        </button>
                                                        <button type="button" onclick="toggleEditForm('edit-evaluation-{{ $evaluation->id }}')" class="bg-gray-600 text-white px-3 py-1 rounded hover:bg-gray-700 text-sm">
                                                            إلغاء
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            @else
                                <p class="text-sm text-gray-600">لا توجد تقييمات بعد.</p>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- زر الرجوع -->
                <a href="{{ route('teacher.subjects.show', $subject) }}" class="mt-6 inline-block bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700 transition duration-300">
                    رجوع إلى الدورة
                </a>
            </div>
        </div>
    </div>

    <!-- JavaScript لتحديث لون النجوم عند الاختيار -->
    <script>
        // تحديث لون النجوم في نموذج التقييم
        document.querySelectorAll('input[name="rating"]').forEach((input) => {
            input.addEventListener('change', function () {
                const rating = parseInt(this.value);
                const stars = this.closest('.flex').querySelectorAll('svg');
                stars.forEach((star, index) => {
                    if (index < rating) {
                        star.classList.add('text-yellow-400');
                        star.classList.remove('text-gray-300');
                    } else {
                        star.classList.add('text-gray-300');
                        star.classList.remove('text-yellow-400');
                    }
                });
            });
        });

        // عرض/إخفاء القائمة المنسدلة
        function toggleDropdown(id) {
            const dropdown = document.getElementById('dropdown-' + id);
            if (dropdown.classList.contains('hidden')) {
                // إخفاء جميع القوائم الأخرى
                document.querySelectorAll('[id^="dropdown-"]').forEach((el) => el.classList.add('hidden'));
                dropdown.classList.remove('hidden');
            } else {
                dropdown.classList.add('hidden');
            }
        }

        // عرض/إخفاء نموذج التعديل
        function toggleEditForm(id) {
            const form = document.getElementById(id);
            if (form.classList.contains('hidden')) {
                form.classList.remove('hidden');
            } else {
                form.classList.add('hidden');
            }
        }

        // عرض/إخفاء نموذج الرد
        function toggleReplyForm(id) {
            const form = document.getElementById(id);
            if (form.classList.contains('hidden')) {
                form.classList.remove('hidden');
            } else {
                form.classList.add('hidden');
            }
        }

        // إغلاق القوائم المنسدلة عند النقر خارجها
        document.addEventListener('click', function (event) {
            if (!event.target.closest('[id^="dropdown-"]') && !event.target.closest('button[onclick^="toggleDropdown"]')) {
                document.querySelectorAll('[id^="dropdown-"]').forEach((el) => el.classList.add('hidden'));
            }
        });
    </script>
</x-app-layout>
