<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            قائمة الدورات
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <a href="{{ route('teacher.subjects.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded mb-4 inline-block">
                    إضافة دورة جديدة
                </a>
                @if (session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                        {{ session('success') }}
                    </div>
                @endif
                <table class="w-full text-sm text-right">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3">اسم الدورة</th>
                            <th scope="col" class="px-6 py-3">الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($subjects as $subject)
                            <tr class="bg-white border-b">
                                <td class="px-6 py-4">
                                    <a href="{{ route('teacher.subjects.show', $subject) }}" class="text-indigo-600 hover:underline">
                                        {{ $subject->name }}
                                    </a>
                                </td>
                                <td class="px-6 py-4">
                                    <a href="{{ route('teacher.subjects.edit', $subject) }}" class="text-blue-600 hover:underline">تعديل</a>
                                    <form action="{{ route('teacher.subjects.delete', $subject) }}" method="POST" class="inline-block" onsubmit="return confirm('هل أنت متأكد من حذف الدورة؟')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:underline">حذف</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
