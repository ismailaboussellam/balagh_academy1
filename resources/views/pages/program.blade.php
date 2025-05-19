@extends('partials.myapp') {{-- ولا يمكن تغيرها حسب layout لي عندك --}}

@section('title', 'برنامج الدراسة - أكاديمية بلاغ')

@section('content')
<h2 class="text-3xl font-bold text-center mt-8 mb-8">
    برنامج الدراسة
    <div class="w-24 h-1 bg-blue-600 mx-auto mt-2 rounded"></div>
</h2>

<div class="space-y-8 max-w-6xl mx-auto">

    <!-- المستوى الأول -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="bg-blue-700 text-white text-lg font-bold text-center py-3">المستوى الأول</div>
        <table class="w-full text-center">
            <thead>
                <tr class="bg-blue-100 text-blue-900">
                    <th class="py-2">الفصل</th>
                    <th>الإثنين</th>
                    <th>الثلاثاء</th>
                    <th>الأربعاء</th>
                    <th>الخميس</th>
                    <th>الجمعة</th>
                    <th>السبت</th>
                    <th>الأحد</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="bg-blue-100 font-bold">الأول</td>
                    <td>السيرة</td>
                    <td>التجويد</td>
                    <td>التوحيد و العقيدة</td>
                    <td>النحو</td>
                    <td>-</td>
                    <td>الفقه</td>
                    <td>-</td>
                </tr>
                <tr>
                    <td class="bg-blue-100 font-bold">الثاني</td>
                    <td>السيرة</td>
                    <td>التجويد</td>
                    <td>التوحيد و العقيدة</td>
                    <td>النحو</td>
                    <td>-</td>
                    <td>الفقه</td>
                    <td>-</td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- المستوى الثاني -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="bg-blue-700 text-white text-lg font-bold text-center py-3">المستوى الثاني</div>
        <table class="w-full text-center">
            <thead>
                <tr class="bg-blue-100 text-blue-900">
                    <th class="py-2">الفصل</th>
                    <th>الإثنين</th>
                    <th>الثلاثاء</th>
                    <th>الأربعاء</th>
                    <th>الخميس</th>
                    <th>الجمعة</th>
                    <th>السبت</th>
                    <th>الأحد</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="bg-blue-100 font-bold">الأول</td>
                    <td>مصطلح الحديث</td>
                    <td>التجويد</td>
                    <td>التوحيد و العقيدة</td>
                    <td>النحو</td>
                    <td>-</td>
                    <td>الفقه</td>
                    <td>أصول الفقه</td>
                </tr>
                <tr>
                    <td class="bg-blue-100 font-bold">الثاني</td>
                    <td>مصطلح الحديث</td>
                    <td>التجويد</td>
                    <td>التوحيد و العقيدة</td>
                    <td>النحو</td>
                    <td>-</td>
                    <td>الفقه</td>
                    <td>أصول الفقه</td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- المستوى الثالث -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="bg-blue-700 text-white text-lg font-bold text-center py-3">المستوى الثالث</div>
        <table class="w-full text-center">
            <thead>
                <tr class="bg-blue-100 text-blue-900">
                    <th class="py-2">الفصل</th>
                    <th>الإثنين</th>
                    <th>الثلاثاء</th>
                    <th>الأربعاء</th>
                    <th>الخميس</th>
                    <th>الجمعة</th>
                    <th>السبت</th>
                    <th>الأحد</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="bg-blue-100 font-bold">الأول</td>
                    <td>الصرف</td>
                    <td>أصول التفسير</td>
                    <td>قراءة نافع</td>
                    <td>-</td>
                    <td>-</td>
                    <td>الفقه</td>
                    <td>-</td>
                </tr>
                <tr>
                    <td class="bg-blue-100 font-bold">الثاني</td>
                    <td>-</td>
                    <td>أصول التفسير</td>
                    <td>قراءة نافع</td>
                    <td>البلاغة</td>
                    <td>-</td>
                    <td>الفقه</td>
                    <td>-</td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- المستوى الرابع -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="bg-blue-700 text-white text-lg font-bold text-center py-3">المستوى الرابع</div>
        <table class="w-full text-center">
            <thead>
                <tr class="bg-blue-100 text-blue-900">
                    <th class="py-2">الفصل</th>
                    <th>الإثنين</th>
                    <th>الثلاثاء</th>
                    <th>الأربعاء</th>
                    <th>الخميس</th>
                    <th>الجمعة</th>
                    <th>السبت</th>
                    <th>الأحد</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="bg-blue-100 font-bold">الأول</td>
                    <td>مقاصد الشريعة</td>
                    <td>الفقه</td>
                    <td>قراءة نافع</td>
                    <td>تاريخ التشريع الإسلامي / الإلحاد</td>
                    <td>-</td>
                    <td>الفقه</td>
                    <td>-</td>
                </tr>
                <tr>
                    <td class="bg-blue-100 font-bold">الثاني</td>
                    <td>مقاصد الشريعة</td>
                    <td>الفقه</td>
                    <td>قراءة نافع</td>
                    <td>تاريخ التشريع الإسلامي / الإلحاد</td>
                    <td>-</td>
                    <td>الفقه</td>
                    <td>-</td>
                </tr>
            </tbody>
        </table>
        <div class="bg-blue-50 text-center py-4 text-lg font-semibold text-gray-700">
            مع إعداد بحث من عشرين صفحة
        </div>
    </div>
</div>

<!-- رابط التقويم الدراسي -->
<div class="flex justify-center mt-10 mb-16">
    <a href="{{ route('calendar') }}" class="inline-flex items-center px-6 py-3 bg-green-600 hover:bg-green-700 text-white text-lg font-bold rounded-lg shadow transition">
        الانتقال إلى صفحة التقويم الدراسي
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
    </a>
</div>

@endsection
