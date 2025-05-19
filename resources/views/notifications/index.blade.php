@extends('layouts.app')

@section('title', 'الإشعارات')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-10">
    <h1 class="text-2xl font-bold text-green-700 mb-6">الإشعارات</h1>
    <div class="bg-white rounded-xl shadow p-6">
        <p>هنا ستظهر جميع الإشعارات الخاصة بك.</p>
        <!-- Example notifications -->
        <ul class="list-disc list-inside mt-4">
            <li>تم إضافة درس جديد في الفقه.</li>
            <li>تم فتح باب التسجيل للامتحان القادم.</li>
            <li>تم تحديث سياسة الخصوصية.</li>
        </ul>
    </div>
</div>
@endsection
