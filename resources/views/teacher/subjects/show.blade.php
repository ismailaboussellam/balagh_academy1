<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            تفاصيل الدورة: {{ $subject->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <h3 class="text-lg font-bold mb-6">{{ $subject->name }}</h3>

                <!-- زر إضافة درس -->
                <button class="bg-indigo-600 text-white px-4 py-2 rounded mb-6 hover:bg-indigo-700 transition duration-300"
                    onclick="document.getElementById('addLessonModal').showModal()">
                    + إضافة درس جديد
                </button>

                <!-- Modal لإضافة درس -->
                <dialog id="addLessonModal" class="modal">
                    <div class="modal-box">
                        <h3 class="font-bold text-lg mb-4">إضافة درس جديد</h3>
                        <form method="POST" action="{{ route('teacher.lessons.store', $subject) }}" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-4">
                                <label for="title" class="block text-sm font-medium text-gray-700">العنوان</label>
                                <input type="text" name="title" id="title" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                                @error('title') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                            </div>
                            <div class="mb-4">
                                <label for="description" class="block text-sm font-medium text-gray-700">الوصف</label>
                                <textarea name="description" id="description" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500"></textarea>
                                @error('description') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                            </div>
                            <div class="mb-4">
                                <label for="video_url" class="block text-sm font-medium text-gray-700">رابط الفيديو (YouTube)</label>
                                <input type="text" name="video_url" id="video_url" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500" placeholder="https://www.youtube.com/watch?v=...">
                                @error('video_url') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                            </div>
                            <div class="mb-4">
                                <label for="video_path" class="block text-sm font-medium text-gray-700">رفع فيديو (اختياري)</label>
                                <input type="file" name="video_path" id="video_path" class="mt-1 block w-full text-gray-700">
                                @error('video_path') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                            </div>
                            <div class="mb-4">
                                <label for="image_path" class="block text-sm font-medium text-gray-700">صورة الدرس (اختياري)</label>
                                <input type="file" name="image_path" id="image_path" class="mt-1 block w-full text-gray-700" accept="image/*">
                                @error('image_path') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                            </div>
                            <div class="modal-action">
                                <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">حفظ الدرس</button>
                                <button type="button" class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700" onclick="document.getElementById('addLessonModal').close()">إلغاء</button>
                            </div>
                        </form>
                    </div>
                </dialog>

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
                                <h4 class="text-md font-semibold text-gray-800 mb-3">{{ $lesson->title }}</h4>
                                <a href="{{ route('teacher.lessons.show', [$subject, $lesson]) }}" class="inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition duration-300">
                                    عرض التفاصيل
                                </a>
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
