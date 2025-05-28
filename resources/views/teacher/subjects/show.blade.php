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

                <a href="{{ route('teacher.subjects') }}" class="bg-gray-600 text-white px-4 py-2 rounded mt-4 inline-block">
                    رجوع إلى قائمة الدورات
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
