<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            إضافة درس جديد للدورة: {{ $subject->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <form method="POST" action="{{ route('teacher.lessons.store', $subject) }}" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-4">
                        <label for="title" class="block text-sm font-medium text-gray-700">العنوان</label>
                        <input type="text" name="title" id="title" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                        @error('title')
                            <span class="text-red-600 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="description" class="block text-sm font-medium text-gray-700">الوصف</label>
                        <textarea name="description" id="description" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"></textarea>
                        @error('description')
                            <span class="text-red-600 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
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

                    <!-- حقل رفع الوثيقة (اختياري) -->
                    <div class="mb-4">
                        <label for="document" class="block text-sm font-medium text-gray-700">رفع وثيقة (اختياري)</label>
                        <input type="file" name="document" id="document" class="mt-1 block w-full" accept=".pdf,.doc,.docx">
                        @error('document')
                            <span class="text-red-600 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- حقل رفع الصورة (اختياري) -->
                    <div class="mb-4">
                        <label for="image" class="block text-sm font-medium text-gray-700">رفع صورة (اختياري)</label>
                        <input type="file" name="image" id="image" class="mt-1 block w-full" accept="image/*">
                        @error('image')
                            <span class="text-red-600 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded">
                        حفظ الدرس
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
