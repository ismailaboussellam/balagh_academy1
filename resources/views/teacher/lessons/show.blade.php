<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            تفاصيل الدرس: {{ $lesson->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <!-- الصورة والفيديو -->
                <div class="mb-6">
                    @if ($lesson->image_path)
                        <img src="{{ asset('storage/' . $lesson->image_path) }}" alt="{{ $lesson->title }}" class="w-full h-64 object-cover rounded-lg mb-4">
                    @else
                        <img src="{{ asset('storage/lesson_images/default.jpg') }}" alt="{{ $lesson->title }}" class="w-full h-64 object-cover rounded-lg mb-4">
                    @endif

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

                <!-- تفاصيل الدرس -->
                <div class="space-y-4">
                    <h3 class="text-lg font-bold text-gray-800">{{ $lesson->title }}</h3>

                    <!-- زر الوصف -->
                    <button onclick="document.getElementById('descriptionModal{{ $lesson->id }}').showModal()" class="bg-gray-200 text-gray-800 px-4 py-2 rounded w-full text-center hover:bg-gray-300 transition duration-300">
                        الوصف
                    </button>

                    <!-- زر رابط الفيديو -->
                    <button onclick="document.getElementById('videoModal{{ $lesson->id }}').showModal()" class="bg-gray-200 text-gray-800 px-4 py-2 rounded w-full text-center hover:bg-gray-300 transition duration-300">
                        رابط الفيديو
                    </button>

                    <!-- زر الإجراءات -->
                    <button onclick="document.getElementById('actionsModal{{ $lesson->id }}').showModal()" class="bg-gray-200 text-gray-800 px-4 py-2 rounded w-full text-center hover:bg-gray-300 transition duration-300">
                        الإجراءات
                    </button>

                    <!-- زر التعليقات -->
                    <button onclick="document.getElementById('commentsModal{{ $lesson->id }}').showModal()" class="bg-gray-200 text-gray-800 px-4 py-2 rounded w-full text-center hover:bg-gray-300 transition duration-300">
                        التعليقات
                    </button>

                    <!-- زر التقييمات -->
                    <button onclick="document.getElementById('evaluationsModal{{ $lesson->id }}').showModal()" class="bg-gray-200 text-gray-800 px-4 py-2 rounded w-full text-center hover:bg-gray-300 transition duration-300">
                        التقييمات
                    </button>
                </div>

                <!-- Modal للوصف -->
                <dialog id="descriptionModal{{ $lesson->id }}" class="modal">
                    <div class="modal-box">
                        <h3 class="font-bold text-lg">الوصف: {{ $lesson->title }}</h3>
                        <p class="mt-2 text-gray-600">{{ $lesson->description ?? 'لا يوجد وصف' }}</p>
                        <div class="modal-action">
                            <button type="button" class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700" onclick="document.getElementById('descriptionModal{{ $lesson->id }}').close()">إغلاق</button>
                        </div>
                    </div>
                </dialog>

                <!-- Modal لرابط الفيديو -->
                <dialog id="videoModal{{ $lesson->id }}" class="modal">
                    <div class="modal-box">
                        <h3 class="font-bold text-lg">رابط الفيديو: {{ $lesson->title }}</h3>
                        @if ($lesson->videos->first()->video_url ?? false)
                            <a href="{{ $lesson->videos->first()->video_url }}" target="_blank" class="text-indigo-600 hover:underline">{{ $lesson->videos->first()->video_url }}</a>
                        @else
                            <p class="text-gray-600">لا يوجد رابط فيديو</p>
                        @endif
                        <div class="modal-action">
                            <button type="button" class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700" onclick="document.getElementById('videoModal{{ $lesson->id }}').close()">إغلاق</button>
                        </div>
                    </div>
                </dialog>

                <!-- Modal للإجراءات -->
                <dialog id="actionsModal{{ $lesson->id }}" class="modal">
                    <div class="modal-box">
                        <h3 class="font-bold text-lg">الإجراءات: {{ $lesson->title }}</h3>
                        <div class="space-y-2 mt-4">
                            <a href="{{ route('teacher.lessons.edit', [$subject, $lesson]) }}" class="block bg-blue-600 text-white px-4 py-2 rounded text-center hover:bg-blue-700 transition duration-300">تعديل</a>
                            <form action="{{ route('teacher.lessons.delete', [$subject, $lesson]) }}" method="POST" onsubmit="return confirm('هل أنت متأكد من حذف الدرس؟')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="block w-full bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 transition duration-300">حذف</button>
                            </form>
                        </div>
                        <div class="modal-action">
                            <button type="button" class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700" onclick="document.getElementById('actionsModal{{ $lesson->id }}').close()">إغلاق</button>
                        </div>
                    </div>
                </dialog>

                <!-- Modal للتعليقات -->
                <dialog id="commentsModal{{ $lesson->id }}" class="modal">
                    <div class="modal-box">
                        <h3 class="font-bold text-lg">التعليقات: {{ $lesson->title }}</h3>
                        <div class="mt-4 space-y-2">
                            @if ($lesson->comments->count())
                                @foreach ($lesson->comments as $comment)
                                    <div class="p-3 bg-gray-100 rounded-lg">
                                        <p class="text-sm font-semibold">{{ $comment->user->first_name }} {{ $comment->user->last_name }} ({{ $comment->user->role === 'teacher' ? 'أستاذ' : 'طالب' }}):</p>
                                        <p class="text-sm text-gray-600">{{ $comment->content }}</p>
                                    </div>
                                @endforeach
                            @else
                                <p class="text-sm text-gray-600">لا توجد تعليقات</p>
                            @endif
                            <button class="bg-indigo-600 text-white px-4 py-2 rounded mt-4 hover:bg-indigo-700 transition duration-300" onclick="document.getElementById('addCommentModal{{ $lesson->id }}').showModal()">
                                إضافة تعليق
                            </button>
                        </div>
                        <div class="modal-action">
                            <button type="button" class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700" onclick="document.getElementById('commentsModal{{ $lesson->id }}').close()">إغلاق</button>
                        </div>
                    </div>
                </dialog>

                <!-- Modal لإضافة تعليق -->
                <dialog id="addCommentModal{{ $lesson->id }}" class="modal">
                    <div class="modal-box">
                        <h3 class="font-bold text-lg">إضافة تعليق للدرس: {{ $lesson->title }}</h3>
                        <form action="{{ route('teacher.comments.store', [$subject, $lesson]) }}" method="POST">
                            @csrf
                            <textarea name="content" class="w-full rounded-md border-gray-300 shadow-sm mt-2 focus:ring-indigo-500 focus:border-indigo-500" placeholder="أضف تعليقًا"></textarea>
                            @error('content')
                                <span class="text-red-600 text-sm">{{ $message }}</span>
                            @enderror
                            <div class="modal-action">
                                <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">إضافة تعليق</button>
                                <button type="button" class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700" onclick="document.getElementById('addCommentModal{{ $lesson->id }}').close()">إلغاء</button>
                            </div>
                        </form>
                    </div>
                </dialog>

                <!-- Modal للتقييمات -->
                <dialog id="evaluationsModal{{ $lesson->id }}" class="modal">
                    <div class="modal-box">
                        <h3 class="font-bold text-lg">التقييمات: {{ $lesson->title }}</h3>
                        <div class="mt-4 space-y-2">
                            @if ($lesson->evaluations->count())
                                @foreach ($lesson->evaluations as $evaluation)
                                    <div class="p-3 bg-gray-100 rounded-lg">
                                        <p class="text-sm font-semibold">{{ $evaluation->user->first_name }} {{ $evaluation->user->last_name }} ({{ $evaluation->user->role === 'teacher' ? 'أستاذ' : 'طالب' }}):</p>
                                        <p class="text-sm text-gray-600">{{ $evaluation->rating }}/5 - {{ $evaluation->comment ?? 'لا يوجد تعليق' }}</p>
                                    </div>
                                @endforeach
                            @else
                                <p class="text-sm text-gray-600">لا توجد تقييمات</p>
                            @endif
                            <button class="bg-indigo-600 text-white px-4 py-2 rounded mt-4 hover:bg-indigo-700 transition duration-300" onclick="document.getElementById('addEvaluationModal{{ $lesson->id }}').showModal()">
                                إضافة تقييم
                            </button>
                        </div>
                        <div class="modal-action">
                            <button type="button" class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700" onclick="document.getElementById('evaluationsModal{{ $lesson->id }}').close()">إغلاق</button>
                        </div>
                    </div>
                </dialog>

                <!-- Modal لإضافة تقييم -->
                <dialog id="addEvaluationModal{{ $lesson->id }}" class="modal">
                    <div class="modal-box">
                        <h3 class="font-bold text-lg">إضافة تقييم للدرس: {{ $lesson->title }}</h3>
                        <form action="{{ route('teacher.evaluations.store', [$subject, $lesson]) }}" method="POST">
                            @csrf
                            <select name="rating" class="w-full rounded-md border-gray-300 shadow-sm mt-2 focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                            </select>
                            <textarea name="comment" class="w-full rounded-md border-gray-300 shadow-sm mt-2 focus:ring-indigo-500 focus:border-indigo-500" placeholder="أضف تعليقًا (اختياري)"></textarea>
                            @error('rating')
                                <span class="text-red-600 text-sm">{{ $message }}</span>
                            @enderror
                            @error('comment')
                                <span class="text-red-600 text-sm">{{ $message }}</span>
                            @enderror
                            <div class="modal-action">
                                <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">إضافة تقييم</button>
                                <button type="button" class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700" onclick="document.getElementById('addEvaluationModal{{ $lesson->id }}').close()">إلغاء</button>
                            </div>
                        </form>
                    </div>
                </dialog>

                <!-- زر الرجوع -->
                <a href="{{ route('teacher.subjects.show', $subject) }}" class="mt-6 inline-block bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700 transition duration-300">
                    رجوع إلى الدورة
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
