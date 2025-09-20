<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            إضافة درس جديد للدورة: {{ $subject->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <form method="POST" action="{{ route('teacher.lessons.store', $subject->id) }}" enctype="multipart/form-data">

                    @csrf

                    <!-- اختيار الدورة -->
                    <div class="mb-4">
                        <label for="subject_id" class="block text-sm font-medium text-gray-700">اختيار الدورة</label>
                        <select name="subject_id" id="subject_id"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">-- اختر الدورة --</option>
                            @foreach($subjects as $subject)
                                <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                            @endforeach

                        </select>
                        @error('subject_id')
                            <span class="text-red-600 text-sm">{{ $message }}</span>
                        @enderror
                    </div>


                    <!-- اختيار الفصل -->
                    <div class="mb-4">
                        <label for="fassl" class="block text-sm font-medium text-gray-700">اختيار الفصل</label>
                        <select name="fassl" id="fassl" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">-- اختر الفصل --</option>
                            <option value="1">الفصل الأول</option>
                            <option value="2">الفصل الثاني</option>
                        </select>
                        @error('fassl')
                            <span class="text-red-600 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- العنوان -->
                    <div class="mb-4">
                        <label for="title" class="block text-sm font-medium text-gray-700">العنوان</label>
                        <input type="text" name="title" id="title" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                        @error('title')
                            <span class="text-red-600 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- الوصف -->
                    <div class="mb-4">
                        <label for="description" class="block text-sm font-medium text-gray-700">الوصف</label>
                        <textarea name="description" id="description" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"></textarea>
                        @error('description')
                            <span class="text-red-600 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- نوع الدرس -->
                    <div class="mb-4">
                        <label for="lesson_type" class="block text-sm font-medium text-gray-700">نوع الدرس</label>
                        <select name="lesson_type" id="lesson_type" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">-- اختر نوع الدرس --</option>
                            <option value="quran">دروس تعليم القرآن الكريم</option>
                            <option value="tajweed">أحكام التجويد</option>
                            <option value="aqeeda">العقيدة</option>
                            <option value="arabic">دروس تعليم اللغة العربية</option>
                        </select>
                        @error('lesson_type')
                            <span class="text-red-600 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- باقي الحقول -->
                    <div class="mb-4">
                        <label for="video_url" class="block text-sm font-medium text-gray-700">رابط الفيديو (YouTube)</label>
                        <input type="text" name="video_url" id="video_url" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" placeholder="https://www.youtube.com/watch?v=...">
                        @error('video_url')
                            <span class="text-red-600 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="video_path" class="block text-sm font-medium text-gray-700">رفع فيديو (mp4)</label>
                        <input type="file" name="video_path" id="video_path" class="mt-1 block w-full">
                        @error('video_path')
                            <span class="text-red-600 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="document" class="block text-sm font-medium text-gray-700">رفع وثيقة (اختياري)</label>
                        <input type="file" name="document" id="document" class="mt-1 block w-full" accept=".pdf,.doc,.docx">
                        @error('document')
                            <span class="text-red-600 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="image" class="block text-sm font-medium text-gray-700">رفع صورة (اختياري)</label>
                        <input type="file" name="image" id="image" class="mt-1 block w-full" accept="image/*">
                        @error('image')
                            <span class="text-red-600 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700 transition">
                        حفظ الدرس
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
