<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            قائمة الامتحانات
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if (session('success'))
                        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="mb-4">
                        <a href="{{ route('teacher.subjects') }}"
                           class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                            رجوع إلى الدورات
                        </a>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">العنوان</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">تاريخ الامتحان</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">الوصف</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">الوثيقة</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($exams as $exam)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-right">{{ $exam->title }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right">{{ $exam->exam_date }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right">{{ $exam->description ?? 'لا يوجد وصف' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right">
                                            @if ($exam->document_path)
                                                <a href="{{ asset('storage/' . $exam->document_path) }}" target="_blank" class="text-blue-500 hover:underline">عرض الوثيقة</a>
                                            @else
                                                لا توجد وثيقة
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right">
                                            <a href="{{ route('teacher.exams.edit', [$exam->subject_id, $exam->id]) }}"
                                               class="text-blue-500 hover:underline">تعديل</a>
                                            <form action="{{ route('teacher.exams.destroy', [$exam->subject_id, $exam->id]) }}" method="POST" class="inline-block mr-2" onsubmit="return confirm('هل أنت متأكد من حذف هذا الامتحان؟')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-500 hover:underline">حذف</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">لا توجد امتحانات مسجلة.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
