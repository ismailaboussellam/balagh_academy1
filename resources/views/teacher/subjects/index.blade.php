<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            قائمة الدورات
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <a href="{{ route('teacher.subjects.create') }}"
                   class="bg-indigo-600 text-white px-4 py-2 rounded mb-6 inline-block hover:bg-indigo-700 transition duration-200">
                    إضافة دورة جديدة
                </a>

                @if (session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @forelse ($subjects as $subject)
                        <div class="bg-white border border-gray-200 rounded-lg shadow-md hover:shadow-lg transition duration-200">
                            <div class="p-4">
                                @if ($subject->image_path)
                                    <img src="{{ asset('storage/' . $subject->image_path) }}"
                                         alt="{{ $subject->name }}"
                                         class="w-full h-32 object-cover rounded-t-lg mb-2"
                                         onerror="this.onerror=null; this.src='https://via.placeholder.com/150';">
                                @else
                                    <div class="w-full h-32 bg-gray-200 rounded-t-lg flex items-center justify-center text-gray-500">لا يوجد صورة</div>
                                @endif
                                <h3 class="text-lg font-semibold text-gray-800 mb-2">
                                    {{ $subject->name }}
                                </h3>
                            </div>

                            <div class="p-4 flex justify-end space-x-3 border-t border-gray-200">
                                <a href="{{ route('teacher.subjects.show', $subject) }}"
                                   title="عرض التفاصيل"
                                   class="text-gray-600 hover:text-gray-800 transition duration-200">
                                    <i class="fas fa-eye text-lg"></i>
                                </a>
                                <a href="{{ route('teacher.subjects.edit', $subject) }}"
                                   title="تعديل"
                                   class="text-blue-600 hover:text-blue-800 transition duration-200">
                                    <i class="fas fa-edit text-lg"></i>
                                </a>
                                <form action="{{ route('teacher.subjects.delete', $subject) }}" method="POST" class="inline-block" onsubmit="return confirm('هل أنت متأكد من حذف الدورة؟')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            title="حذف"
                                            class="text-red-600 hover:text-red-800 transition duration-200">
                                        <i class="fas fa-trash-alt text-lg"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full text-center text-gray-500 py-6">
                            لا توجد دورات مسجلة.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
