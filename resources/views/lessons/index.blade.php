@extends('layouts.app')

@section('title', 'الدروس')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-10">
    <h1 class="text-2xl font-bold text-green-700 mb-6">الدروس</h1>
    <div class="bg-white rounded-xl shadow p-6">
        <p>هنا ستجد قائمة الدروس المتاحة.</p>

        <ul class="list-disc list-inside mt-4">
            <li>درس 1: مقدمة في الفقه</li>
            <li>درس 2: العقيدة الإسلامية</li>
            <li>درس 3: السيرة النبوية</li>
        </ul>
    </div>
</div>
@endsection
