<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            عرض الدروس
        </h2>
    </x-slot>

    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
        <h3 class="text-lg font-bold mb-4">قائمة الدروس</h3>
        @forelse ($lessons as $lesson)
            <div class="flex items-center justify-between py-2">
                <span>{{ $lesson->title }}</span>
                <div>
                    <a href="{{ route('teacher.lessons.show', [$lesson->subject, $lesson]) }}" class="text-blue-500 hover:underline">عرض</a>
                    <a href="{{ route('teacher.lessons.edit', [$lesson->subject, $lesson]) }}" class="ml-4 text-green-500 hover:underline">تعديل</a>
                    <!-- زر حذف للدرس -->
                    <form action="{{ route('teacher.lessons.destroy', [$lesson->subject, $lesson]) }}" method="POST" class="inline-block ml-4" onsubmit="return confirm('هل أنت متأكد من حذف هذا الدرس؟');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-500 hover:underline">حذف الدرس</button>
                    </form>
                    <!-- زر حذف للمادة -->
                    <form action="{{ route('teacher.subjects.destroy', $lesson->subject) }}" method="POST" class="inline-block ml-4" onsubmit="return confirm('هل أنت متأكد من حذف هذه المادة؟');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-500 hover:underline">حذف المادة</button>
                    </form>
                </div>
            </div>
        @empty
            <p>لا توجد دروس مسجلة.</p>
        @endforelse
    </div>
</x-app-layout>
