@extends('partials.myapp') {{-- ولا يمكن تغيرها حسب layout لي عندك --}}

@section('title', 'النظام الأكاديمي - أكاديمية بلاغ')

@section('content')
    <br>
    <h1 class="text-3xl font-bold text-green-800 mb-8 text-center">🌿 النظام الأكاديمي - أكاديمية بلاغ للعلوم الشرعية</h1>

    <div class="max-w-3xl mx-auto space-y-6">
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-2xl font-semibold text-yellow-700 mb-2">📌 نبذة عن الأكاديمية</h2>
            <p>أكاديمية بلاغ منشأة تعليمية عالمية تُعنى بتيسير دراسة العلوم الشرعية عن بُعد، باعتماد <strong>منهج المذهب المالكي</strong> في الفقه وأصوله، وبالارتكاز على أمهات الكتب المعتمدة في المدرسة المالكية، مع استعمال أحدث الوسائل التقنية في التعليم.</p>
            <blockquote class="italic border-r-4 border-green-600 pr-4 mt-4 text-gray-600">
                "ليبلغن هذا الأمر ما بلغ الليل والنهار، ولا يترك الله بيت مدر ولا وبر إلا أدخله هذا الدين..."<br>
                <span class="text-sm">رواه أحمد</span>
            </blockquote>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-2xl font-semibold text-yellow-700 mb-2">🎯 أهداف الأكاديمية</h2>
            <ul class="list-disc list-inside space-y-1">
                <li>توفير تعليم شرعي أصيل وميسر للراغبين في طلب العلم، وخاصة الذين لا يستطيعون الالتحاق بالمعاهد الحضورية.</li>
                <li>اعتماد التعليم عن بُعد بمنهج منضبط على طريقة <strong>أهل المغرب المالكيين</strong>.</li>
                <li>تقديم مقررات علمية متكاملة ترتكز على الكتب المعتمدة في <strong>المذهب المالكي</strong>.</li>
            </ul>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-2xl font-semibold text-yellow-700 mb-2">🧑‍🏫 طريقة الدراسة</h2>
            <ul class="list-disc list-inside space-y-1">
                <li>مدة البرنامج أربع سنوات دراسية.</li>
                <li>فضاء إلكتروني خاص للطالب.</li>
                <li>دروس أسبوعية ولقاءات مباشرة كل فصل.</li>
                <li>شهادة نجاح من مركز إرشاد (غير حكومية).</li>
            </ul>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-2xl font-semibold text-yellow-700 mb-2">📘 البرامج والمقررات</h2>
            <ul class="list-disc list-inside space-y-1">
                <li>الفقه: المرشد المعين، رسالة ابن أبي زيد القيرواني.</li>
                <li>العقيدة: مقدمة الرسالة، أصول السنة لابن أبي زمنين.</li>
                <li>السيرة: الأرجوزة الميئية لابن أبي العز.</li>
                <li>أصول الفقه: شرح متن الورقات (بمنهج المالكية).</li>
                <li>اللغة العربية: الآجرومية، متممة الحطاب.</li>
                <li>التجويد: قواعد الأداء وتصحيح القراءة.</li>
                <li>مصطلح الحديث: نخبة الفكر.</li>
                <li>الصرف: باكورة التعريف.</li>
                <li>البلاغة: مائة المعاني والبيان.</li>
                <li>أصول التفسير: إتمام الدراية للسيوطي.</li>
                <li>قضايا معاصرة: أصول التشريع، الإلحاد، المقاصد (بمنظور مالكي).</li>
            </ul>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-2xl font-semibold text-yellow-700 mb-2">🖥️ نظام الدراسة</h2>
            <ul class="list-disc list-inside space-y-1">
                <li>رفع أسبوعي للدروس عبر المنصة.</li>
                <li>لقاءات مباشرة فصلية.</li>
                <li>مرونة في متابعة التسجيلات.</li>
                <li>التزام بالحضور في التجويد واللقاءات الحية.</li>
                <li>إمكانية الدفع السنوي أو الفصلي.</li>
            </ul>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-2xl font-semibold text-yellow-700 mb-2">📝 نظام الامتحانات</h2>
            <ul class="list-disc list-inside space-y-1">
                <li>تُجرى عن بُعد باحترام الأمانة العلمية.</li>
                <li>نشر الأسئلة أسبوعيًا وتصحيح آلي أو يدوي.</li>
                <li>احتساب المعدلات وانتقال مشروط بـ10/20 كمعدل عام.</li>
            </ul>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-2xl font-semibold text-yellow-700 mb-2">📌 شروط الالتزام</h2>
            <ul class="list-disc list-inside space-y-1">
                <li>الأدب الشرعي في النقاشات.</li>
                <li>احترام المواعيد والرسوم.</li>
                <li>عدم نشر محتوى الدروس خارجيًا.</li>
                <li>الحد الأدنى للعمر: 16 سنة.</li>
            </ul>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-2xl font-semibold text-yellow-700 mb-2">❌ أسباب الفصل</h2>
            <ul class="list-disc list-inside space-y-1">
                <li>الإساءة للدين أو العلماء.</li>
                <li>الألفاظ غير اللائقة.</li>
                <li>الإخلال بالشروط أو عدم الالتزام المالي.</li>
            </ul>
        </div>
    </div>
@endsection
