{{-- resources/views/teacher/dashboard.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            لوحة تحكم الأستاذ
        </h2>
    </x-slot>

    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
        <h3 class="text-lg font-bold mb-4">مرحبا أستاذ {{ Auth::user()->first_name }}</h3>

        <p class="text-gray-700">هنا يمكنك إدارة واجباتك ومتابعة غيابات المتدربين...</p>

        {{-- مستقبلاً تقدر تزيد هنا أقسام بحال: --}}
        {{-- @include('teacher.sections.stats') --}}
        {{-- @include('teacher.sections.absences') --}}
    </div>
</x-app-layout>
