<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            تفاصيل الدورة: {{ $subject->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <h3 class="text-lg font-bold mb-4">{{ $subject->name }}</h3>

                {{-- ✅ زر إضافة درس جديد --}}
                <div class="mb-4">
                    <a href="{{ route('teacher.lessons.create', ['subject' => $subject->id]) }}"
                       class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded shadow">
                        + إضافة درس جديد
                    </a>
                </div>

                <h4 class="text-md font-semibold mb-2">الدروس</h4>
                <table class="w-full text-sm text-right">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3">العنوان</th>
                            <th scope="col" class="px-6 py-3">الوصف</th>
                            <th scope="col" class="px-6 py-3">رابط الفيديو</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($lessons as $lesson)
                            <tr class="bg-white border-b">
                                <td class="px-6 py-4">{{ $lesson->title }}</td>
                                <td class="px-6 py-4">{{ $lesson->description ?? 'لا يوجد وصف' }}</td>
                                <td class="px-6 py-4">
                                    @if ($lesson->videos->count())
                                        @foreach ($lesson->videos as $video)
                                            @if ($video->video_path)
                                                <video width="320" height="240" controls class="mb-2">
                                                    <source src="{{ asset('storage/' . $video->video_path) }}" type="video/mp4">
                                                    المتصفح لا يدعم تشغيل الفيديو.
                                                </video>
                                            @elseif ($video->video_url)
                                                <a href="{{ $video->video_url }}" class="text-indigo-600 hover:underline" target="_blank">مشاهدة</a>
                                            @endif
                                            <br>
                                        @endforeach
                                    @else
                                        لا يوجد فيديو
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                {{-- ✅ قسم التعليقات والتقييمات --}}
                <div class="mt-6">
                    <h4 class="text-md font-semibold mb-2">التعليقات والتقييمات</h4>
                    @foreach ($lessons as $lesson)
                        <div class="mb-4 p-4 bg-gray-100 rounded">
                            <h5 class="font-bold">{{ $lesson->title }}</h5>

                            {{-- التعليقات --}}
                            <div class="mt-2">
                                <h6 class="font-semibold">التعليقات:</h6>
                                @if ($lesson->comments->count())
                                    @foreach ($lesson->comments as $comment)
                                        <p class="text-sm">{{ $comment->user->first_name }} {{ $comment->user->last_name }}: {{ $comment->content }}</p>
                                    @endforeach
                                @else
                                    <p class="text-sm">لا توجد تعليقات</p>
                                @endif
                                <form action="{{ route('teacher.comments.store', [$subject, $lesson]) }}" method="POST" class="mt-2">
                                    @csrf
                                    <textarea name="content" class="w-full rounded-md border-gray-300 shadow-sm" placeholder="أضف تعليقًا"></textarea>
                                    @error('content')
                                        <span class="text-red-600 text-sm">{{ $message }}</span>
                                    @enderror
                                    <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded mt-2">إضافة تعليق</button>
                                </form>
                            </div>

                            {{-- التقييمات --}}
                            <div class="mt-4">
                                <h6 class="font-semibold">التقييمات:</h6>
                                @if ($lesson->evaluations->count())
                                    @foreach ($lesson->evaluations as $evaluation)
                                        <p class="text-sm">{{ $evaluation->user->first_name }} {{ $evaluation->user->last_name }}: {{ $evaluation->rating }}/5 - {{ $evaluation->comment ?? 'لا يوجد تعليق' }}</p>
                                    @endforeach
                                @else
                                    <p class="text-sm">لا توجد تقييمات</p>
                                @endif
                                <form action="{{ route('teacher.evaluations.store', [$subject, $lesson]) }}" method="POST" class="mt-2">
                                    @csrf
                                    <select name="rating" class="rounded-md border-gray-300 shadow-sm">
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                    </select>
                                    <textarea name="comment" class="w-full rounded-md border-gray-300 shadow-sm mt-2" placeholder="أضف تعليقًا (اختياري)"></textarea>
                                    @error('rating')
                                        <span class="text-red-600 text-sm">{{ $message }}</span>
                                    @enderror
                                    @error('comment')
                                        <span class="text-red-600 text-sm">{{ $message }}</span>
                                    @enderror
                                    <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded mt-2">إضافة تقييم</button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>

                <a href="{{ route('teacher.subjects') }}" class="bg-gray-600 text-white px-4 py-2 rounded mt-4 inline-block">
                    رجوع إلى قائمة الدورات
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
